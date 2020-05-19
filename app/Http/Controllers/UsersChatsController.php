<?php

namespace App\Http\Controllers;

use App\UsersChats;
use Illuminate\Http\Request;

class UsersChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function update(Request $request, UsersChats $usersChats)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UsersChats  $usersChats
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsersChats $usersChats)
    {
        //
    }
}
