<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(): View
    {
        return view('items', [

        ]);
    }

    public function create(): View
    {
        return view('items');
    }
}
