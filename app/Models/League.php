<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function clubs()
    {
        return $this->belongsToMany(Club::class);
    }

    public function sport() {
        return $this->belongsTo(Sport::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function getTypeNameAttribute() {
        return $this->type == 1 ? __('site.League') : __('site.Tournament');
    }


    public function getStatusNameAttribute()
    {
        return $this->status == 1 ? __('site.Active') : __('site.Inactive');
    }
}