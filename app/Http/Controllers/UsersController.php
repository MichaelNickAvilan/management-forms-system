<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;
use \stdClass;
Use App\Users;
use Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_user = Auth::user();
        if($current_user->type == 1 || $current_user->type == 6){
            $users = Users::all()->where('type','!=','1');
            return view('core/users/list-users', compact('users'));
        }else{
            if($current_user->type != 2){
                $users = Users::where('store', '=', $current_user->store)
                ->get();
                return view('core/users/list-users', compact('users'));
            }else{
                return redirect(RouteServiceProvider::HOME.'/'.$current_user->id);           
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $current_user = new stdClass();
        $current_user->country = $user->country;
        $current_user->type = $user->type;
        $current_user->store = $user->store;
        $countries = $this->_getStores();
        if(isset($_GET["import"])){
            return view('core/users/import-users');
        }else{
            return view('core/users/create-user', compact('current_user', 'countries'));
        }
    }

    private function _getStores(){
        $items = Array();
        $countries = Users::select('country')->distinct()->get();
        foreach ($countries as $country) {
            $item = new stdClass();
            $item->country = $country;
            $item->stores = array();
            if($country->country != null && $country->country != ''){
                $stores = Users::select('store')->where('country',$country->country)->distinct()->get();
                array_push($item->stores, $stores);
                array_push($items, $item);
            }
        }
        return $items;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(count($_FILES)>0){
            $tmp_name = '';
            $iterator = 0 ;
            $conditions = array();
            foreach($_FILES as $file){
                $tmp_name = fopen($file['tmp_name'], 'r');
            }
            while (($data = fgetcsv($tmp_name, 1000, ",")) !== FALSE)
            {
                if($iterator === 0){
                    $iterator ++;
                }else{
                    $count = $this->userExist($data[3]);
                    if($count === 0){
                        $user=new Users();
                        $user->document=$data[3];
                        $user->country=$data[1];
                        
                        switch($data[2]){
                            case 'Sales':
                                $user->type=4;
                            break;
                            case 'Assistant Store Manager':
                                $user->type=5;
                            break;
                            case 'Store Manager':
                                $user->type=5;
                            break;
                            case 'Team Leader':
                                $user->type=5;
                            break;
                            case 'Stockroom':
                                $user->type=6;
                            break;
                            case 'Digital Champ':
                                $user->type=7;
                            break;
                            case 'In-store Coach':
                                $user->type=8;
                            break;
                            case 'Cashier':
                                $user->type=9;
                            break;
                        }

                        $user->name=$data[6];
                        $user->last_name=$data[7];
                        $user->company = Auth::user()->company;
                        $user->password=bcrypt( $user->document );
                        $user->store=$data[5];
                        $user->email=  $data[3].'_'.
                        strtolower(str_replace(' ', '', $user->name)).'_'.
                        strtolower(str_replace(' ', '', $user->last_name)).
                        '@adidas.com';
                        $user->created_by = Auth::id();
                        $user->save();
                    }else{
                        $affected = DB::table('users')
                        ->where('document', $data[1])
                        ->update(
                            [ 
                                'name' => $data[2], 
                                'last_name' => $data[1],
                                'email' => $data[2],
                                'password' => bcrypt($data[1])
                        ]);
                    }
                    $iterator ++;
                }
            }
            return redirect('users')->
            with('success', 'Se han procesado '.$iterator.' usuarios correctamente.');
        }else{
            $request->validate([
                'name' => 'required',
                'last_name' => 'required'

            ]);
            $user=new Users();
            $user->name=$request->name;
            $user->last_name=$request->last_name;
            $user->email=$request->email;
            $user->document=$request->document;
            $user->type=$request->type;
            $user->country=$request->country;
            $user->store=$request->store;
            $user->company = Auth::user()->company;
            $user->password=bcrypt( $request->password );
            $user->created_by = Auth::id();
            $user->save();
            return redirect('users')->
            with('success', 'Se ha agregado el usuario '.$user->email.' correctamente.');
        }
    }
    private function userExist($document){
        $count = DB::table('users')
        ->where('document', '=', $document)
        ->count();
        return $count;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $current_user = Auth::user();
        $geo_data = $this->getGeoData();
        if( $id != "all" ){
            if( $current_user->type !=2 || $current_user->type !=3 ){
                if($current_user->type == 1){
                    $user = Users::find($id);
                    $registers = $this->getUserProfile($user);
                    return view('core/users/profile-user', compact('user', 'registers', 'geo_data'));
                }else{
                    $user = Users::find($id);
                    if($user->store === $current_user->store){
                        $registers = $this->getUserProfile($user);
                        return view('core/users/profile-user', compact('user', 'registers', 'geo_data'));
                    }else{
                        return Redirect::route('users.index');
                    }
                }
            }else{
                if( $current_user->type == 2){
                    return redirect(RouteServiceProvider::HOME.'/'.$current_user->id);
                }else{
                    $user  = Users::find($id);
                    $registers = $this->getUserProfile($user);
                    return view('core/users/profile-user', compact('user', 'registers', 'geo_data'));
                }
            }
        }else{
            if( $current_user->type !== 1 && $current_user->type !== 5 && $current_user->type !== 6 ){
                return redirect(RouteServiceProvider::HOME.'/'.$current_user->id);
            }else{
                $registers = $this->getUserProfile($id);
                return view('core/users/profile-user', compact('registers', 'geo_data'));
            }
        }
    }
    private function getGeoData(){
        $current_user = Auth::user();
        if($current_user->type ===1 || $current_user->type ===6 || $current_user->type ===5){
            if($current_user->type ===1 || $current_user->type ===6){
                $results = DB::select( DB::raw(
                    "SELECT DISTINCT id, name, last_name, 
                    email, country, store 
                    FROM franchise.users;"
                    ) 
                );
            }else{
                $results = DB::select( DB::raw(
                    "SELECT DISTINCT id, name, last_name, 
                    email, country, store 
                    FROM franchise.users
                    WHERE store = '".$current_user->store."';"
                    ) 
                );
            }
        }else{
            $results = DB::select( DB::raw(
                "SELECT DISTINCT id, name, last_name, 
                email, country, store 
                FROM franchise.users
                WHERE id = '".$current_user->id."';"
                ) 
            );
        }
        return $results;
    }
    private function getUserProfile($user){
        $current_user = Auth::user();
        if($user != "all"){
            $results = DB::select( DB::raw(
                "SELECT * FROM hierarchical_values
                WHERE
                id_register IN (
                SELECT id_register FROM hierarchical_values
                WHERE 
                value_register = '".$user->email."'
                AND id_system IN ".$this->getUserConditions()."
                )
                ORDER BY id_form DESC;") 
            );
        }else{
            if($current_user->type !=1 && $current_user->type !=6){
                $results = DB::select( DB::raw(
                    "SELECT * FROM hierarchical_values
                    WHERE
                    id_register IN (
                    SELECT id_register FROM hierarchical_values
                    WHERE 
                    id_system IN ".$this->getUserConditions()."
                    AND store = '".$current_user->store."'
                    )
                    ORDER BY id_form DESC;") 
                );
            }else{
                $results = DB::select( DB::raw(
                    "SELECT * FROM hierarchical_values
                    WHERE
                    id_register IN (
                    SELECT id_register FROM hierarchical_values
                    WHERE 
                    id_system IN ".$this->getUserConditions()."
                    )
                    ORDER BY id_form DESC;") 
                );
            }
        }
        return $results;
    }
    private function getUserConditions(){
        $user = Auth::user();
        $conditions = "";
        if(Auth::user()->type == 5 || Auth::user()->type == 2  || Auth::user()->type == 1 || Auth::user()->type == 6){
            if(Auth::user()->country === 'Brazil'){
                $conditions = '(13, 14)';
            }else{
                $conditions = '(12, 14)';
            }
        }
        return $conditions;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $current_user = Auth::user();
        if($current_user->type != 2){
            if($current_user->type == 5){
                $user = Users::find($id);
                if($user->store == $current_user->store){
                    $countries = $this->_getStores();
                    return view('core/users/update-user', compact('user'))->with('countries',$countries);
                }else{
                    return Redirect::route('users.index');
                }
            }else{
                $user = Users::find($id);
                $countries = $this->_getStores();
                return view('core/users/update-user', compact('user'))->with('countries',$countries);
            }
        }else{
            return redirect(RouteServiceProvider::HOME.'/'.$current_user->id);           
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
        $request->validate([
            'name' => 'required',
            'last_name' => 'required'

        ]);
        $user=Users::find($id);
        $user->name=$request->name;
        $user->last_name=$request->last_name;
        $user->type=$request->type;
        if(isset($request->document)){
            $user->document=$request->document;
        }
        if(isset($request->email)){
            $user->email=$request->email;
        }
        if(isset($request->country)){
            $user->country=$request->country;
        }
        if(isset($request->store)){
            $user->store=$request->store;
        }
        if(isset($request->password)){
            $user->password=bcrypt( $request->password );
        }
        
        $user->created_by = Auth::id();
        $user->save();
        return redirect('users')->
        with('success', 'Se ha actualizado el usuario '.$user->name.' correctamente.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=Users::find($id);
        $user->email= $user->email."@_DISABLED";
        $user->password=bcrypt(  Str::random(9)  );
        $user->save();
        return redirect('users')->
        with('success', 'Se ha deshabilitado el usuario '.$user->name.' correctamente.');
    }
}
