<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\MainCategory;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];
    public function mainCategory(){
        return $this->belongsTo('App\Models\Categories\MainCategory','main_categories','main_category'); // リレーションの定義
    }

    public function posts(){
          return $this->belongsTo('App\Models\Posts\post','posts', 'user_id','post_title','post');/// リレーションの定義
    }
}
