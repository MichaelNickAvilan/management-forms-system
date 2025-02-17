<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Providers\RouteServiceProvider;
Use App\Companies;
use Auth;

class CompaniesController extends Controller
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

        $companies = Companies::all()->toArray();
        return view('core/companies/list_companies', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('core/companies/create_company');
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
            'name_company' => 'required',
            'company_logo'=> 'required|file'

        ]);
        $file_name = uniqid().'_logo.'.$request->company_logo->extension();
        $company=new Companies();
        $company->name_company=$request->name_company;
        $request->company_logo->storeAs('companies', $file_name);
        $company->company_logo = $file_name;
        $company->created_by = Auth::id();
        $company->save();
        return redirect('companies')->
        with('success', 'Se ha agregado la compañía '.$company->company_name.' correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Companies::find($id);
        return view('core/companies/profile_company',compact('company','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Companies::find($id);
        return view('core/companies/update_company',compact('company','id'));
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
        $company = Companies::find($id);

        $company->name_company=$request->name_company;

        if(isset($request->company_logo)){
            $file_name = uniqid().'_logo.'.$request->company_logo->extension();
            $path = storage_path('app/public/companies/' . $company->company_logo);
            Storage::disk('public')->delete('companies/'.$company->company_logo);
            $request->company_logo->storeAs('companies', $file_name);
            $company->company_logo = $file_name;
        }

        $company->updated_by = Auth::id();
        $company->save();

        return view('core/companies/profile_company',compact('company','id'))->
        with('success', 'Se ha actualizado la compañía '.$company->company_name.' correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company=Companies::find($id);
        $path = storage_path('app/public/companies/' . $company->company_logo);
        Storage::disk('public')->delete('companies/'.$company->company_logo);
        $company->delete();
        return redirect('companies')->with('success','La compañía ha sido eliminada del sistema');
    }
}
