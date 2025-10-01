<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'img',
        'order',
        'parent_id'
    ];

    /**
     * リレーション：カテゴリには複数のコンテンツが関連付けられる
     */
    public function contents()
    {
        return $this->hasMany(Content::class, 'category_id')->orderBy('order');
    }

    // 親カテゴリを取得する
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // 子カテゴリを取得する（childrenがnullになるまでループで再帰的にchildrenを実行する）
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with(['children', 'contents'])->orderBy('order');
    }
}
