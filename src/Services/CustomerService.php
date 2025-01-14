<?php

namespace Globit\LaravelTicket\Services;

use Globit\LaravelTicket\Models\Customer;

class CustomerService extends Base
{
    public function getByEmail(string $email = '')
    {
        $customer = Customer::whereEmail($email)->get();
        return $customer ?? [];
    }

    public function create(array $params)
    {
        $customer = new Customer;
        $customer->name = $params['name'];
        $customer->email = $params['email'];
        $customer->save();
        return $customer;
    }

    public static function rand_pass( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }

}