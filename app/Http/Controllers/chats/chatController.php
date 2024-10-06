<?php

namespace App\Http\Controllers\chats;

use Inertia\Inertia;
use App\Models\chats;
use App\Events\sendMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class chatController extends Controller
{
    public function message_store(Request $request)
    { 

        $chatData = $request->validate([
            'sender_id' => 'required|numeric',
            'reciver_id' => 'required|numeric',
            'message' =>'required|string',
        ]);  
        if($chatData)
        {
           $chatData = chats::create([
                'sender_id' => $chatData['sender_id'], 
                'reciver_id' => $chatData['reciver_id'],
                'message' =>$chatData['message'],  
            ]) ;
            $chatData->save(); 
            broadcast(new sendMessage($chatData))->toOthers(); 
        }
        return; 
    } 
    
}
