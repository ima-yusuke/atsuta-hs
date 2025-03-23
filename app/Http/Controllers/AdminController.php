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
//    // [ページ遷移] カテゴリー
//    function ShowCategory() {
//        $categories = Category::orderBy('order', 'asc')->get();
//        return view('admin.category', compact('categories'));
//    }
//
//    // [追加] カテゴリー
//    public function AddCategory(Request $request) {
//        $validator = Validator::make($request->all(), [
//            'name' => 'required',
//            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
//        ], [], [
//            'name' => 'カテゴリー名',
//            'img' => 'カテゴリー画像',
//        ]);
//        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator, 'add')->withInput();
//        }
//
//        DB::beginTransaction();
//        try {
//            $category = new Category();
//            $category->name = $request->name;
//            // 画像保存
//            if ($request->hasFile('img')) {
//                $filePath = $request->file('img')->store('img/categories', 'public');
//                $category->img = 'storage/' . $filePath;
//            }
//            $category->order = Category::max('order') + 1;
//            $category->save();
//            DB::commit();
//            return redirect()->back()->with('success', 'カテゴリーを追加しました。');
//        } catch (\Exception $e) {
//            DB::rollback();
//            Log::error($e);
//            return redirect()->back()->with('error', 'カテゴリー追加中にエラーが発生しました。');
//        }
//    }
//
//    // [更新] カテゴリー
//    public function UpdateCategory(Request $request, $id) {
//        $validator = Validator::make($request->all(), [
//            'name_' . $id => 'required',
//            'img' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
//        ], [], [
//            'name_' . $id => 'カテゴリー名',
//            'img' => 'カテゴリー画像',
//        ]);
//        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator, 'update' . $id)->withInput();
//        }
//
//        DB::beginTransaction();
//        try {
//            $category = Category::find($id);
//            if ($category) {
//                if ($request->has('name_' . $id)) {
//                    $category->name = $request->input('name_' . $id);
//                }
//                // 画像更新
//                if ($request->hasFile('img')) {
//                    // 既存の画像削除
//                    if ($category->img) {
//                        $oldImagePath = str_replace('storage/', '', $category->img);
//                        if (Storage::disk('public')->exists($oldImagePath)) {
//                            Storage::disk('public')->delete($oldImagePath);
//                        }
//                    }
//                    // 新規の画像保存
//                    $filePath = $request->file('img')->store('img/categories', 'public');
//                    $category->img = 'storage/' . $filePath;
//                }
//                $category->save();
//                DB::commit();
//                return redirect()->back()->with('success', 'カテゴリーを更新しました。');
//            } else {
//                DB::rollBack();
//                return redirect()->back()->with('error', 'カテゴリーが見つかりません。');
//            }
//        } catch (\Exception $e) {
//            DB::rollback();
//            Log::error($e);
//            return redirect()->back()->with('error', 'カテゴリー更新中にエラーが発生しました。');
//        }
//    }
//
//    // [削除] カテゴリー
//    public function DeleteCategory($id) {
//        DB::beginTransaction();
//        try {
//            $category = Category::find($id);
//            if ($category) {
//                $oldImagePath = str_replace('storage/', '', $category->img);
//                if (Storage::disk('public')->exists($oldImagePath)) {
//                    Storage::disk('public')->delete($oldImagePath);
//                }
//                $category->delete();
//                DB::commit();
//                return redirect()->back()->with('success', 'カテゴリーを削除しました。');
//            } else {
//                DB::rollBack();
//                return redirect()->back()->with('error', 'カテゴリーが見つかりません。');
//            }
//        } catch (\Exception $e) {
//            DB::rollback();
//            Log::error($e);
//            return redirect()->back()->with('error', 'カテゴリー削除中にエラーが発生しました。');
//        }
//    }

    // [ページ遷移] コンテンツ
    function ShowContent() {
        $contents = Content::orderBy('category_id', 'asc')->orderBy('order', 'asc')->get();
        $categories = Category::orderBy('order', 'asc')->get();
        return view('admin.content', compact('contents', 'categories'));
    }

    // [追加] カテゴリー
    public function AddCategory(Request $request) {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'required',
            'category_name' => 'required',
            'category_img_new' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ], [], [
            'parent_id' => '親カテゴリー',
            'category_name' => 'カテゴリー名',
            'category_img_new' => 'カテゴリー画像',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'add_category')->withInput();
        }

        DB::beginTransaction();
        try {
            $category = new Category();
            $category->parent_id = $request->parent_id;
            $category->name = $request->category_name;
            // 画像保存
            if ($request->hasFile('category_img_new')) {
                $filePath = $request->file('category_img_new')->store('img/categories', 'public');
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
            'parent_id' => 'required',
            'category_name_' . $id => 'required',
            'category_img_' . $id => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ], [], [
            'parent_id' => '親カテゴリー',
            'category_name_' . $id => 'カテゴリー名',
            'category_img_' . $id => 'カテゴリー画像',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'update_category_' . $id)->withInput();
        }

        DB::beginTransaction();
        try {
            $category = Category::find($id);
            if ($category) {
                if ($request->has('parent_id')) {
                    $category->parent_id = $request->parent_id;
                }
                if ($request->has('category_name_' . $id)) {
                    $category->name = $request->input('category_name_' . $id);
                }
                // 画像更新
                if ($request->hasFile('category_img_' . $id)) {
                    // 既存の画像削除
                    if ($category->img) {
                        $oldImagePath = str_replace('storage/', '', $category->img);
                        if (Storage::disk('public')->exists($oldImagePath)) {
                            Storage::disk('public')->delete($oldImagePath);
                        }
                    }
                    // 新規の画像保存
                    $filePath = $request->file('category_img_' . $id)->store('img/categories', 'public');
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
                'status' => 'success',
                'message' => 'カテゴリーの順番が正常に更新されました',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'カテゴリーの順番を更新中にエラーが発生しました',
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

    // [追加] コンテンツ
    public function AddContent(Request $request) {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'content_name' => 'required',
            'content_url' => 'required',
            'content_img_new' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ], [], [
            'category_id' => 'カテゴリー名',
            'content_name' => '動画名',
            'content_url' => '動画URL',
            'content_img_new' => 'サムネイル画像',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'add_content')->withInput();
        }

        DB::beginTransaction();
        try {
            $content = new Content();
            $content->category_id = $request->category_id;
            $content->name = $request->content_name;
            $content->url = $request->content_url;
            // 画像保存
            if ($request->hasFile('content_img_new')) {
                $filePath = $request->file('content_img_new')->store('img/contents', 'public');
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
            'category_id_' . $id => 'required',
            'content_name_' . $id => 'required',
            'content_url_' . $id => 'required',
            'content_img_' . $id => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ], [], [
            'category_id_' .$id => 'カテゴリー',
            'content_name_' . $id => '動画名',
            'content_url_' . $id => '動画URL',
            'content_img_' . $id => 'サムネイル画像',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'update_content_' . $id)->withInput();
        }

        DB::beginTransaction();
        try {
            $content = Content::find($id);
            if ($content) {
                if ($request->has('category_id_' . $id)) {
                    $content->category_id = $request->category_id;
                }
                if ($request->has('content_name_' . $id)) {
                    $content->name = $request->input('content_name_' . $id);
                }
                if ($request->has('content_url_' . $id)) {
                    $content->url = $request->input('content_url_' . $id);
                }
                // 画像更新
                if ($request->hasFile('content_img_' . $id)) {
                    // 既存の画像削除
                    if ($content->img) {
                        $oldImagePath = str_replace('storage/', '', $content->img);
                        if (Storage::disk('public')->exists($oldImagePath)) {
                            Storage::disk('public')->delete($oldImagePath);
                        }
                    }
                    // 新規の画像保存
                    $filePath = $request->file('content_img_' . $id)->store('img/contents', 'public');
                    $content->img = 'storage/' . $filePath;
                }
                $content->save();
                DB::commit();
                return redirect()->back()->with('success', '動画コンテンツを更新しました。');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', '動画コンテンツが見つかりません。');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
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
            return response()->json([
                'status' => 'success',
                'message' => '動画コンテンツの順番が正常に更新されました',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => '動画コンテンツの順番を更新中にエラーが発生しました',
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
                return redirect()->back()->with('success', '動画コンテンツを削除しました。');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', '動画コンテンツが見つかりません。');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return redirect()->back()->with('error', '動画コンテンツ削除中にエラーが発生しました。');
        }
    }

    // [並び替え] ページ遷移
//    public function ShowSort() {
//        $categories = Category::orderBy('order', 'asc')->get();
//        $contents = Content::orderBy('category_id', 'asc')->orderBy('order', 'asc')->get();
//        return view('admin.sort', compact('categories', 'contents'));
//    }

    // [並び替え] カテゴリー順番
//    public function UpdateOrder(Request $request) {
//        $categories = $request->input('categories');
//
//        foreach ($categories as $categoryData) {
//            $category = Category::find($categoryData['id']);
//            $category->update([
//                'order' => $categoryData['order'],
//                'parent_id' => $categoryData['parent_id'] ?? null
//            ]);
//
//            // 子カテゴリーの並べ替え
//            if (isset($categoryData['children'])) {
//                foreach ($categoryData['children'] as $childData) {
//                    $childCategory = Category::find($childData['id']);
//                    $childCategory->update([
//                        'order' => $childData['order'],
//                        'parent_id' => $categoryData['id']
//                    ]);
//                    // 孫カテゴリー以下の処理
//                    if (isset($childData['children'])) {
//                        foreach ($childData['children'] as $subChildData) {
//                            $subChildCategory = Category::find($subChildData['id']);
//                            $subChildCategory->update([
//                                'order' => $subChildData['order'],
//                                'parent_id' => $childData['id']
//                            ]);
//                        }
//                    }
//                }
//            }
//        }
//
//        // コンテンツの並べ替え
//        $contents = $request->input('contents');
//        foreach ($contents as $contentData) {
//            $content = Content::find($contentData['id']);
//            $content->update([
//                'order' => $contentData['order'],
//                'category_id' => $contentData['category_id'],
//            ]);
//        }
//
//        return response()->json(['status' => 'success']);
//    }
}
