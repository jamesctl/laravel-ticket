<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyTicket extends Model
{
    use HasFactory;

    protected $table = "reply_tickets";

    protected $fillable = [
        'ticket_id',
        'from_email',
        'to_email',
        'message'
    ];    

    public function ticket(){
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function replyTicketAttachments()
    {
        return $this->hasMany(Attachment::class, 'reply_ticket_id');
    }

}
