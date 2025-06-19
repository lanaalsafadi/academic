<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\Message;
;
class SupportController extends Controller
{
    public function index()
    {
        
        $message = ContactMessage::find(1);

   
        return view('support.index', compact('message'));
    }
    //
     // عرض جميع الرسائل
     public function showMessages()
     {
         $messages = ContactMessage::where('is_reply', 0)->get();  
         return view('support.email.show', compact('messages')); 
     }
 
    
     // عرض نموذج الرد على الرسالة
     public function showReplyForm($id)
     {
         $message = ContactMessage::findOrFail($id);  
         return view('support.email.reply', compact('message'));  
     }
 
     // إرسال الرد عبر البريد الإلكتروني
     public function sendReply(Request $request, $id)
     { $message = ContactMessage::find($id);

        if (!$message) {
            return redirect()->route('support.dashboard')->with('error', 'Message not found');
        }
    
    
        $message->reply = $request->input('reply');
        $message->save();
    
     
        return redirect()->route('support.dashboard')->with('success', 'Reply sent successfully');
    
     }
     public function reply(Request $request, $id)
     {
        
    $message = ContactMessage::find($id);

    if (!$message) {
        return redirect()->route('support.dashboard')->with('error', 'Message not found');
    }

  
    return view('support.email.reply', compact('message')); 
     }

     public function replymessage(Request $request, $id)
     {
        
    $message = ContactMessage::find($id);

    if (!$message) {
        return redirect()->route('support.dashboard')->with('error', 'Message not found');
    }

  
    if ($request->isMethod('post')) {
        $message->reply = $request->input('reply'); 
        $message->is_reply = true; // تعيين أن الرسالة تم الرد عليها
        $message->save(); 
        
      
        return redirect()->route('support.dashboard')->with('success', 'Reply sent successfully');
    }

   
    return view('support.email.show', compact('message'));
     }




}
