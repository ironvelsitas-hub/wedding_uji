<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Package;
use App\Models\Portfolio;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::take(6)->get();
        $packages = Package::take(3)->get();
        $portfolios = Portfolio::latest()->take(6)->get();
        $testimonials = Testimonial::latest()->take(3)->get();
        
        return view('home', compact('services', 'packages', 'portfolios', 'testimonials'));
    }
    
    public function about()
    {
        return view('about');
    }
    
 public function services()
    {
        $services = Service::all();
        return view('services', compact('services'));
    }
    
    public function packages()
    {
        $packages = Package::all();
        return view('packages', compact('packages'));
    }    
    public function portfolio()
    {
        $portfolios = Portfolio::latest()->paginate(9);
        return view('portfolio', compact('portfolios'));
    }
    
public function portfolioDetail($id, $slug = null)
{
    $portfolio = Portfolio::findOrFail($id);
    
    // Proses video URL (untuk view)
    if ($portfolio->video_url) {
        $portfolio->video_embed = $this->getYouTubeEmbedUrl($portfolio->video_url);
    }
    
    // Ambil portfolio terkait
    $relatedPortfolios = Portfolio::where('id', '!=', $id)
        ->where('category', $portfolio->category)
        ->latest()
        ->take(3)
        ->get();
    
    return view('portfolio-detail', compact('portfolio', 'relatedPortfolios'));
}    
    public function testimonials()
    {
        $testimonials = Testimonial::where('status', 'approved')->latest()->paginate(6);
        
        $averageRating = Testimonial::where('status', 'approved')->avg('rating') ?? 0;
        $fiveStarCount = Testimonial::where('status', 'approved')->where('rating', 5)->count();
        
        return view('testimonials', compact('testimonials', 'averageRating', 'fiveStarCount'));
    }    
    
public function contact(Request $request)
{
    $selectedPackage = $request->get('package', '');
    
    if ($selectedPackage && !in_array($selectedPackage, ['Paket Silver', 'Paket Gold', 'Paket Platinum'])) {
        $selectedPackage = '';
    }
    
    // Cek session untuk form submission
    $formSubmitted = session('form_submitted', false);
    $userData = session('user_data', null);
    
    return view('contact', compact('selectedPackage', 'formSubmitted', 'userData'));
}    
    /**
     * Fungsi untuk mengkonversi berbagai format URL video ke embed URL
     * Support YouTube, Vimeo, dan platform lainnya
     */
    private function getVideoEmbedUrl($url)
    {
        if (empty($url)) {
            return null;
        }
        
        $url = trim($url);
        
        // ============ YOUTUBE ============
        // Cek URL YouTube berbagai format
        if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
            // Pattern untuk extract video ID YouTube
            $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
            preg_match($pattern, $url, $matches);
            
            if (isset($matches[1])) {
                $videoId = $matches[1];
                return "https://www.youtube.com/embed/" . $videoId . "?autoplay=0&rel=0&showinfo=0&modestbranding=1";
            }
            
            // Jika pattern tidak match, coba cara manual
            if (strpos($url, 'youtube.com/embed/') !== false) {
                return $url . "?autoplay=0&rel=0&showinfo=0&modestbranding=1";
            }
            
            if (strpos($url, 'youtu.be') !== false) {
                $videoId = substr($url, strrpos($url, '/') + 1);
                // Hapus parameter query jika ada
                $videoId = preg_replace('/\?.*/', '', $videoId);
                return "https://www.youtube.com/embed/" . $videoId . "?autoplay=0&rel=0&showinfo=0&modestbranding=1";
            }
            
            if (strpos($url, 'youtube.com/watch') !== false) {
                parse_str(parse_url($url, PHP_URL_QUERY), $params);
                if (isset($params['v'])) {
                    return "https://www.youtube.com/embed/" . $params['v'] . "?autoplay=0&rel=0&showinfo=0&modestbranding=1";
                }
            }
        }
        
        // ============ VIMEO ============
        if (strpos($url, 'vimeo.com') !== false) {
            $pattern = '/(?:vimeo\.com\/)(\d+)/';
            preg_match($pattern, $url, $matches);
            if (isset($matches[1])) {
                return "https://player.vimeo.com/video/" . $matches[1] . "?autoplay=0";
            }
        }
        
        // ============ DAILYMOTION ============
        if (strpos($url, 'dailymotion.com') !== false) {
            $pattern = '/dailymotion\.com\/video\/([a-zA-Z0-9]+)/';
            preg_match($pattern, $url, $matches);
            if (isset($matches[1])) {
                return "https://www.dailymotion.com/embed/video/" . $matches[1];
            }
        }
        
        // ============ FACEBOOK VIDEO ============
        if (strpos($url, 'facebook.com') !== false) {
            // Facebook video memerlukan embed URL khusus
            return $url; // Return asli karena Facebook embed complex
        }
        
        // ============ INSTAGRAM ============
        if (strpos($url, 'instagram.com') !== false) {
            return $url;
        }
        
        // ============ TIKTOK ============
        if (strpos($url, 'tiktok.com') !== false) {
            return $url;
        }
        
        // Jika URL sudah dalam format embed yang valid
        if (preg_match('/\/embed\//', $url)) {
            return $url;
        }
        
        // Return URL asli jika tidak ada format yang match
        return $url;
    }
    
    /**
     * Fungsi alternatif untuk YouTube saja (lebih sederhana)
     * Bisa digunakan jika hanya butuh support YouTube
     */
// Fungsi konversi URL YouTube
private function getYouTubeEmbedUrl($url)
{
    if (empty($url)) return null;
    
    $url = trim($url);
    
    // Jika sudah berupa embed URL
    if (strpos($url, 'youtube.com/embed/') !== false) {
        return $url . "?autoplay=0&rel=0&showinfo=0&modestbranding=1";
    }
    
    // Jika URL dari share (youtu.be)
    if (strpos($url, 'youtu.be') !== false) {
        $videoId = substr($url, strrpos($url, '/') + 1);
        $videoId = preg_replace('/\?.*/', '', $videoId);
        return "https://www.youtube.com/embed/" . $videoId . "?autoplay=0&rel=0&showinfo=0&modestbranding=1";
    }
    
    // Jika URL standar YouTube
    if (strpos($url, 'youtube.com/watch') !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        if (isset($params['v'])) {
            return "https://www.youtube.com/embed/" . $params['v'] . "?autoplay=0&rel=0&showinfo=0&modestbranding=1";
        }
    }
    
    return $url;
}
}