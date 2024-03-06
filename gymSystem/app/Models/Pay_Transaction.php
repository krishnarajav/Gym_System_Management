<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay_Transaction extends Model
{
    protected $table = 'Pay_Transactions';
    protected $fillable = ['id', 'payer_id', 'payee_id', 'payment_mode', 'pay_date', 'amount', 'transaction_id'];
}
