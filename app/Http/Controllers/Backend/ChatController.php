<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Events\NewMessage;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    public function index()
    {
        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();
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

    $chatRoom->update(['last_message_at' => now()]);
    $messages = Message::where('id','!=',$message->id)
                            ->where('chat_room_id',$roomId)
                            ->where('sender_id','!=',auth()->id())
                            ->get();
        foreach($messages as $seen){
            $seen->is_read = true;
            $seen->save();
        }
    broadcast(new NewMessage($message->load('sender')))->toOthers();

    return response()->json($message->load('sender'));
}
    
public function uploadFile(Request $request, $roomId)
{
    $request->validate([
        'file' => 'required|file|max:10240' // Max 10MB
    ]);

    $path = $request->file('file')->store('chat-files', 'public');
    
    $chatRoom = ChatRoom::findOrFail($roomId);
    $message = $chatRoom->messages()->create([
        'sender_id' => auth()->id(),
        'content' => 'Sent a file: ' . $request->file('file')->getClientOriginalName(),
        'file_path' => $path
    ]);

    $chatRoom->update(['last_message_at' => now()]);

    broadcast(new NewMessage($message->load('sender')))->toOthers();

    return response()->json($message->load('sender'));
}

public function markAsRead($roomId)
{
    $chatRoom = ChatRoom::findOrFail($roomId);
    
    $chatRoom->messages()
        ->where('sender_id', '!=', auth()->id())
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return response()->json(['success' => true]);
}
}

