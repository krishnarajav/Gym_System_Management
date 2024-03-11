<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'Customers';
    protected $fillable = ['id', 'c_id', 'p_id', 'p_start', 'p_end', 'p_status'];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'p_id');
    }

    public function personaldetails()
    {
        return $this->hasOne(Personal_Details::class, 'c_id', 'c_id');
    }
}
