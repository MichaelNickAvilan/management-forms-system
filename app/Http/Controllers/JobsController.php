<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Providers\RouteServiceProvider;
Use App\Companies;
Use App\Systems;
Use App\Forms;
Use App\Fields;
Use App\Registers;
Use App\Values;
use Auth;
use \stdClass;
use Session;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $register=new Registers();
        $register->id_form = $request->id_form;
        $register->created_by = Auth::id();
        if($register->created_by==NULL){
            $register->created_by = 1;
        }
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
                    if($value->created_by==NULL){
                        $value->created_by = 1;
                    }
                    if(\strrpos($key, '_image')>0 || \strrpos($key, '_file')>0){
                        $file_name = $register->id.'_'.uniqid().'_register.'.$request[$key]->extension();
                        $request[$key]->storeAs('registers', $file_name);
                        $value->value_register = $file_name;
                    }
                    $value->save();
                }
            }
        }
        if(isset($request->external)){
            Session::flash('message', "Se ha insertado el registro correctamente");
            return \Redirect::back();
        }else{
            return redirect('registers')->
            with('success', 'Se ha agregado el registro correctamente.');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
