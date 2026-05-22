<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Chat store request:', $request->all());
        
        $validated = $request->validate([
            'message' => 'required|string',
            'visitor_name' => 'nullable|string|max:255',
            'visitor_email' => 'nullable|email|max:255',
            'visitor_phone' => 'nullable|string|max:20',
            'inquiry_id' => 'nullable|exists:inquiries,id',
            'is_from_admin' => 'nullable|boolean',
            'session_id' => 'nullable|string',
        ]);
        
        // Gunakan session_id dari request atau buat baru
        $sessionId = $validated['session_id'] ?? $request->cookie('chat_session_id');
        
        if (!$sessionId) {
            $sessionId = Str::random(40);
        }
        
        // Cari inquiry berdasarkan email
        $inquiryId = $validated['inquiry_id'] ?? null;
        if (!$inquiryId && !empty($validated['visitor_email'])) {
            $inquiry = Inquiry::where('email', $validated['visitor_email'])->first();
            if ($inquiry) {
                $inquiryId = $inquiry->id;
                Log::info('Inquiry found:', ['id' => $inquiryId, 'email' => $validated['visitor_email']]);
            }
        }
        
        $isFromAdmin = $validated['is_from_admin'] ?? false;
        $status = $isFromAdmin ? 'replied' : 'pending';
        
        $chat = Chat::create([
            'session_id' => $sessionId,
            'inquiry_id' => $inquiryId,
            'visitor_name' => $validated['visitor_name'] ?? null,
            'visitor_email' => $validated['visitor_email'] ?? null,
            'visitor_phone' => $validated['visitor_phone'] ?? null,
            'message' => $validated['message'],
            'status' => $status,
            'is_read_admin' => $isFromAdmin ? true : false,
            'is_read_visitor' => $isFromAdmin ? false : true,
            'is_from_admin' => $isFromAdmin,
        ]);
        
        Log::info('Chat created:', ['id' => $chat->id, 'session_id' => $sessionId, 'is_from_admin' => $isFromAdmin, 'inquiry_id' => $inquiryId]);
        
        $cookie = cookie('chat_session_id', $sessionId, 60 * 24 * 7);
        
        return response()->json([
            'success' => true,
            'chat' => $chat,
            'session_id' => $sessionId
        ])->cookie($cookie);
    }
    
    public function checkStatus(Request $request)
    {
        $sessionId = $request->cookie('chat_session_id');
        
        Log::info('Check status for session:', ['session_id' => $sessionId]);
        
        if (!$sessionId) {
            return response()->json(['has_reply' => false]);
        }
        
        // Cari pesan dari admin yang belum dibaca user
        $replies = Chat::where('session_id', $sessionId)
            ->where('is_from_admin', true)
            ->where('is_read_visitor', false)
            ->get();
        
        Log::info('Replies found:', ['count' => $replies->count()]);
        
        // Mark as read
        if ($replies->count() > 0) {
            Chat::whereIn('id', $replies->pluck('id'))->update(['is_read_visitor' => true]);
        }
        
        return response()->json([
            'has_reply' => $replies->count() > 0,
            'replies' => $replies
        ]);
    }
    
    public function getHistory(Request $request)
    {
        $sessionId = $request->cookie('chat_session_id');
        
        Log::info('Get history for session:', ['session_id' => $sessionId]);
        
        if (!$sessionId) {
            return response()->json(['chats' => []]);
        }
        
        $chats = Chat::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();
        
        Log::info('Chats found:', ['count' => $chats->count()]);
        
        return response()->json(['chats' => $chats]);
    }
    
    public function saveIdentity(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'wedding_date' => 'nullable|date',
        ]);
        
        $sessionId = $request->cookie('chat_session_id');
        if (!$sessionId) {
            $sessionId = Str::random(40);
        }
        
        $inquiry = Inquiry::where('email', $validated['email'])->first();
        
        if (!$inquiry) {
            $inquiry = Inquiry::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'wedding_date' => $validated['wedding_date'],
                'message' => 'Identitas dari chat',
                'is_read' => false,
            ]);
            Log::info('New inquiry created from identity:', ['id' => $inquiry->id]);
        }
        
        Chat::where('session_id', $sessionId)
            ->whereNull('inquiry_id')
            ->update([
                'inquiry_id' => $inquiry->id,
                'visitor_name' => $validated['name'],
                'visitor_email' => $validated['email'],
                'visitor_phone' => $validated['phone'],
            ]);
        
        $cookie = cookie('chat_session_id', $sessionId, 60 * 24 * 7);
        
        return response()->json([
            'success' => true,
            'message' => 'Identitas berhasil disimpan',
            'inquiry_id' => $inquiry->id,
            'session_id' => $sessionId
        ])->cookie($cookie);
    }
}