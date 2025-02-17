<?php

namespace App\Http\Controllers;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
Use App\Companies;
Use App\Systems;
Use App\Forms;
Use App\Fields;
use Auth;

class FieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->type == 4){
            return redirect(RouteServiceProvider::HOME_INTRANET);
        }

        $fields = Fields::with('form')->orderBy('id_field', 'DESC')->get();
        $items = array();

        for($i=0;$i<count($fields);$i++){
            $fields[$i]['system'] = Systems::find($fields[$i]->form->id_system);
            if($fields[$i]['system']->id_company == $user->company){
                array_push($items, $fields[$i]);
            }
        }

        $fields = $items;
        return view('core/fields/list_fields', compact('fields'));
    }
    private function getFieldTypes(){
        $types = '[
            { "label":"Texto", "value":"text" },
            { "label":"Área de texto", "value":"text_area" },
            { "label":"Texto enriquecido", "value":"rich_text" },
            { "label":"Número", "value":"number" },
            { "label":"Fecha", "value":"date" },
            { "label":"Imagen", "value":"image" },
            { "label":"Archivo", "value":"file" }
        ]';
        return json_decode($types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $systems = Systems::with('forms')->where('id_company','=',$user->company)->get();
        $types = $this->getFieldTypes();
        return view('core/fields/create_field', compact('systems'), compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_system' => 'required',
            'id_form' => 'required',
            'type_field' => 'required',
            'name_field' => 'required',
            'description_field' => 'required',
            'settings_field' => 'required'
        ]);
        $field=new Fields();
        $field->id_form=$request->id_form;
        $field->type_field=$request->type_field;
        $field->name_field=$request->name_field;
        $field->description_field=$request->description_field;
        $field->settings_field=$request->settings_field;
        $field->created_by = Auth::id();
        $field->save();
        return redirect('fields')->
        with('success', 'Se ha agregado el campo '.$field->name_field.' correctamente.');
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $field = Fields::find($id);
        $form = Fields::find($id)->form;
        $system = Systems::find($form->id_system);
        return view('core/fields/profile_field',compact('field','id', 'form', 'system'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field=Fields::find($id);
        $form = Fields::find($id)->form;
        $systems = Systems::with('forms')->get();
        $types = $this->getFieldTypes();
        return view('core/fields/update_field', compact('field', 'id', 'types', 'systems', 'form'));
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
        $field=Fields::find($id);
        $field->id_form=$request->id_form;
        $field->type_field=$request->type_field;
        $field->name_field=$request->name_field;
        $field->description_field=$request->description_field;
        $field->settings_field=$request->settings_field;
        $field->updated_by = Auth::id();
        $field->save();
        $form = Fields::find($id)->form;
        $system = Systems::find($form->id_system);
        return view('core/fields/profile_field',compact('field','id', 'form', 'system'))->
        with('success', 'Se ha actualizado el campo '.$field->name_field.' correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fields=Fields::find($id);
        $fields->delete();
        return redirect('fields')->with('success','El campo ha sido eliminado del sistema');
    }
}
