<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'active' , 'title', 'description'
    ];

    public static function booted() {
        parent::booted();

        self::creating(function(self $announcement){
            $announcement->owner()->associate(auth()->user());
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeActive($q){
        return $q->where('active', true);
    }
}
