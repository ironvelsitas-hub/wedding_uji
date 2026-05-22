<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $table = 'inquiries';
    
    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'wedding_date', 
        'package',     // Pastikan ini ada
        'message', 
        'is_read'
    ];
    
    protected $casts = [
        'wedding_date' => 'date',
        'is_read' => 'boolean',
    ];
}