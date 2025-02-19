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
        'order'
    ];

    /**
     * リレーション：カテゴリには複数のコンテンツが関連付けられる
     */
    public function contents()
    {
        return $this->hasMany(Content::class, 'category_id')->orderBy('order');
    }
}
