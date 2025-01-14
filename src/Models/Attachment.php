<?php

namespace Globit\LaravelTicket\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = "attachments";

    protected $fillable = [
        'ticket_id',
        'reply_ticket_id',
        'filename',
        'path',
        'mine_type',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function replyTicket()
    {
        return $this->belongsTo(ReplyTicket::class, 'reply_ticket_id');
    }
}
