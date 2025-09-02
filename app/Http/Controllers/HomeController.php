<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pola Petro Development - Home',
            'description' => 'Delivering Professionalism to a Better Future. Leading provider in compressed air systems and industrial solutions.',
            'keywords' => 'pola petro development, kompresor udara, petrotec, industrial solutions, indonesia'
        ];

        return view('home', $data);
    }
}
