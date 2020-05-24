<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use App\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('chats');
    }

    public function getMessages(){
        //get message object with your relation user object
        return Message::with('user')->get();
    }

    public function saveMessage(Request $request):array {

        $userId=auth()->user()->id;

        $message=new Message();
        $message->user_id=$userId;
        $message->message=$request->message;
        $message->save();

        //send object message and user to listen place
        broadcast(new SendMessageEvent($message->load('user')))->toOthers();

        return ['status'=>'success'];
    }
}
