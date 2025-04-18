<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    public $timestamps = false;
    protected $guarded = [];

    static function getCategory()
    {
        return self::select('category.*')->orderBy('id', 'desc')->get();
    }

    static public function getRecordMenu()
    {
        return self::select('category.*')
            ->where("category.status", 1)
            ->orderBy('category.id', 'asc')->get();
    }

    public function sub_category()
    {
        return $this->hasMany(SubCategory::class, 'category_id')
            ->where('sub_category.status', 1)
            ->orderBy('id', 'desc');
    }
}
