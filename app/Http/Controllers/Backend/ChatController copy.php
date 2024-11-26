<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\ChatRoom;
use App\Models\Message;



class ChatController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('is_read',0)->get();
        $chatRooms = ChatRoom::where('user_id', auth()->id())
            ->orWhere('other_user_id', auth()->id())
            ->with(['user', 'otherUser'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('admin.chat', compact('chatRooms','notifications'));
    }

    public function show($roomId)
    {
        $chatRoom = ChatRoom::findOrFail($roomId);
        $messages = $chatRoom->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        $chatRoom->messages()
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'messages' => $messages
        ]);
    }

    public function store(Request $request, $roomId)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $chatRoom = ChatRoom::findOrFail($roomId);
        
        $message = $chatRoom->messages()->create([
            'sender_id' => auth()->id(),
            'content' => $request->content
        ]);
        $messages = Message::where('id','!=',$message->id)
                            ->where('chat_room_id',$roomId)
                            ->where('sender_id','!=',auth()->id())
                            ->get();
        foreach($messages as $seen){
            $seen->is_read = true;
            $seen->save();
        }

        $chatRoom->update(['last_message_at' => now()]);

        // broadcast(new NewMessage($message->load('sender')))->toOthers();

        return response()->json($message->load('sender'));
    }
    public function markAsRead($roomId)
{
    $chatRoom = ChatRoom::findOrFail($roomId);

    $chatRoom->messages()
        ->where('sender_id', '!=', auth()->id()) // Tin nhắn từ người khác
        ->where('is_read', false)               // Chỉ những tin chưa đọc
        ->update(['is_read' => true]);          // Đánh dấu là đã đọc

    return response()->json(['status' => 'success']);
}

}

