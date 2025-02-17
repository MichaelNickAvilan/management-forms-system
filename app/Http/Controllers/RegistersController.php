<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Builder;
Use App\Companies;
Use App\Systems;
Use App\Forms;
Use App\Fields;
Use App\Registers;
Use App\Values;
use Auth;
use \stdClass;
use Session;

class RegistersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request = null)
    {
        $referrer = parse_url(url()->previous(), PHP_URL_QUERY);
        parse_str($referrer, $params);
        $user = Auth::user();
        if(isset($params['email'])){
            if($params['email'] != $user->email){
                if($user->type == 2){
                    return redirect(RouteServiceProvider::HOME.'/'.$user->id);
                }
            }
        }

        $id_form = 0;
        $conditions = $this->getUserConditions();
        if(isset($_GET['system']) && isset($_GET['form'])){
            $systems = Systems::withWhereHas('forms', fn($query) => 
                $query->where('id_form', '=', $_GET['form'])  
            )
            ->where($conditions)
            ->get();
        }else{
            $systems = Systems::with('forms')
            ->where($conditions)
            ->get();
        }
        
        for($i=0;$i<count($systems);$i++){
            for($j=0;$j<count($systems[$i]->forms);$j++){
                $systems[$i]->forms[$j]->fields =
                Fields::where('id_form', '=', $systems[$i]->forms[$j]->id_form )->get();
            }
        }
        if(count($_GET)>0 && (isset($_GET['id_form']) || isset($_GET['form']))){
            $id_form = null;
            
            if(isset($_GET['id_form'])){
                $id_form = $_GET['id_form'];
            }            
            for($i=0;$i<count($systems);$i++){
                for($j=0;$j<count($systems[$i]->forms);$j++){
                    if($systems[$i]->forms[$j]->id_form == $id_form){
                        $current_system = $systems[$i];
                        $current_form = $systems[$i]->forms[$j];
                        $fields = Fields::where('id_form', '=', $id_form)->get();
                        $fields = $this->cleanFieldsNames($fields);
                        if(isset($_GET['email'])){
                            $conds = array();
                            $values = Values::where('value_register', '=', $_GET['email'])->get();
                            foreach($values as $value){
                                array_push($conds, $value->id_register);
                            }
                            if($user->type == 1 || $user->type == 6 || $user->type == 2 || $user->type == 5){
                                $registers = Registers::where('id_form', '=', $id_form )
                                ->whereIn('id_register', $conds)->with('values')->get();
                            }else{
                                $registers = Registers::where('id_form', '=', $id_form )
                                ->whereIn('id_register', $conds)->with('values')
                                ->where('created_by', '=', $user->id)->get();
                            }
                            return view('core/registers/list_registers',
                            compact('systems', 'fields', 'registers', 'current_form', 'current_system'));
                        }else{
                            if($user->type == 1 || $user->type == 6 || $user->type == 5){
                                $registers = Registers::where('id_form', '=', $id_form )->with('values')->orderBy('id_register', 'desc')->get();
                            }else{
                                if($user->type!=2){
                                    $registers = Registers::where('id_form', '=', $id_form )->with('values')
                                    ->where('created_by', '=', $user->id)->get();
                                }else{
                                    return redirect(RouteServiceProvider::HOME.'/'.$user->id);
                                }
                            }
                            return view('core/registers/list_registers',
                            compact('systems', 'fields', 'registers', 'current_form', 'current_system'));
                        }
                    }
                }
            }
        }else{
            if($user->type!=2){
                return view('core/registers/list_registers', compact('systems'));
            }else{
                return redirect(RouteServiceProvider::HOME.'/'.$user->id);
            }
        }
    }

    private function cleanFieldsNames($fields){
        $temp = [];
        for($i=0;$i<count($fields);$i++){
            array_push($temp, $fields[$i]);
        }
        return $temp;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $conditions = $this->getUserConditions();
        $form_id = null;
        $forms = array();
        $systems = null;
        if(isset($_GET['system']) && isset($_GET['form'])){
            $systems = Systems::withWhereHas('forms', fn($query) => 
                $query->where('id_form', '=', $_GET['form'])  
            )
            ->get();
        }else{
            $systems = Systems::with('forms')
            ->where($conditions)
            ->get();
        }
        for($i=0;$i<count($systems);$i++){
            for($j=0;$j<count($systems[$i]->forms);$j++){
                $systems[$i]->forms[$j]->fields =
                Fields::where('id_form', '=', $systems[$i]->forms[$j]->id_form )->get();
                $systems[$i]->forms[$j]->regs = $this->countRegsByForm( $systems[$i]->forms[$j]->id_form );
                if($systems[$i]->forms[$j]->regs == 1){
                    $systems[$i]->forms[$j]->registers = Registers::with('values')
                    ->where('id_form', '=', $systems[$i]->forms[$j]->id_form)
                    ->where('created_by', '=', $user->id)
                    ->first();
                }
                if($form_id!=null){
                    if($form_id == $systems[$i]->forms[$j]->id_form){
                        array_push($forms, $systems[$i]->forms[$j]);
                    }
                }
            }
        }
        return view('core/registers/create_register', compact('systems'));
    }
    public function importRegisters(){
        return view('core/registers/import_registers');
    }
    private function configureDynamicFields($fields){
        foreach($fields as $field){
            if($field['settings_field'] != NULL){
                if(json_decode($field['settings_field'])->type === 'dynamic_combo'){
                    $source = json_decode($field['settings_field'])->settings->source;
                    $options = DB::table($source->table)->select($source->required_fields)->get();
                }
            }
        }
    }
    private function countRegsByForm($id_form){
        $user = Auth::user();
        $conditions = array();
        array_push($conditions, ['id_form', $id_form]);
        array_push($conditions, ['created_by', $user->id]);
        $regs = Registers::where($conditions)
        ->count();
        return $regs;
    }
    private function getUserConditions(){
        $user = Auth::user();
        $conditions = array();
        array_push($conditions, ['id_company',Auth::user()->company]);
        if(Auth::user()->type == 5 || Auth::user()->type == 2 || Auth::user()->type == 6){
            if(Auth::user()->country === 'Brazil'){
                array_push($conditions, ['id_system', [13, 14]]);
            }else{
                array_push($conditions, ['id_system', [12, 14]]);
            }
        }
        return $conditions;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if(isset( $request['608_text_area'] ) && isset( $request['760_text_area'] )){
            if($request['608_text_area'] === null){
                $request['608_text_area'] = '';
            }
            if($request['760_text_area'] === null){
                $request['760_text_area'] = '';
            }
        }

        if(isset($request->fields_txt)){
            $req = json_decode($request->fields_txt);
            $lowlight_results = DB::select( DB::raw(
                "UPDATE franchise.values
                SET value_register = '".$request->lowlights."'
                WHERE id_field IN (".implode(',', $req->lowlight_fields).")
                AND id_register IN (".implode(',', $req->registers).");"
                ) 
            );
            $highlight_results = DB::select( DB::raw(
                "UPDATE franchise.values
                SET value_register = '".$request->highlights."'
                WHERE id_field IN (".implode(',', $req->highlight_fields).")
                AND id_register IN (".implode(',', $req->registers).");"
                ) 
            );
            return redirect()->back()->with('success', 'El plan de acción se ha registrado correctamente.');   
        }else{
            $eval_centinel = false;
            $centinel = true;
            
            if($user->type == 2){
                if( $request['776_text'] == $user->id ){
                    $eval_centinel = true;
                }else{
                    return redirect(RouteServiceProvider::HOME.'/'.$user->id);
                }
            }else{
                $eval_centinel = true;
            }
            if($eval_centinel == true){
                if(count($_FILES)>0){
                    if($request->type === 'massive_replacement'){
                        $centinel = false;
                        $tmp_name = '';
                        $iterator = 0 ;
                        $conditions = array();
                        DB::table('values')->delete();
                        DB::table('registers')->where('id_form', '34')->delete();
                        foreach($_FILES as $file){
                            $tmp_name = fopen($file['tmp_name'], 'r');
                        }
                        while (($data = fgetcsv($tmp_name, 1000, ",")) !== FALSE){
                            if($iterator === 0){
                                $iterator ++;
                            }else{
                                $register=new Registers();
                                $register->id_form = '34';
                                $register->created_by = Auth::id();
                                $register->save();
                                foreach($data as $key=>$field){
                                    $value = new Values();
                                    $value->id_register = $register->id_register;
                                    $value->created_by = Auth::id();
                                    switch($key){
                                        case 0:
                                            $value->id_field = 1;
                                            $value->value_register = $field;
                                        break;
                                        case 1:
                                            $value->id_field = 2;
                                            $value->value_register = $field;
                                        break;
                                        case 2:
                                            $value->id_field = 3;
                                            $value->value_register = $field;
                                        break;
                                        case 3:
                                            $value->id_field = 4;
                                            $value->value_register = $field;
                                        break;
                                        case 4:
                                            $value->id_field = 5;
                                            $value->value_register = $field;
                                        break;
                                        case 5:
                                            $value->id_field = 6;
                                            $value->value_register = $field;
                                        break;
                                    }
                                    $value->save();
                                }
                            }
                        }
                    }
                }
                if($centinel){
                    $register=new Registers();
                    $register->id_form = $request->id_form;
                    $register->created_by = Auth::id();
                    $register->save();
                    $keys = array_keys((array)$request->all());
                    
                    foreach($keys as $key){
                        if(\strrpos($key, '_')>0){
                            if( \explode('_', $key)[0] !='id' ){
                                $value = new Values();
                                $value->id_register = $register->id_register;
                                $value->id_field = \explode('_', $key)[0];
                                $value->value_register = $request[$key];
                                $value->created_by = Auth::id();
                                if(\strrpos($key, '_image')>0){
                                    $file_name = $register->id.'_'.uniqid().'_register.'.$request[$key]->extension();
                                    $request[$key]->storeAs('registers', $file_name);
                                    $value->value_register = $file_name;
                                }
                                if($value->id_field!='st'){   
                                    $value->save();
                                }
                            }
                        }
                    }
                }
                
                if(isset($request->external)){
                    Session::flash('message', "Se ha insertado el registro correctamente");
                    return \Redirect::back();
                }else{
                    if(isset($request->type)){
                        if($request->type === 'massive_replacement'){
                            return redirect('registers')->
                            with('success', 'Se han importado los registros correctamente.');
                        }
                    }else{
                        $referrer = parse_url(url()->previous(), PHP_URL_QUERY);
                        parse_str($referrer, $params); 
                        if(isset($params['system']) && isset($params['form'])){
                            //This is for redirecting the user to its profile after accepting an evaluation
                            if(isset($request['776_text'])){
                                return redirect('users/'.$request['776_text'])->
                                        with('success', 'Se ha agregado el registro correctamente.');
                            }else{
                                return redirect('users/'.$params['user_id'])->with('success', 'Se ha agregado el registro correctamente.');
                            }
                        }else{
                            return redirect('users/'.$params['user_id'])->with('success', 'Se ha agregado el registro correctamente.');
                        }
                    }
                }
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $centinel = false;
        if($user->type == 2){
            return redirect(RouteServiceProvider::HOME.'/'.$user->id);
        }else{
            $register = Registers::with('values')->where('id_register', '=', $id)->first();
            $form = Forms::where('id_form', '=', $register->id_form )->with('fields')->first();
            $system = Systems::where('id_system', '=', $form->id_system)->first();
            return view('core/registers/profile_register', compact('register','form','system'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $centinel = false;
        if( isset($_GET['user_id']) ){
            if($_GET['user_id'] == $user->id){
                $centinel = true;
            }else{
                if($user->type == 2){
                    return redirect(RouteServiceProvider::HOME.'/'.$user->id);
                }else{
                    $centinel = true;
                }
            }
        }else{
            $centinel = true;
        }
        if( $centinel ){
            if( $user->type == 1 ||  $user->type == 5){
                $register = Registers::with('values')->where('id_register', '=', $id)->first();
                $form = Forms::where('id_form', '=', $register->id_form )->with('fields')->first();
                $system = Systems::where('id_system', '=', $form->id_system)->first();
                return view('core/registers/update_register', compact('register','form','system'));
            }else{
                return redirect(RouteServiceProvider::HOME.'/'.$user->id);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $keys = array_keys((array)$request->all());
        foreach($keys as $key){
            if(\strrpos($key, '_')>0){
                if( \explode('_', $key)[0] !='id' ){
                    $value = Values::where('id_register', '=', $id)
                    ->where('id_field', '=', \explode('_', $key)[0])->first();
                    if($value!=null){
                        $value->updated_by = Auth::id();
                        if(\strrpos($key, '_image')>0){
                            $file_name = $id.'_'.uniqid().'_register.'.$request[$key]->extension();
                            $request[$key]->storeAs('registers', $file_name);
                            $value->value_register = $file_name;
                        }else{
                            $value->value_register = $request[$key];
                        }
                        var_dump($value->id_field);
                        if($value->id_field!='st'){   
                            $value->save();
                        }
                    }else{
                        $val = new Values();
                        $val->id_register = $id;
                        $val->id_field = \explode('_', $key)[0];
                        $val->value_register = $request[$key];
                        $val->created_by = Auth::id();
                        if(\strrpos($key, '_image')>0){
                            $file_name = $val->id_register.'_'.uniqid().'_register.'.$request[$key]->extension();
                            $request[$key]->storeAs('registers', $file_name);
                            $val->value_register = $file_name;
                        }
                        if($val->id_field!='st'){
                            $val->save();
                        }
                    }
                }
            }
        }
        $referrer = parse_url(url()->previous(), PHP_URL_QUERY);
        parse_str($referrer, $params); 
        return redirect('registers/'.$id)->
        with('success', 'Se ha actualizado el registro correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(stripos($id, "_form")!=false){
            $id_form = str_replace('_form','',$id);
            $registers = Registers::where('id_form', '=', $id_form)->get();
            foreach($registers as $reg){
                $this->deleteRegister($reg->id_register);
            }
            return '{ "status" : "success" }';
        }else{
            $this->deleteRegister($id);
        }
        $referrer = parse_url(url()->previous(), PHP_URL_QUERY);
        parse_str($referrer, $params); 
        if(isset($params['system']) && isset($params['form'])){
            return redirect('registers?system='.$params['system'].'&form='.$params['form'])->
            with('success', 'Se ha eliminado el registro correctamente.');
        }else{
            return redirect('registers')->with('success','El registro ha sido eliminado del sistema');
        }
    }
    private function deleteRegister($id_register){
        $values=Values::where('id_register', '=', $id_register)->get();
        foreach($values as $value){
            $value->delete();
        }
        $register=Registers::find($id_register);
        $register->delete();
        return redirect('registers')->with('success','El registroa ha sido eliminado del sistema');
    }
}
