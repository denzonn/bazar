<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'total', 'status', 'payment_method', 'code'];

    public function transactionDetails(){
        return $this->hasMany(TransactionDetail::class);
    }

    public function isComplete(){
        return $this->transactionDetails()->where('arrive', false)->count() === 0;
    }
}
