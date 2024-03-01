<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['c_id', 'passwd', 'name', 'dob', 'age', 'gender', 'address', 'mobile', 'p_id', 'p_start', 'p_end'];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'p_id');
    }
}
