<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'client_name', 'couple_name', 'message', 'wedding_date', 'venue',
        'package_used', 'photo', 'video_url', 'rating', 'status', 
        'is_featured', 'testimonial_date'
    ];
    
    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
        'testimonial_date' => 'date',
        'wedding_date' => 'date',
    ];
    
    // Accessor untuk foto URL
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
    
    // Accessor untuk rating bintang
    public function getStarRatingAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-warning"></i>';
            }
        }
        return $stars;
    }
    
    // Scope untuk testimonial yang disetujui
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    
    // Scope untuk testimonial featured
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}