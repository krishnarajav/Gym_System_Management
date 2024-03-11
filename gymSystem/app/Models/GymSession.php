<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymSession extends Model
{
    protected $table = 'Gym_Sessions';
    protected $fillable = ['id', 's_date', 's_time', 'c_id', 't_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'c_id');
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 't_id');
    }
}