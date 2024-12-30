<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\ReplyTicket;

class Ticket extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = "tickets";

    protected $fillable = [
        'title',
        'status',
        'user_id',
        'customer_id',
        'description'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function replies()
    {
        return $this->hasMany(ReplyTicket::class, foreignKey: 'ticket_id', localKey: 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, foreignKey: 'user_id');
    }

    public function ticketAttachments()
    {
        return $this->hasMany(Attachment::class, 'ticket_id');
    }

    public function insertData($data)
    {
        return $this
            ->insert($data);
    }

    public function getList($customerId)
    {
        return $this
            ->where('user_id', $customerId)
            ->get();
    }

    public function removeById($customerId)
    {
        return $this
            ->where('user_id',$customerId)
            ->delete();
    }

    public function getListPagination($data = [], $perPage = 10)
    {
        $query = self::query();

        // $query->where('user_id', $data['userId']);

        if(!empty($data['customer_id'])) {
            $query->whereCustomerId($data['customer_id']);
        }

        if (isset($data['status']) && $data['status'] !== '') {
            $query->where('status', $data['status']);
        }

        if (isset($data['title']) && $data['title'] !== '') {
            $query->where('title', 'LIKE', '%' . $data['title'] . '%');
        }
    
        return $query;
    }

    public function findByTitle($title) 
    {
        return $this->where('title', $title)
            ->first();
    }

}
