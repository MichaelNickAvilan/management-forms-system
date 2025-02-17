<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Providers\RouteServiceProvider;
Use App\Companies;
Use App\Systems;
Use App\Forms;
use Auth;
class FormsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $forms = Forms::whereHas('system', function($q) {
            $user = Auth::user();
            $q->where('id_company', $user->company);
        })->get();

        return view('core/forms/list_forms', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $systems = Systems::where('id_company', '=', $user->company)->get();
        return view('core/forms/create_form', compact('systems'));
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
            'name_form' => 'required',
            'description_form'=> 'required'
        ]);
        $form=new Forms();
        $form->id_system=$request->id_system;
        $form->name_form=$request->name_form;
        $form->description_form=$request->description_form;
        $form->created_by = Auth::id();
        $form->save();
        return redirect('forms')->
        with('success', 'Se ha agregado el formulario '.$form->name_form.' correctamente.');
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
        $user = Auth::user();
        $form = Forms::find($id);
        $system = Forms::find($id)->system;
        if($system->id_company == $user->company){
            return view('core/forms/form_profile',compact('form','id'), compact('system'));
        }else{
            abort(401);
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
        $form = Forms::find($id);
        $system = Forms::find($id)->system;
        if($system->id_company == $user->company){
            $systems = Systems::where('id_company', '=', $user->company)->get();
            return view('core/forms/update_form',compact('form','id'), compact('systems'));
        }else{
            abort(401);
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
        $form = Forms::find($id);
        $form->id_system=$request->id_system;
        $form->name_form=$request->name_form;
        $form->description_form=$request->description_form;
        $form->updated_by = Auth::id();
        $form->save();
        $system = Forms::find($id)->system;
        return view('core/forms/form_profile',compact('form','id'), compact('system'))->
        with('success', 'Se ha actualizado el formulario '.$form->name_form.' correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $form=Forms::find($id);
        $system = Forms::find($id)->system;
        if($system->id_company == $user->company){
            $form->delete();
            return redirect('forms')->with('success','La compañía ha sido eliminada del sistema');
        }else{
            abort(401);
        }
    }
}
