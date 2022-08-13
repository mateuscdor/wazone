<?php

namespace App\Http\Controllers;

use App\Models\Package;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        return view('/welcome', compact('packages'));
    }
}
?>