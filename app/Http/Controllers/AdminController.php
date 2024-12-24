<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id):View
    {
        if(view()->exists($id)){
            return view($id);
        }
        else
        {
            return view('404');
        }

     //   return view($id);
    }

    public function authrize():View
    {
        return view('authrize');
    }
}
