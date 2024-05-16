<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('categories', [

        ]);
    }

    public function create(): View
    {
        return view('categories');
    }
}
