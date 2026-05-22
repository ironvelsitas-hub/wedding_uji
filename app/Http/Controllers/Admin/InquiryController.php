<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Chat;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::latest()->paginate(10);
        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(Inquiry $inquiry)
    {
        if (!$inquiry->is_read) {
            $inquiry->update(['is_read' => true]);
        }
        
        // Cari session_id dari chat yang terhubung dengan inquiry ini
        $chat = Chat::where('inquiry_id', $inquiry->id)->first();
        $sessionId = $chat ? $chat->session_id : null;
        
        return view('admin.inquiries.show', compact('inquiry', 'sessionId'));
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Pesan berhasil dihapus');
    }

    public function markAsRead(Inquiry $inquiry)
    {
        $inquiry->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }
}