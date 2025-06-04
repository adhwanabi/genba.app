<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenbaController extends Controller
{
    public function index(){
        return view('ori_app.form_temuan');
    }
    public function bod(){
        return view('ori_app.bod');
    }
}
