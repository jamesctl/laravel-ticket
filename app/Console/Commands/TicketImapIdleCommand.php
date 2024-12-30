<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Webklex\IMAP\Commands\ImapIdleCommand;
use Webklex\PHPIMAP\Folder;
use Webklex\PHPIMAP\Message;
use App\Services\TicketService;
use Illuminate\Support\Facades\Log;
use Webklex\IMAP\Facades\Client as ClientFacade;
use Webklex\PHPIMAP\Exceptions\ConnectionFailedException;
use Webklex\PHPIMAP\Exceptions\FolderFetchingException;
use App\Library\ReactImapFolder;

class TicketImapIdleCommand extends ImapIdleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch_ticket_email';

    /**
     * Holds the account information
     *
     * @var string|array $account
     */
    protected $account = "default";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch new ticket email inbox';

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     print_r('abc');
    // }

    /**
     * Callback used for the idle command and triggered for every new received message
     * @param Message $message
     */
    public function onNewMessage(Message $message){
        $this->info("New message received: ".$message->subject);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        if (is_array($this->account)) {
            $client = ClientFacade::make($this->account);
        }else{
            $client = ClientFacade::account($this->account);
        }

        try {
            $client->connect();
        } catch (ConnectionFailedException $e) {
            Log::error($e->getMessage());
            return 1;
        }

        /** @var Folder $folder */
        try {
            $folder = $client->getFolder($this->folder_name);
        } catch (ConnectionFailedException $e) {
            Log::error($e->getMessage());
            return 1;
        } catch (FolderFetchingException $e) {
            Log::error($e->getMessage());
            return 1;
        }

        try {
            $messages = $folder->search()->unseen()->get();
            foreach($messages as $key => $message) {
                $header_from_attributes = $message->header->getAttributes()['from']->toArray()[0];
                $header_to_attributes = $message->header->getAttributes()['to']->toArray()[0];
                $subject = $message->get("subject")->toString();
                if($subject != "Delayed Mail (still being retried)" && $subject!= 'Undelivered Mail Returned to Sender') {
                    $isReply = TicketService::isReplyMessage($subject);
                    if($isReply) {
                        print_r('Type: reply email');
                        (new TicketService)->createReply($message, [
                            'subject' => $subject,
                            'message' => TicketService::parseNewestReplyMessage($message->getTextBody()) ?? $message->getTextBody(),
                            'from_email' => $header_from_attributes->mail,
                            'to_email'   => $header_to_attributes->mail,
                        ], true);
                    } else {
                        $customer_email = $header_from_attributes->mail;
                        $customer_name  = $header_from_attributes->personal;
                        print_r('Type: new email');
                        (new TicketService)->create($message, [$customer_email], [
                            'customer_name' => $customer_name,
                            'user_id' => 1,
                            'title' => $subject,
                            'description' => $message->getTextBody(),
                        ], true);
                    }

                    // Moved the email to read.
                    $message->setFlag('Seen');
                }
            }

            // $folder->idle(function($message){
            //     $this->onNewMessage($message);
            // });
            // ReactImapFolder::from($folder)->reactPHPIdle(function(Message $message) {
            //     echo "uid: {$message->uid}\n";
            // },  1200, true);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return 1;
        }

        return 0;
    }
}
