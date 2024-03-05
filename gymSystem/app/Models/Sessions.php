<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    protected $table = 'Sessions';
    protected $primaryKey = null; 
    public $incrementing = false; 
    protected $fillable = ['s_date', 's_time', 'c_id', 't_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'c_id');
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 't_id');
    }
}