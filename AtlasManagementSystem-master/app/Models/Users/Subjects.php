<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;
use App\Models\USers\Subjects;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

    public function users(){
        return $this->belongsTo('App\Models\Users\User','subject_users','user_id', 'subject_id');
    }
}
