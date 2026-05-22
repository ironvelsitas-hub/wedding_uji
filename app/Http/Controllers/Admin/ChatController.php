<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $pendingChats = Chat::where('status', 'pending')
            ->where('is_read_admin', false)
            ->latest()
            ->get();
            
        $allChats = Chat::latest()->paginate(20);
        
        return view('admin.chats.index', compact('pendingChats', 'allChats'));
    }
    
    public function show(Chat $chat)
    {
        if (!$chat->is_read_admin) {
            $chat->update(['is_read_admin' => true]);
        }
        
        return view('admin.chats.show', compact('chat'));
    }
    
    public function reply(Request $request, Chat $chat)
    {
        try {
            $validated = $request->validate([
                'admin_reply' => 'required|string|min:1',
            ]);
            
            // Buat chat baru untuk balasan admin
            $newChat = Chat::create([
                'session_id' => $chat->session_id,
                'inquiry_id' => $chat->inquiry_id,
                'visitor_name' => $chat->visitor_name,
                'visitor_email' => $chat->visitor_email,
                'visitor_phone' => $chat->visitor_phone,
                'message' => $validated['admin_reply'],
                'status' => 'replied',
                'is_read_admin' => true,
                'is_read_visitor' => false,
                'is_from_admin' => true
            ]);
            
            // Update status chat asli
            $chat->update(['status' => 'replied']);
            
            // Untuk request AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Balasan terkirim',
                    'data' => $newChat
                ]);
            }
            
            // Untuk request biasa
            return redirect()->route('admin.chats.show', $chat)
                ->with('success', 'Balasan berhasil dikirim ke pengunjung');
                
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function close(Chat $chat)
    {
        try {
            $chat->update(['status' => 'closed']);
            
            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Chat ditutup']);
            }
            
            return redirect()->route('admin.chats.index')
                ->with('success', 'Chat berhasil ditutup');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    public function destroy(Chat $chat)
    {
        $chat->delete();
        
        return redirect()->route('admin.chats.index')
            ->with('success', 'Chat berhasil dihapus');
    }
    
    public function markAsRead(Chat $chat)
    {
        $chat->update(['is_read_admin' => true]);
        return response()->json(['success' => true]);
    }
}