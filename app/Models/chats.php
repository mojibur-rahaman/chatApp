<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chats extends Model
{
    use HasFactory;

    protected  $fillable = [
        'sender_id',
        'reciver_id',
        'message',
        'is_read',
        'is_edited',
        'is_deleted',
        'deleted_from_sender',
        'deleted_form_reciver' ,
    ];  
}
