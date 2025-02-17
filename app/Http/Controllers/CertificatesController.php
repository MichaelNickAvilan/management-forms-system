<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Companies;
Use App\Systems;
Use App\Forms;
Use App\Fields;
Use App\Registers;
Use App\Values;
use \stdClass;
use Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('core/certificates/certificates');
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

    public function printPayrollCertificate(){
        $user = Auth::user();
        $value = Values::where('value_register', '=', $user->document)
        ->first();
        $id=$value->id_register;
        $register = Registers::with('values')->where('id_register', '=', $id)->first();
        $form = Forms::where('id_form', '=', $register->id_form )
        ->where('created_by', '=', $user->id)
        ->with('fields')->first();
        $today = Carbon::now()->format('d/m/Y');
        $pdf = Pdf::loadView('core/pdf/payroll', compact('register', 'user', 'today'));
        return $pdf->download('ejemplo.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $certificates = array();
        $user = Auth::user();
        $cURLConnection = curl_init();
        $endpoint = 'https://extranet.granamericasusme.co/api/manager/?type=7&company=gau';

        if($request->certType=="CERTLAB"){
            return redirect()->route('payroll', [$user]);
        }else{
            $endpoint = $endpoint.'&key='.$request->certType.$request->year;
        }
        try{
            $endpoint = $endpoint.'&file='.$user->document;
            curl_setopt($cURLConnection, CURLOPT_URL, $endpoint);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, FALSE);
            $response = curl_exec($cURLConnection);
            $err = curl_error($cURLConnection);
            if ($response === FALSE || !empty($err)) {
                $errno =curl_errno($cURLConnection);
                $info = curl_getinfo($cURLConnection);
                curl_close($cURLConnection);
                return array('result' => false, 'errno' => $errno, 'msg' => $err, 'info' => $info);
            }
        }
        catch(Exception $e) {
            dd($e);
        }

        curl_close($cURLConnection);
        $response = \json_decode($response)[0];
        foreach($response->children as $dir){
            foreach($dir->children as $cert){
                array_push($certificates, $this->getCertObject($user->document, $cert->file, $request->year));
            }
        }
        $cert_type = $request->certType;
        return view('core/certificates/certificates', compact('certificates', 'cert_type'));
    }
    private function getCertObject($document, $cert, $year){
        $parts = explode($document, $cert)[1];
        $parts = explode(".pdf", $parts)[0];
        $parts = str_split($parts);
        $document = new \stdClass();
        $document->year = $year;
        if(isset($parts[1])){
            $document->period = $parts[0].$parts[1];
            if(isset($parts[3])){
                $document->month = $parts[2].$parts[3];
            }else{
                $document->month = "Not defined";
            }
        }else{
            $document->period = 'No aplica';
            $document->month = 'No aplica';
            if($year==null){
                $document->year = 'No aplica';
            }
        }

        $document->document = 'https://extranet.granamericasusme.co/'.$cert;
        return $document;
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
