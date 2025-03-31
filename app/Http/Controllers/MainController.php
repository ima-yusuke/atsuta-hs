<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function ShowPage()
    {
        $categories = Category::where('parent_id', null)
            ->with(['children', 'contents'])
            ->orderBy('order')
            ->get();

        return view('main',compact('categories'));
    }
}
