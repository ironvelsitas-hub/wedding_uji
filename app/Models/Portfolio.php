<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'title', 'description', 'category', 'client_name', 'venue', 
        'image', 'gallery', 'event_date', 'is_featured', 'video_url'
    ];
    
    protected $casts = [
        'event_date' => 'date',
        'is_featured' => 'boolean',
        'gallery' => 'array',
    ];
    
    // Fungsi untuk mendapatkan embed URL
    public function getEmbedUrlAttribute()
    {
        if (!$this->video_url) return null;
        
        $url = $this->video_url;
        
        // Konversi berbagai format YouTube ke embed URL
        if (strpos($url, 'youtube.com/watch') !== false) {
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            if (isset($params['v'])) {
                return 'https://www.youtube.com/embed/' . $params['v'];
            }
        } elseif (strpos($url, 'youtu.be') !== false) {
            $videoId = substr($url, strrpos($url, '/') + 1);
            // Hapus parameter query jika ada
            $videoId = preg_replace('/\?.*/', '', $videoId);
            return 'https://www.youtube.com/embed/' . $videoId;
        } elseif (strpos($url, 'youtube.com/embed') !== false) {
            return $url;
        } elseif (strpos($url, 'vimeo.com') !== false) {
            $videoId = substr($url, strrpos($url, '/') + 1);
            return 'https://player.vimeo.com/video/' . $videoId;
        }
        
        return $url;
    }
    
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
    
    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) return [];
        
        return array_map(function($image) {
            return asset('storage/' . $image);
        }, $this->gallery);
    }
}