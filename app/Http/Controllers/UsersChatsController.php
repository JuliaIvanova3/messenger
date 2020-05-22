<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\UsersChats;
use Illuminate\Http\Request;

class UsersChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $chats = UsersChats::with('user')->select('id', 'user_id')->where('chat_id', $id)->get();
        // foreach($chats as $chat) {
        //     $chat->member = $chat->user->name;
        // }

        return json_encode($chats);
    }

    public function get($id)
    {
        $users = UsersChats::select('user_id')->where('chat_id', $id)->get()->toArray();
        //array_push($users, Auth::id());
        $notUsers = User::whereNotIn('id', $users)->get();
        return json_encode($notUsers);
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
    public function store(Request $request)
    {
        $params = $request->all();
        $userChat = UsersChats::create($params);
        return json_encode($userChat);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UsersChats  $usersChats
     * @return \Illuminate\Http\Response
     */
    public function show(UsersChats $usersChats)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UsersChats  $usersChats
     * @return \Illuminate\Http\Response
     */
    public function edit(UsersChats $usersChats)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UsersChats  $usersChats
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();
        $record = UsersChats::find($id)->update($params);

        return json_encode($record);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UsersChats  $usersChats
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = UsersChats::find($id)->delete();
        return json_encode($record);
    }
}
