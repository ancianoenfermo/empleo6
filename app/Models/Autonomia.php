<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autonomia extends Model
{
    use HasFactory;

    public function jobs() {
        return $this->hasMany(Job::class);
    }
    public function provinces() {
        return $this->hasMany(Province::class);
    }
    public function scopeSlug($query,$autonomia) {
        if (trim($autonomia != "")) {

            $query->where('slug',$autonomia);

        }
     }
}
