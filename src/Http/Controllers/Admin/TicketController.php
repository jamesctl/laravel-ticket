<?php

namespace Globit\LaravelTicket\Http\Controllers\Admin;

use Globit\LaravelTicket\Http\Controllers\Controller;
use Webklex\IMAP\Facades\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Globit\LaravelTicket\Services\CustomerService;
use Globit\LaravelTicket\Enums\Ticket as eTicket;
use Globit\LaravelTicket\Models\Ticket;
use Globit\LaravelTicket\Models\Department;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Globit\LaravelTicket\Services\TicketService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public $path = 'upload/tickets/';
    const DEFAULT_ASSIGNED_USER = 1;
    const DEFAULT_FROM_EMAIL = 'admin@ticket.com';
    /**
     * Summary of ticketService
     * @var 
     */
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $data['userId'] = auth()->user()?->id;

        if ($request->ajax()) {
            $items = $this->ticketService->index($data);
            return DataTables::of($items)
                ->addColumn('customer_name', function ($ticket) {
                    return $ticket->customer->name ?? 'N/A';
                })
                ->addColumn('user_name', function ($ticket) {
                    return $ticket->user->name ?? 'N/A';
                })
                ->addColumn('actions', function ($item) {
                    return view('admin.ticket.components.action', compact('item'));
                })
                ->editColumn('status', function ($item) {
                    return view('admin.ticket.components.status', compact('item'));
                })
                ->editColumn('created_at', function ($item) {
                    return view('admin.ticket.components.create', compact('item'));
                })

                ->make(true);
        }

        $param['status'] = $request->input('status') ?? null;
        $param['title'] = $request->input('title') ?? null;

        return view('admin.ticket.index', ['param' => $data]);
    }

    public function show($id)
    {
        $ticketData = $this->ticketService->getByID($id);
        $path = $this->path;
        return view('admin.ticket.detail', compact('ticketData', 'path'));
    }

    public function showEdit($id)
    {
        $ticket = $this->ticketService->getByID($id);
        $users = $this->ticketService->getListUser();

        return response()->json([
            'ticket' => $ticket,
            'users' => $users,
        ]);
    }

    public function sendReply(Request $request)
    {
        $params = $request->all();
        if (!empty($params['message'])) {
            $cleanMessage = trim(strip_tags($params['message'], '<img>')); // Giữ lại thẻ <img> nếu cần
            $params['message'] = $cleanMessage === '' ? null : $cleanMessage; // Gán null nếu chuỗi rỗng
        }
    
        $rules = Validator::make($params, [
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

        if (in_array($request->status, ['Complete', 'Close'])) {
            $ticket = Ticket::find($request->ticketId);
        
            // update status  ticket 
            $ticket->status = $params['status'];
            $ticket->save();

            return response()->json([
                'success' => true,
                'message' => 'Successfully',
            ]);
        }

        $data = [
            'ticket_id' => $request->ticketId,
            'subject' => $request->subject,
            'customer_name' => $request->cusName,
            'message' => $request->message,
            'to_email' => $request->toEmail,
            'status' => $request->status,
            'from_email' => Auth::user()?->email ?? self::DEFAULT_FROM_EMAIL,
        ];

        if ($request->hasFile('files')) {
            $data['files'] = $request->file('files');
        }

        $this->ticketService->sendTicketReply($data);

        return response()->json([
            'success' => true,
            'message' => 'Successfully',
        ]);
    }

    public function create(Request $request)
    {
        $departments = Department::all();
        return view('admin.ticket.create', compact('departments'));
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
                'user_id' => $request->department_id ?? self::DEFAULT_ASSIGNED_USER,
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

    public function getMail()
    {
        /** @var \Webklex\PHPIMAP\Client $client */
        $client = Client::account('default');
        $client->connect();

        //Get all Mailboxes
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folders = $client->getFolders();

        //Get only INBOX Mail
        $foldersInbox = $client->getFolderByName('INBOX');
        /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
        //$messages = $foldersInbox->messages()->all()->get();
        $messages = $foldersInbox->search()->unseen()->get();
        if (!empty($messages)) {
            foreach ($messages as $message) {
                echo $message->getSubject() . '<br />';
                echo 'Attachments: ' . $message->getAttachments()->count() . '<br />';
                echo $message->getHTMLBody() . '<br />';
                echo $message->getTextBody() . '<br />';

                //Move the current Message to 'INBOX.read'
                if ($message->move('INBOX.read') == true) {
                    echo 'Message has ben moved';
                } else {
                    echo 'Message could not be moved';
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = new Ticket();
        $item = $model->find($id);
        if ($item && $item->status !== eTicket::CLOSE) {
            $item->status = eTicket::CLOSE;
            $item->save();
        }

        Session::flash('success', trans('general.testimonialDeletedSuccessfully'));
        return redirect(url('admin/ticket'));
    }

    /**
     * update the ticket
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateModal(Request $request)
    {
        $model = new Ticket();
        $item = $model->find($request->input('ticket_id'));

        if ($item) {
            $item->fill($request->except(['_token', '_method', 'ticket_id']));
            $item->save();
        }

        Session::flash('success', 'Updated successfully');
        return redirect(url('admin/ticket'));
    }
}
