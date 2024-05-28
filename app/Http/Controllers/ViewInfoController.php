<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;


class ViewInfoController extends Controller
{
    public function view($id, $type, $itemId){
    
        $item = Item::where('id', $itemId)->where('user_id', $id)->first();
    
        if (!$item) {
            return back()->with('error', 'Item não encontrado.');
        }
    
        if (auth()->user()->id !== $item->user_id) {
            return back()->with('error', 'Erro ao acessar o item');
        }
    
        $path = $item->itemable->info; // Presumo que 'info' seja o caminho do arquivo
        
        $file = storage_path('app/public/' . $path);
        $content = null; // Inicialize content como null
    
        if (file_exists($file) && is_file($file)) {
            $content = file_get_contents($file);
        }
    
        // Retorna a view e passa 'item' e 'content', mesmo que 'content' seja null
        return view('info', compact('item', 'content'));
    }
    
    
    
    
}
