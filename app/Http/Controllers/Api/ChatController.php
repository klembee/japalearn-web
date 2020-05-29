<?php


namespace App\Http\Controllers\Api;


use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Api controller that allows user to view their conversation
 * and send messages to their friends
 *
 * Class ChatController
 * @package App\Http\Controllers\Api
 */
class ChatController extends Controller
{

    /**
     * Get the conversations that the logged in user
     * had. This method returns a dictionary where every key are
     * the id of the friend with who the logged in user communicated.
     * the values of the dictionary are list containing messages
     *
     * @param Request $request
     * @return array
     */
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

        }

        return $formattedConversations;
    }

    /**
     * Allow a user to send a message to his/her friends
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendMessage(Request $request){
        $this->validate($request, [
            'to_user_id' => 'required|numeric|min:0',
            'message' => 'required'
        ]);

        $user = $request->user();
        $to_user = User::query()->where('id', $request->input('to_user_id'))->firstOrFail();

        // Check that this user is friend with the recipient
        $this->authorize('chatWith', [Message::class, $to_user]);

        $message = new Message([
            'message' => $request->input('message'),
        ]);

        $message->from_id = $user->id;
        $message->to_id = $to_user->id;
        $message->save();

        // Broadcast the send message notification so that the ui updates on the recipient computer
        broadcast(new MessageSent($user, $to_user, $message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message->load(['from', 'to'])
        ]);
    }
}
