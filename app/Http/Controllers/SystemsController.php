<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Providers\RouteServiceProvider;
Use App\Companies;
Use App\Systems;
use Auth;

class SystemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $systems = Systems::all()->toArray();
        return view('core/systems/list_systems', compact('systems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Companies::all()->toArray();
        return view('core/systems/create_system', compact('companies'));
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
            'id_company' => 'required',
            'name_system' => 'required',
            'description_system'=> 'required',
            'url_system'=> 'required'

        ]);
        $system=new Systems();
        $system->id_company=$request->id_company;
        $system->name_system=$request->name_system;
        $system->description_system=$request->description_system;
        $system->url_system=$request->url_system;
        $system->created_by = Auth::id();
        $system->save();
        return redirect('systems')->
        with('success', 'Se ha agregado el sistema '.$system->name_system.' correctamente.');
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
        $system = Systems::find($id);
        $company = Companies::find($system->id_company);
        return view('core/systems/profile_system',compact('system','id'), compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $system = Systems::find($id);
        $companies = Companies::all()->toArray();
        return view('core/systems/update_system',compact('system','id'), compact('companies'));
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
        $system = Systems::find($id);
        $system->id_company = $request->id_company;
        $system->name_system = $request->name_system;
        $system->description_system = $request->description_system;
        $system->url_system = $request->url_system;
        $system->updated_by = Auth::id();
        $system->save();
        $company = Companies::find($system->id_company);
        return view('core/systems/profile_system',compact('system','id', 'company'))->
        with('success', 'Se ha actualizado el sistema '.$system->name_system.' correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $system=Systems::find($id);
        $system->delete();
        return redirect('systems')->with('success','La compañía ha sido eliminada del sistema');
    }
}
