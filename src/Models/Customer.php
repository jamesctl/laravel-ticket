<?php

namespace Globit\LaravelTicket\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = "customers";

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'customer_id');
    }

    public function insertData($data)
    {
        $insertedId = $this->insertGetId($data);

        return $this->find($insertedId);
    }

    public function getListById($customerId)
    {
        return $this
            ->where('id', $customerId)
            ->get();
    }

    public function getListByEmail($email)
    {
        return $this
            ->where('email', $email)
            ->first();
    }

    public function removeById($customerId)
    {
        return $this
            ->where('id', $customerId)
            ->delete();
    }
}
