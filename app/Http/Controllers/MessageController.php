<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = $request->input('offset'); 
        $mesages = Message::where('chat_id',$request->input('chat_id'))->orderBy('created_at', 'desc')->get();  //->skip($offset)->take(7)
        foreach($mesages as $mesage) {
            $mesage->read = 1;
            $mesage->save();
        }
        foreach($mesages as $mesage) {
            $mesage->from = $mesage->user->name;
            $mesage->date = $mesage->created_at->format('Y-m-d : H-m');
        }
        return json_encode($mesages);
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
    public function store(MessageRequest $request)
    {
        //$params = $request->all();
        //$message = Message::create($params);
        $message = new Message();
        $message->text = $request->input('text');
        $message->user_id = $request->input('user_id');
        $message->chat_id = $request->input('chat_id');
        $message->save();

       // \App\Events\NewMessage::dispatch($request->all());
        return json_encode($request->all());
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();
        $messages = Message::find($id)->update($params);
        
        return json_encode($messages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $msg =  Message::find($id)->delete();

       return json_encode($msg);
    }
}
