<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'img',
        'url',
        'order'
    ];

    /**
     * リレーション：コンテンツは1つのカテゴリに関連付けられる
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
