<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index(){
        return response()->json(['massage' => 'Hello World', 'success' => true], 
        200);
    }
}
