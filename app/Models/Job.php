<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Job extends Model
{
    use HasFactory;

    public function getDateHumanaAttribute() {
        Carbon::setLocale('es');
        return Carbon::create($this->datePosted)->diffForHumans();
    }

    public function autonomia() {
        return $this->belongsTo(Autonomia::class);
    }

    public function province() {
        return $this->belongsTo(Province::class);
    }
    public function region() {
        return $this->belongsTo(Region::class);
    }

    public function scopeAutonomia($query,$autonomia) {
       if (trim($autonomia != "")) {
        $query->where('autonomia_id',$autonomia);

       }
    }

    public function scopeProvincia($query,$provincia) {
        if(trim($provincia != "")) {
            $query->where('province_id',$provincia);
        }
    }

}
