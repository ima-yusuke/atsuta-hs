<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller {
    // [ページ遷移] カテゴリー
    function ShowCategory() {
        $categories = Category::orderBy('order', 'asc')->get();
        return view('admin.category', compact('categories'));
    }

    // [追加] カテゴリー
    public function AddCategory(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ], [], [
            'name' => 'カテゴリー名',
            'img' => 'カテゴリー画像',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'add')->withInput();
        }

        DB::beginTransaction();
        try {
            $category = new Category();
            $category->name = $request->name;
            // 画像保存
            if ($request->hasFile('img')) {
                $filePath = $request->file('img')->store('img/categories', 'public');
                $category->img = 'storage/' . $filePath;
            }
            $category->order = Category::max('order') + 1;
            $category->save();
            DB::commit();
            return redirect()->back()->with('success', 'カテゴリーを追加しました。');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return redirect()->back()->with('error', 'カテゴリー追加中にエラーが発生しました。');
        }
    }

    // [更新] カテゴリー
    public function UpdateCategory(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name_' . $id => 'required',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ], [], [
            'name_' . $id => 'カテゴリー名',
            'img' => 'カテゴリー画像',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'update' . $id)->withInput();
        }

        DB::beginTransaction();
        try {
            $category = Category::find($id);
            if ($category) {
                if ($request->has('name_' . $id)) {
                    $category->name = $request->input('name_' . $id);
                }
                // 画像更新
                if ($request->hasFile('img')) {
                    // 既存の画像削除
                    if ($category->img) {
                        $oldImagePath = str_replace('storage/', '', $category->img);
                        if (Storage::disk('public')->exists($oldImagePath)) {
                            Storage::disk('public')->delete($oldImagePath);
                        }
                    }
                    // 新規の画像保存
                    $filePath = $request->file('img')->store('img/categories', 'public');
                    $category->img = 'storage/' . $filePath;
                }
                $category->save();
                DB::commit();
                return redirect()->back()->with('success', 'カテゴリーを更新しました。');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'カテゴリーが見つかりません。');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return redirect()->back()->with('error', 'カテゴリー更新中にエラーが発生しました。');
        }
    }

    // [更新] カテゴリー順番
    public function UpdateCategoryOrder(Request $request) {
        Log::info($request->orderData);
        DB::beginTransaction();
        try {
            foreach ($request->orderData as $key => $array) {
                $category = Category::find($array['id']);
                if ($category) {
                    $category->order = $key + 1;
                    $category->save();
                }
            }
            DB::commit();
            return response()->json([
                'message' => ' カテゴリーの順番が正常に更新されました',
                'redirect' => route('ShowCategory')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'message' => 'カテゴリーの順番を更新中にエラーが発生しました',
                'redirect' => route('ShowCategory')
            ]);
        }
    }

    // [削除] カテゴリー
    public function DeleteCategory($id) {
        DB::beginTransaction();
        try {
            $category = Category::find($id);
            if ($category) {
                $oldImagePath = str_replace('storage/', '', $category->img);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
                $category->delete();
                DB::commit();
                return redirect()->back()->with('success', 'カテゴリーを削除しました。');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'カテゴリーが見つかりません。');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return redirect()->back()->with('error', 'カテゴリー削除中にエラーが発生しました。');
        }
    }

    // [ページ遷移] コンテンツ
    function ShowContent() {
        $contents = Content::orderBy('category_id', 'asc')->orderBy('order', 'asc')->get();
        $categories = Category::orderBy('order', 'asc')->get();
        return view('admin.content', compact('contents', 'categories'));
    }

    // [追加] コンテンツ
    public function AddContent(Request $request) {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'url' => 'required',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ], [], [
            'category_id' => 'カテゴリー名',
            'name' => '動画名',
            'url' => '動画URL',
            'img' => 'サムネイル画像',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'add')->withInput();
        }

        DB::beginTransaction();
        try {
            $content = new Content();
            $content->category_id = $request->category_id;
            $content->name = $request->name;
            $content->url = $request->url;
            // 画像保存
            if ($request->hasFile('img')) {
                $filePath = $request->file('img')->store('img/contents', 'public');
                $content->img = 'storage/' . $filePath;
            }
            $content->order = Content::max('order') + 1;
            $content->save();
            DB::commit();
            return redirect()->back()->with('success', '動画コンテンツを追加しました。');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return redirect()->back()->with('error', '動画コンテンツ追加中にエラーが発生しました。');
        }
    }

    // [更新] コンテンツ
    public function UpdateContent(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name_' . $id => 'required',
            'url_' . $id => 'required',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ], [], [
            'category_id' => 'カテゴリー',
            'name_' . $id => '動画名',
            'url_' . $id => '動画URL',
            'img' => 'サムネイル画像',
        ]);
        if ($validator->fails()) {
            session()->flash('select_category', $request->input('category_id'));
            return redirect()->back()->withErrors($validator, 'update' . $id)->withInput();
        }

        DB::beginTransaction();
        try {
            $content = Content::find($id);
            if ($content) {
                if ($request->has('category_id')) {
                    $content->category_id = $request->category_id;
                }
                if ($request->has('name_' . $id)) {
                    $content->name = $request->input('name_' . $id);
                }
                if ($request->has('url_' . $id)) {
                    $content->url = $request->input('url_' . $id);
                }
                // 画像更新
                if ($request->hasFile('img')) {
                    // 既存の画像削除
                    if ($content->img) {
                        $oldImagePath = str_replace('storage/', '', $content->img);
                        if (Storage::disk('public')->exists($oldImagePath)) {
                            Storage::disk('public')->delete($oldImagePath);
                        }
                    }
                    // 新規の画像保存
                    $filePath = $request->file('img')->store('img/contents', 'public');
                    $content->img = 'storage/' . $filePath;
                }
                $content->save();
                DB::commit();
                session()->flash('select_category', $request->input('category_id'));
                return redirect()->back()->with('success', '動画コンテンツを更新しました。');
            } else {
                DB::rollBack();
                session()->flash('select_category', $request->input('category_id'));
                return redirect()->back()->with('error', '動画コンテンツが見つかりません。');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            session()->flash('select_category', $request->input('category_id'));
            return redirect()->back()->with('error', '動画コンテンツ更新中にエラーが発生しました。');
        }
    }

    // [更新] コンテンツ順番
    public function UpdateContentOrder(Request $request) {
        DB::beginTransaction();
        try {
            $category = $request->draggedCategoryId;
            foreach ($request->orderData as $key => $array) {
                $content = Content::find($array['id']);
                if ($content) {
                    $content->order = $key + 1;
                    $content->save();
                }
            }
            DB::commit();
            session()->flash('select_category', $category);
            Log::info('Updated select_category:', ['select_category' => session('select_category')]);
            return response()->json([
                'message' => '動画コンテンツの順番が正常に更新されました',
                'redirect' => route('ShowContent')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'message' => '動画コンテンツの順番を更新中にエラーが発生しました',
                'redirect' => route('ShowContent')
            ]);
        }
    }

    // [削除] コンテンツ
    public function DeleteContent($id) {
        DB::beginTransaction();
        try {
            $content = Content::find($id);
            if ($content) {
                $oldImagePath = str_replace('storage/', '', $content->img);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
                $content->delete();
                DB::commit();
                session()->flash('select_category', $content->category_id);
                return redirect()->back()->with('success', '動画コンテンツを削除しました。');
            } else {
                DB::rollBack();
                session()->flash('select_category', $content->category_id);
                return redirect()->back()->with('error', '動画コンテンツが見つかりません。');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            session()->flash('select_category', $content->category_id);
            return redirect()->back()->with('error', '動画コンテンツ削除中にエラーが発生しました。');
        }
    }
}
