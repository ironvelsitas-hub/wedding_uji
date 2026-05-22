<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';
    
    protected $fillable = [
        'session_id', 'inquiry_id', 'visitor_name', 'visitor_email', 'visitor_phone',
        'message', 'status', 'is_read_admin', 'is_read_visitor', 'is_from_admin'
    ];
    
    protected $casts = [
        'is_read_admin' => 'boolean',
        'is_read_visitor' => 'boolean',
        'is_from_admin' => 'boolean',
    ];
    
    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
}