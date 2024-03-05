<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'Customers';
    protected $fillable = ['id', 'c_id', 'name', 'dob', 'age', 'gender', 'address', 'mobile', 'p_id', 'p_start', 'p_end'];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'p_id');
    }
}
