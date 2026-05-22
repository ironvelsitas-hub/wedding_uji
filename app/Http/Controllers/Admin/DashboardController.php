<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Package;
use App\Models\Portfolio;
use App\Models\Testimonial;
use App\Models\Inquiry;

class DashboardController extends Controller
{
    public function index()
    {
        $totalServices = Service::count();
        $totalPackages = Package::count();
        $totalPortfolios = Portfolio::count();
        $totalTestimonials = Testimonial::count();
        $totalInquiries = Inquiry::count();
        $recentInquiries = Inquiry::latest()->take(5)->get();
        
        // Hapus statistik chat
        
        return view('admin.dashboard', compact(
            'totalServices', 'totalPackages', 'totalPortfolios',
            'totalTestimonials', 'totalInquiries', 'recentInquiries'
        ));
    }
}