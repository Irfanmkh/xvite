<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use Illuminate\View\View;
use App\Models\Formfields;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    //

public function temaView($id)
    {
        $tema = Tema::findOrFail($id); // ambil data tema berdasarkan id

        return view('preview.tema', compact('tema'));
    }
}
