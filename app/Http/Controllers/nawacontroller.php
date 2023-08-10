<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class nawacontroller extends Controller
{
    //
    public function index(){

        return view('Pharmacies.home');
    }
}
