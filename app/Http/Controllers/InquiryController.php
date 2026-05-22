<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Inquiry request received:', $request->all());
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'wedding_date' => 'nullable|date',
                'package' => 'nullable|string|max:255',
                'message' => 'required|string',
            ]);
            
            if ($validator->fails()) {
                Log::error('Validation failed:', $validator->errors()->toArray());
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => $validator->errors()
                    ], 422);
                }
                
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $validated = $validator->validated();
            
            if (empty($validated['message'])) {
                $validated['message'] = 'Tidak ada pesan';
            }
            
            $inquiry = Inquiry::create($validated);
            
            Log::info('Inquiry saved successfully:', ['id' => $inquiry->id]);
            
            // Set session bahwa form sudah disubmit
            session(['form_submitted' => true, 'user_data' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'wedding_date' => $validated['wedding_date'] ?? null,
            ]]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan Anda telah terkirim. Kami akan menghubungi Anda segera!',
                    'data' => $inquiry
                ], 200);
            }
            
            return redirect()->back()->with('success', 'Pesan Anda telah terkirim. Kami akan menghubungi Anda segera!');
            
        } catch (\Exception $e) {
            Log::error('Inquiry error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}