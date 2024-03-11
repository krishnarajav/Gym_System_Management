<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal_Details extends Model
{
    protected $table = 'Personal_Details';
    protected $fillable = ['c_id', 't_id', 'name', 'dob', 'age', 'gender', 'height', 'weight', 'address', 'mobile'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'c_id', 'c_id');
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 't_id', 't_id');
    }
}
