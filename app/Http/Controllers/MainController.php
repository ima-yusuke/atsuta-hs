<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function ShowPage()
    {
        //メニュー用のカテゴリを取得
        $categoryMenu = Category::where('parent_id', 0)->get();

        //サブカテゴリーとコンテンツ用のデータを取得
        $categories = Category::with('contents')->orderBy('order')->get();
        return view('main',compact('categories','categoryMenu'));
    }
}
