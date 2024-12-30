<?php

namespace App\Library;

use Webklex\PHPIMAP\Folder;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\IMAP;
use Webklex\PHPIMAP\Message;
use React\EventLoop\Loop;
use React\EventLoop\TimerInterface;

class ReactImapFolder extends Folder
{
    protected function __construct(Folder $folder)
    {
        parent::__construct(
            $folder->getClient(),
            $folder->name,
            $folder->delimiter,
            self::createAttributesArray($folder)
        );
    }

    public static function from(Folder $folder): self
    {
        return new self($folder);
    }

    public function reactPHPIdle(callable $callback, $timeout = 1200, $auto_reconnect = false): TimerInterface
    {
        $this->client->getConnection()->setConnectionTimeout($timeout);

        $this->client->reconnect();
        $this->client->openFolder($this->path, true);
        $connection = $this->client->getConnection();

        $sequence = ClientManager::get('options.sequence', IMAP::ST_MSGN);
        $connection->idle();

        $timer = Loop::get()->addPeriodicTimer(0, function () use ($callback, &$connection, $sequence, $auto_reconnect) {
            try {
                $line = $connection->nextLine();
                
                if (($pos = strpos($line, "EXISTS")) !== false) {
                    $msgn = (int) substr($line, 2, $pos -2);
                    $connection->done();

                    $this->client->openFolder($this->path, true);
                    $message = $this->query()->getMessageByMsgn($msgn);
                    $message->setSequence($sequence);
                    $callback($message);

                    $event = $this->getEvent("message", "new");
                    $event::dispatch($message);

                    $connection->idle();
                }
            } catch (RuntimeException $e) {
                if (strpos($e->getMessage(), "connection closed") === false) {
                    throw $e;
                }
                if ($auto_reconnect === true) {
                    $this->client->reconnect();
                    $this->client->openFolder($this->path, true);

                    $connection = $this->client->getConnection();
                    $connection->idle();
                }
            }
        });

        return $timer;
    }

    protected static function createAttributesArray(Folder $folder): array
    {
        $attributes = [];

        if ($folder->no_inferiors) {
            $attributes[] = '\NoInferiors';
        }

        if ($folder->no_select) {
            $attributes[] = '\NoSelect';
        }

        if ($folder->marked) {
            $attributes[] = '\Marked';
        }

        if ($folder->referral) {
            $attributes[] = '\Referral';
        }

        if ($folder->has_children) {
            $attributes[] = '\HasChildren';
        }

        return $attributes;
    }
}