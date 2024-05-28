<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reembolso;
use Illuminate\Support\Facades\Http;

class RefundController extends Controller
{
    public function decline($id){

        $reembolso = Reembolso::find($id);

        if(!auth()->user()->hasRole('admin')){
            return redirect('/');
        }

        $reembolso->status = 'reprovado';
        $reembolso->save();

        return redirect()->back();

    }

    public function accept($id){

        $reembolso = Reembolso::find($id);

        if(!auth()->user()->hasRole('admin')){
            return redirect('/');
        }

        $reembolso->status = 'aprovado';
        $reembolso->save();

        return redirect()->back();

    }
}
