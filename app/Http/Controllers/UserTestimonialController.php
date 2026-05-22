<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserTestimonialController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'wedding_date' => 'nullable|date',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $testimonial = Testimonial::create([
                'client_name' => $request->client_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'wedding_date' => $request->wedding_date,
                'message' => $request->message,
                'rating' => $request->rating,
                'status' => 'pending',
                'is_verified' => false,
                'submitted_at' => now(),
            ]);

            Log::info('New testimonial submitted:', ['id' => $testimonial->id]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Terima kasih! Ulasan Anda akan kami verifikasi terlebih dahulu sebelum ditampilkan.'
                ]);
            }

            return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda akan kami verifikasi terlebih dahulu sebelum ditampilkan.');

        } catch (\Exception $e) {
            Log::error('Testimonial submission error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan. Silakan coba lagi.'], 500);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}