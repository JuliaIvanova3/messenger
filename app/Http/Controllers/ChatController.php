<?php

namespace App\Http\Controllers;

use App\Chat;
use App\UsersChats;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Requests\ChatRequest;
use Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chats = Chat::where('creator_id', Auth::id())->orderBy('updated_at', 'desc')->get();
        foreach($chats as $chat) {
            $chat->last_msg = Message::where('chat_id', $chat->id)->orderby('created_at', 'desc')->first();
            $chat->unread = Message::where([
                ['chat_id', '=', $chat->id],
                ['user_id', '<>', Auth::id()],
                ['read', '=',0]
            ])->count();
        }
        $chats->toArray();
        $chatTo = UsersChats::where('user_id', Auth::id())->get();
        foreach($chatTo as $chat) {
            $chats[] = Chat::find($chat->chat_id);
        }
        foreach($chats as $chat) {
            $chat->last_msg = Message::where('chat_id', $chat['id'])->orderby('created_at', 'desc')->first();
            $chat->unread = Message::where([
                ['chat_id', '=', $chat->id],
                ['user_id', '<>', Auth::id()],
                ['read', '=',0]
            ])->count();
        }
        return json_encode($chats);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChatRequest $request)
    {
        $params = $request->all();
        $chat = new Chat();
        $chat->creator_id = $request->input('creator_id');
        $chat->title = $request->input('title');
        $chat->save();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName =$chat->id.'.'.$image->getClientOriginalExtension();
            $chat->image = $fileName;
            $file = $image->storeAs('/uploads', $fileName, [
                "disk" => 'public'
            ]);
        } else {
            $chat->image = 'logo2.png';
        }
        $chat->save();

        return json_encode($chat);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();
        $chat = Chat::find($id);
        $chat->title = $request->input('title');
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName =$chat->id.'.'.$image->getClientOriginalExtension();
            $chat->image = $fileName;
            $file = $image->storeAs('/uploads', $fileName, [
                "disk" => 'public'
            ]);
        }
       
        $chat->save();

        return json_encode($chat);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
