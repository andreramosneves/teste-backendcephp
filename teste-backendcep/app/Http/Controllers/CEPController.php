<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

use App\Models\CEP;

class CEPController extends Controller
{

    public function getCEP(Request $request){
        $data = array();
        $array = $this->trataParametros($request->array);
        foreach ($array as $value) {        
            $result = Http::accept('application/json')->get("https://viacep.com.br/ws/". $value ."/json/")->json();
            if($result !=null){
                /*Grava histórico da consulta*/
                $cep = new Cep(array());
                $this->persisteCEP($cep, $result);
                /*Incluímo na nossa pilha o objeto CEP*/
                array_push($data, $cep);
            }
        }

        /* Realizada a ordenação a partir do label*/
        usort($data, function($a, $b) { 
            return $a->label < $b->label ? -1 : 1; 
        }); 

        return response()->json($data,200,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
    }

    public function trataParametros($array){
        $array=explode(",",str_replace("-","", $array));
        return $array;
    }

    public function persisteCEP($cep, $result){
        $cep->cep=str_replace("-","", $result["cep"]);
        $cep->label=$result["logradouro"] . ", ". $result["localidade"];
        $cep->logradouro=$result["logradouro"];
        $cep->complemento=$result["complemento"];
        $cep->bairro=$result["bairro"];
        $cep->localidade=$result["localidade"];
        $cep->uf=$result["uf"];
        $cep->ibge=$result["ibge"];
        $cep->gia=$result["gia"];
        $cep->ddd=$result["ddd"];
        $cep->siafi=$result["siafi"];
        /*Caso queiramos gravar em alguma tabela histórico*/
        //$cep->save();
    }
    

}
