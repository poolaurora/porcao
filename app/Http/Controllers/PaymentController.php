<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Infos;
use App\Models\Payments;
use App\Models\Item;
use App\Services\BinLookupService;
use App\Events\PaymentEvent;


class PaymentController extends Controller
{

    protected $binLookup;

    public function __construct(BinLookupService $binLookup)
    {
        $this->binLookup = $binLookup;
    }

    public function paymentIndex($id){

        $pedido = Payments::findOrFail($id);

        // Se $pedido->description já é um array:
        $description = $pedido->description;

        // Acesso ao valor em ambos os casos:
        $valor = $description['info']['value'];
        // Passando o URL codificado para a view junto com o objeto pedido
        return view('payment', compact('pedido', 'valor'));
    }

    public function create($id, $type)
    {
        $appId = env('APP_ID_SQALA');
        $appSecret = env('APP_SECRET');
        $base64Credentials = base64_encode("{$appId}:{$appSecret}");
        
        if($type === 'consultavel'){
            $info = Infos::find($id);
            $valorEmCentavos = (int) ($info->valor * 100);

            $description = [
                'info' => [
                    'type' => 'consultavel',
                    'value' => $info->valor, 
                    'user_id' => auth()->id(),
                    'info_id' => $info->id,
                ],
            ];            
        }
        elseif($type === 'full'){
            $info = Infos::find($id);
            $valorEmCentavos = (int) ($info->valor * 100);

            $description = [
                'info' => [
                    'type' => 'full',
                    'value' => $info->valor, 
                    'user_id' => auth()->id(),
                    'info_id' => $info->id,
                ],
            ];            
        }
        elseif($type === 'consultada'){
            $info = Infos::find($id);
            $valorEmCentavos = (int) ($info->valor * 100);

            $description = [
                'info' => [
                    'type' => 'consultada',
                    'value' => $info->valor, 
                    'user_id' => auth()->id(),
                    'info_id' => $info->id,
                ],
            ];            
        }


        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $base64Credentials,
            'Content-Type' => 'application/json'
        ])->post('https://api.sqala.tech/core/v1/access-tokens', [
            'refreshToken' => env('REFRESH_TOKEN')
        ]);
        
        $data = $response->json();
    
        $order_id = uniqid();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $data['token'],
            'Content-Type' => 'application/json'
        ])->post('https://api.sqala.tech/core/v1/pix-qrcode-payments', [
            'amount' => $valorEmCentavos,
            'code' => $order_id
        ]);
    
        if ($response->successful()) {

            $data = $response->json();

            $pedido = new Payments;
            $pedido->order_id = $order_id; 
            $pedido->status = 'pendente';
            $pedido->pix_code_url = $data['payload'];  
            $pedido->description = $description;  
            $pedido->save();

            return redirect()->route('payment.index', ['id' => $pedido->id]);
            $data = $response->json();
        } else {
            return response()->json(['error' => 'Falha na criação do QR Code', $response->json()], 500);
        }

    }


    public function checkBin(Request $request)
    {        
        $binDetails = $this->binLookup->getBinDetails($request->bin);
        return response()->json(['binDetails' => $binDetails]);
    }

    public function recivePayment(Request $request)
{
    $data = $request->all();

    if ($data['event'] === "payment.paid") {
        $pedido = Payments::where('order_id', $data['data']['code'])->first();

        if ($pedido) {
            $description = $pedido->description; // Decodificar a descrição JSON para array

            $info = Infos::find($description['info']['info_id']);
            
            if ($info) {
                $info->is_published = 0;
                $info->save();

                $item = new Item;
                $item->name = $info->categoria . ' Limite ' . $info->limite;
                $item->itemable_id = $info->id;
                $item->itemable_type = 'App\Models\Infos';
                $item->user_id = $description['info']['user_id'];
                $item->save();
                event(new PaymentEvent($pedido));

                return response()->json(['success' => 'Payment processed successfully']);
            }

            return response()->json(['failed' => 'failed to process data, [Info not found]']);
        }

        return response()->json(['failed' => 'failed to process data, [Payment not found]']);
    }

    return response()->json(['failed' => 'failed to process data, [Payment Not Approved]']);
}

public function PaymentSucess($id)
{
    $pedido = Payments::findOrFail($id);

    return view('sucess', ['pedido' => $pedido]);
}
}
