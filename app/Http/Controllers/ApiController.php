<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use DB;

class ApiController extends Controller
{
    public function obtenerDatos(Request $request){
        //dd($request->numticket);

        $numero=0;
        $placa="";
        //dd($request->numero);
        // $respuesta = Http::get('http://192.168.2.31/Conex/TaerDatos/'.$request->numero);
        //dd($request->numero, $request->placa);
        // if (empty($request->numero) || empty($request->placa)) {
        //     return response()->json(['error' => 'Los parámetros "numero" y "placa" son requeridos.'], 400);
        // }
        if (empty($request->numero) && !empty($request->placa)) {
            $numero=0;
            $placa=$request->placa;
        }else{
            if (empty($request->placa) && !empty($request->numero)) {
                $numero=$request->numero;
                $placa="0";
            }
        }
        //dd($numero);
        $respuesta = Http::get("http://192.168.1.14/Conex/TaerDatos/{$numero}/{$placa}");
        
        // $respuesta = Http::post('http://192.168.1.14/Conex/TraerDosDatos',
        // ['numero'=>$request->numticket, 'placa'=>$request->placa]);
        //dd($request);
        // $respuesta = Http::withHeaders([
        //     'X-CSRF-TOKEN' => csrf_token()
        // ])->post('http://192.168.1.14/Conex/TraerDosDatos', [
        //     'numero' => $request->numticket,
        //     'placa' => $request->placa
        // ]);
        return $respuesta;
    }

    public function obtenerDatosNumero(Request $request){
        $numero=$request->numero;
        $ticket = DB::table('mb_invoices')->where('num_ticket', $numero)
        ->count();
        if($ticket>=1){
            return ["val"=>1];
        }
        $codigo_usuario = Auth::user()->codigo_sistema;
        $respuesta = Http::get("http://apiparqueo.local/Conex/TaerDatos/{$codigo_usuario}/{$numero}");
     
        return $respuesta;
    }
    public function obtenerDatosPlaca(Request $request){

        $placa=$request->placa;
        $codigo_usuario = Auth::user()->codigo_sistema;
        $respuesta = Http::get("http://apiparqueo.local/Conex/TaerDatosPlaca/{$codigo_usuario}/{$placa}");
     
        dd($respuesta);
        return $respuesta;
    }

    public function obtenerDatosImporteTicket(Request $request){

        $numero=$request->numero;
        $respuesta = Http::get("http://apiparqueo.local/Conex/TaerImporteTicket/{$numero}");
     
        return $respuesta;
    }
    public function obtenerDatosImportePlaca(Request $request){

        $placa=$request->placa;
        $respuesta = Http::get("http://apiparqueo.local/Conex/TaerImportePlaca/{$placa}");
     
        return $respuesta;
    }

    public function buscarTicket(Request $request){
        //dd($request->numero_ticket);
        $ticket = DB::table('mb_invoices')->where('num_ticket', $request->numero_ticket)
        ->count();

        if ($ticket>=1){
            return ['respuesta'=>1];
        }else{
            return ['respuesta'=>100];
        }
    }
}
