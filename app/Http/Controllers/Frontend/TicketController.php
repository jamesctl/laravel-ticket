<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\CustomerService;
use App\Services\TicketService;
use App\Enums\Ticket as eTicket;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Attachment;
use App\Models\Department;
use Webklex\PHPIMAP\Message as ImapMessage;
use Webklex\PHPIMAP\Support\MessageCollection;
use Webklex\IMAP\Facades\Client;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ReplyTicket;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class TicketController extends Controller
{
    public function accessFile($filename) {
        if(!auth()->guard('customer')->check()) {
            abort(404);
        }

        if(TicketService::isOwnerFile($filename)) {
            return response()->download(Storage::path('upload/tickets/'.$filename));
        } else {
            abort(404);
        }
    }

    public function list(Request $request)
    {   
        if(!auth()->guard('customer')->check()) {
            return redirect()->route('login');
        }
        $data = $request->all();
        $data['customer_id'] = auth()->guard('customer')->user()->id ?? 1;

        if ($request->ajax()) {
            $items = (new TicketService)->index($data);
            return DataTables::of($items)
                ->addColumn('customer_name', function ($ticket) {
                    return $ticket->customer->name ?? 'N/A';
                })
                ->addColumn('user_name', function ($ticket) {
                    return $ticket->user->name ?? 'N/A';
                })
                // ->addColumn('actions', function ($item) {
                //     return view('frontend_v2.pages.ticket.components.action', compact('item'));
                // })
                ->editColumn('status', function ($item) {
                    return view('frontend_v2.pages.ticket.components.status', compact('item'));
                })
                ->editColumn('created_at', function ($item) {
                    return view('frontend_v2.pages.ticket.components.create', compact('item'));
                })

                ->make(true);
        }

        $param['status'] = $request->input('status') ?? null;
        $param['title'] = $request->input('title') ?? null;

        return view('frontend_v2.pages.ticket.list', ['param' => $data]);
    }

    public function create()
    {
        $departments = Department::all();
        return view('frontend_v2.pages.ticket', compact('departments'));
    }

    public function store(Request $request)
    {
        try {
            // starting instance Imap connection
            $client = Client::account('default');
            $client->connect();
            $folder = $client->getFolder('INBOX');
            $messages = $folder->search()->unseen()->get();

            $emails = array($request->email);
            
            $params = [
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => $request->department_id,
                'files' => !empty($request->file('files')) ? $request->file('files') : [],
            ];

            (new TicketService)->create($messages[0], $emails, $params, false, true);
            Session::flash('success', 'Ticket created successful');
            return redirect(route('create_ticket'));

        } catch(Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back();
        }   
    }

    public function detail($id)
    {
        if(!auth()->guard('customer')->check()) {
            return redirect()->route('login');
        }

        $ticketData = (new TicketService)->getByID($id);
        return view('frontend_v2.pages.ticket.detail', compact('ticketData'));
    }

    public function reply(Request $request)
    {
        try {
            $rules = Validator::make($request->all(), [
                'subject' => 'required|string',
                'message' => 'nullable|string|max:500'
            ]);
    
            $rules->sometimes('message', 'required', function ($input) {
                return !in_array($input->status, ['Complete', 'Close']);
            });
    
            if ($rules->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $rules->errors(),
                ], 422);
            }
            
            $to_email = 'test-ticket@centrala.vn';
            $data = [
                'ticket_id' => $request->ticketId,
                'subject' => $request->subject,
                'customer_name' => $request->cusName,
                'message' => $request->message,
                'to_email' => isset($to_email) ? $to_email : Auth::user()->email,
                'status' => $request->status,
                'from_email' => $request->toEmail,
            ];
    
            if ($request->hasFile('files')) {
                $data['files'] = $request->file('files');
            }

            $item = (new TicketService)->sendTicketReply($data);

            return response()->json([
                'success' => true,
                'message' => 'Successfully',
            ]);
        } catch(Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}