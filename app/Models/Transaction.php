<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'description', 'category_id', 'transaction_type_id', 'transaction_date'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        // 'amount' => 'numeric'
    ];

    public static function booted(){
        parent::booted();

        self::creating(function(self $transaction){
            $transaction->owner()->associate(auth()->user());
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function type()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
