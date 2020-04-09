<?php


namespace App\Http\Controllers\Api;


use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getConversations(Request $request){
        $user = $request->user();

        $conversations = [];
        $user->messages()->each(function($message, $key) use($user, &$conversations){
            // If the message is from the current user, it should treat "to" as the key
            if($message->from_id == $user->id){
                if(!array_key_exists($message->to_id, $conversations)){
                    $conversations[$message->to_id] = [$message];
                }else{
                    array_push($conversations[$message->to_id], $message);
                }
            }else{ // Else it treat "from" as the key
                if(!array_key_exists($message->from_id, $conversations)){
                    $conversations[$message->from_id] = [$message];
                }else{
                    array_push($conversations[$message->from_id], $message);
                }
            }
        });

        // Add all the friends if they don't have messages
        $user->friends()->each(function ($friend, $key) use (&$conversations) {
            if (!array_key_exists($friend->id, $conversations)) {
                $conversations[$friend->id] = [];
            }
        });

        // Format the conversations in a format easily parseable by an API
        $formattedConversations = [];
        foreach($conversations as $key => $messages){
            $nbMessages = min(10, count($messages));

            $formattedConversations[] = [
                'with_user' => User::query()->where('id', $key)->firstOrFail(),
                'messages' => array_splice($messages, count($messages) - $nbMessages),
                'last_message' => count($messages) > 0 ? $messages[count($messages) - 1] : null
            ];
            error_log("3");
        }

        return $formattedConversations;
    }

    public function fetchMessages(Request $request){
        $user = $request->user();
        if($request->has('with_user_id')){
            $with_user_id = $request->input('with_user_id');
            $with_user = User::query()->where('id', $with_user_id)->firstOrFail();
            $this->authorize('chatWith', [Message::class, $with_user]);

            $sent = $user->messagesSent()->where('to_id', $with_user_id);
            $received = $user->messagesReceived()->where('from_id', $with_user_id);
        }else{
            // Else return all messages
            $sent = $user->messagesSent;
            $received = $user->messagesReceived;
        }

        return response()->json([
            'sent' => $sent,
            'received' => $received
        ]);
    }

    public function sendMessage(Request $request){
        $this->validate($request, [
            'to_user_id' => 'required|numeric|min:0',
            'message' => 'required'
        ]);

        $user = $request->user();
        $to_user = User::query()->where('id', $request->input('to_user_id'))->firstOrFail();

        $this->authorize('chatWith', [Message::class, $to_user]);

        $message = new Message([
            'message' => $request->input('message'),
        ]);
        $message->from_id = $user->id;
        $message->to_id = $to_user->id;
        $message->save();

        // Broadcast the send message notification
        broadcast(new MessageSent($user, $to_user, $message))->toOthers();

        return response()->json([
            'success' => true,
        ]);
    }
}
