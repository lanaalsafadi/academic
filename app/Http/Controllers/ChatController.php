<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;

class ChatController extends Controller
{
   
    public function index()
    { 
        if (auth('student')->check()) {
            $student_id = auth()->student()->id;
    
          
            Chat::create([
                'student_id' => $student_id,
                'support_id' => 1,  
                'updated_at' => now(),
                'created_at' => now(),
            ]);
    
            return view('chat.reply'); 
        } else {
            
            return redirect()->route('students.login')->with('error', 'You need to log in first.');
        }
    }

    // عرض المحادثات لجميع الطلاب
    public function supportIndex()
    {
        $chats = Chat::all();
        return view('consultation', compact('chats'));
    }

    // عرض المحادثة المحددة
    public function show($id)
    {
        $chat = Chat::findOrFail($id);
        return view('consultation', compact('chat'));
    }

    // تخزين الرسائل في المحادثة
    public function storeMessage(Request $request, $chatId)
    {
        
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

     
        if (!auth()->check()) {
            return response()->json(['message' => 'You must be logged in to send a message'], 401);
        }

       
        $studentId = auth()->id();

        // إضافة الرسالة
        Message::create([
            'chat_id' => $chatId,
            'message' => $validated['message'],
            'user_id' => $studentId, 
        ]);

        return response()->json(['message' => 'Message stored successfully!']);
    }
}
