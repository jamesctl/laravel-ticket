<?php

namespace Globit\LaravelTicket\Services;

use Globit\LaravelTicket\Enums\Ticket as eTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Globit\LaravelTicket\Models\Customer;
use Globit\LaravelTicket\Models\Ticket;
use Globit\LaravelTicket\Models\ReplyTicket;
use Webklex\PHPIMAP\Message;
use Illuminate\Support\Facades\Storage;
use Globit\LaravelTicket\Models\Attachment;
use Globit\LaravelTicket\Models\User;
use Illuminate\Support\Facades\Log;

class TicketService extends Base
{
    public function index($data = [])
    {
        // get list email from the system
        $model = new Ticket;
        return $model->getListPagination($data);
    }

    public function getByID($id)
    {
        $ticket = Ticket::with(['replies', 'customer', 'user', 'ticketAttachments', 'replies.replyTicketAttachments'])->findOrFail($id);
        $ticket->replies->each(function ($reply) {
            $reply->attachments = $reply->replyTicketAttachments;
            unset($reply->replyTicketAttachments);
        });
    
        return $ticket;
    }
    
    public function create(Message $message, $emails = [], $params = [], $attachment_inbox = true, $system_create = false)
    {
        $existingCustomers = Customer::whereIn('email', $emails)->get();

        $existingEmails = $existingCustomers->pluck('email')->toArray();

        // get a new email
        $newEmails = array_diff($emails, $existingEmails);
        // insert new customer
        if (!empty($newEmails)) {
            foreach ($newEmails as $email) {
                $password = Str::random(8);
            
                $customerData = [
                    'name' => !empty($params['customer_name']) ? $params['customer_name'] : explode('@', $email)[0],
                    'email' => $email,
                    'password' => bcrypt($password),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                
                Customer::insert($customerData);

                \Mail::to($email)->send(
                    new \App\Mail\SendCustomerInfoMail(
                        'Welcome to Ticket Management',
                        $customerData['email'],
                        $customerData['name'],
                        $password
                    )
                );
            }
        }

        $allCustomers = Customer::whereIn('email', $emails)->get()->keyBy('email');
        // get list ID
        $orderedCustomerIds = $allCustomers->pluck('id')->toArray();

        // insert to ticket 
        foreach ($orderedCustomerIds as $customerId) {
            $ticketData = [
                "title" => !empty($params['title']) ? $params['title'] : 'N/A',
                "status" => 'New',
                "customer_id" => $customerId,
                "user_id" => auth()->user()->id ?? $params['user_id'],
                "description" => !empty($params['description']) ? $params['description'] : 'N/A',
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ];
            
            $ticket_id = Ticket::insertGetId($ticketData);

            if($attachment_inbox) {
                $this->autoStoreEmailAttachments($message, $ticket_id, 0);
            } else {
                $this->systemAttachFilesToMail($params['files'], ['ticket_id' => $ticket_id]);
            }
        }

        if($system_create) {
            //send email from system manual create
            foreach ($allCustomers as $customer) {
                \Mail::to(users: $customer->email)->send(new \App\Mail\TestMail($params['title'], $customer->name, $params['description'] ?? 'N/A'));
            }
        }
    }

    public function sendTicketReply($params = [])
    {
        $ticket = Ticket::find($params['ticket_id']);
        if ($ticket) {
            // Processing insert reply
            $reply_id = ReplyTicket::insertGetId([
                'ticket_id' => $params['ticket_id'],
                'from_email'   => !empty($params['from_email']) ? $params['from_email'] : null,
                'to_email'   => !empty($params['to_email']) ? $params['to_email'] : null,
                'message' => self::removeMediaLinkHtml($params['message']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $replySubject = 'Re: ' . $params['subject'];
            //send mail
            if (isset($params['files'])) {
                \Mail::to($params['to_email'])->send(
                    new \App\Mail\TestMail($replySubject, 
                    $params['customer_name'], 
                    self::removeMediaLinkHtml($params['message']),
                    $params['files']
                ));

                // Save File
                $params['reply_id'] = !empty($reply_id) ? $reply_id : 0;
                $this->systemAttachFilesToMail($params['files'], $params);
            } else {
                \Mail::to($params['to_email'])->send(
                    new \App\Mail\TestMail($replySubject, 
                    $params['customer_name'], 
                    self::removeMediaLinkHtml($params['message']),
                ));
            }

            // update status  ticket 
            $ticket->status = $params['status'];
            $ticket->save();
        } else {
            return response()->json(['error' => 'Ticket not found.'], 404);
        }
    }

    public function store(array $params)
    {
        $ticket = new Ticket;
        $ticket->title = $params['title'];
        $ticket->customer_id = $params['customer_id'];
        $ticket->user_id = $params['user_id'];
        $ticket->description = $params['description'];
        $ticket->status = $params['status'];
        $ticket->save();
    }

    public function createReply(Message $message, $params = [], $attachment_inbox = true)
    {
        $oriSubject = $this->getOriginSubjectName($params['subject']);
        $ticket = (new Ticket)->findByTitle($oriSubject);
        if (!empty($ticket)) {
            $reply_id = ReplyTicket::insertGetId([
                'ticket_id' => $ticket->id,
                'from_email'   => !empty($params['from_email']) ? $params['from_email'] : null,
                'to_email'   => !empty($params['to_email']) ? $params['to_email'] : null,
                'message' => $params['message'],
            ]);

            if($attachment_inbox) {
                $this->autoStoreEmailAttachments($message, $ticket->id, $reply_id);
            } else {
                $this->systemAttachFilesToMail($params['files'], ['ticket_id' => $ticket->id, 'reply_id' => $reply_id]);
            }
        }

        return $reply_id ?? null;
    }

    public function getOriginSubjectName($reply_subject)
    {
        $subject = explode('Re:', $reply_subject);
        return !empty($subject[1]) ? trim(str_replace('_', " ", $subject[1])) : null;
    }

    public static function isReplyMessage($subject)
    {
        $checkSubject = explode('Re:', $subject);
        return is_array($checkSubject) && !empty($checkSubject[1]) ? true : false;
    }

    public function autoStoreEmailAttachments(Message $message, $ticket_id = 0, $reply_id = 0)
    {
        if($message->hasAttachments()) {
            $attachments = $message->getAttachments();
            foreach($attachments as $attachment) {
                //dd($attachment->getMimeType());
                //dd($attachment->getName());
                $path = storage_path('app/public/upload/tickets/');
                $fp = fopen($path . $attachment->name,"wb");
                file_put_contents(storage_path('app/public/upload/tickets/' . $attachment->name), $attachment->content);
                fclose($fp);
                
                Attachment::insert([
                    'ticket_id' => $ticket_id,
                    'reply_ticket_id' => $reply_id,
                    'filename'  => $attachment->name,
                    'name' => $attachment->name,
                    'path' => '/storage/upload/tickets/',
                    'mime_type' => $attachment->getMimeType()
                ]);
            }

            return true;
        }

        return null;
    }

    public function systemAttachFilesToMail($files, $params = []) 
    {
        $__ticket_path = 'upload/tickets';
        if($files) {
            foreach($files as $key => $file) {
                //$file->getClientOriginalName();
                $path[$key] = Storage::put($__ticket_path, $file);
            
                $location[$key] = Storage::url($path[$key]);

                Attachment::insert([
                    'ticket_id' => !empty($params['ticket_id']) ? $params['ticket_id'] : 0,
                    'reply_ticket_id' => !empty($params['reply_id']) ? $params['reply_id'] : 0,
                    'filename'  => basename($path[$key]),
                    'name'  => $file->getClientOriginalName() ?? NULL,
                    'path'      => '/storage/'.$__ticket_path,
                    'mime_type' => TicketService::get_mime_type($file->getClientOriginalName()),
                ]);
            }
        }

        return 1;
    }
    
    public function getListUser()
    {
        // return User::pluck('name', 'id')->toArray();
        return User::where('email', '!=', 'super@admin.com')->pluck('name', 'id')->toArray();
    }

    public static function parseNewestReplyMessage($message)
    {
        $pattern = '/On (Mon|Tue|Wed|Thu|Fri|Sat|Sun|[[:digit:]]{1,2})(.*?) wrote:/i';
        $test = preg_match($pattern, $message, $matches);
        if(!empty($matches[0])) {
            $arr_newest_message = explode($matches[0], $message);
        }
        
        return is_array($arr_newest_message) ? $arr_newest_message[0] : null;
    }

    public static function removeMediaLinkHtml($content)
    {
        preg_match_all('/<a\s[^>]*href=[^# ]+[^>]*>(.*)<\/a>/i', $content, $matches);
        if(!empty($matches[0][0])) {
            $rContent = str_replace('<p>'.$matches[0][0].'</p>', ' ', $content);
        }

        return $rContent ?? $content;
    }

    public static function isOwnerFile($file)
    {
        $record = Attachment::join('tickets', function($join) {
            $join->on('attachments.ticket_id', '=', 'tickets.id');
        })
        ->where(['attachments.filename' => $file])
        ->where(['tickets.customer_id' => auth()->guard('customer')->user()->id])
        ->get();

        return !empty($record[0]) ? true : false;
    }
}
