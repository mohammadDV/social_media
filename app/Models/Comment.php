<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates        = ['deleted_at'];
//    protected $dateFormat   = 'U';
    protected $guarded      = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function parents()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user');
    }

    public function likes()
    {
        return $this->morphMany(Like::class,"likeable",'likeable_type', 'likeable_id');
    }
}