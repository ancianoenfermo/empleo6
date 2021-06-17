<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    public function autonomia() {
        return $this->belongsTo(Autonomia::class);
    }

    public function regions(){
        return $this->hasMany(Region::class);
    }


    public function jobs() {
        return $this->hasMany(Job::class);
    }

    public function scopeSlug($query,$provincia) {
        if (trim($provincia != "")) {
            $query->where('slug',$provincia);

        }
     }

}





