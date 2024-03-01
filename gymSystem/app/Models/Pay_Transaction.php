<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay_Transaction extends Model
{
    
    protected $primaryKey = null; 
    public $incrementing = false; 
    protected $fillable = ['payer_id', 'payee_id', 'payment_mode', 'pay_date', 'amount', 'transaction_id'];
}
