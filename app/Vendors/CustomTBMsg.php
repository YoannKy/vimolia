<?php
namespace App\Vendors;

use DB;
use Config;
use Tzookb\TBMsg\TBMsg;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Collection;
use Tzookb\TBMsg\Exceptions\ConversationNotFoundException;
use Tzookb\TBMsg\Exceptions\NotEnoughUsersInConvException;
use Tzookb\TBMsg\Exceptions\UserNotInConvException;

use Tzookb\TBMsg\Entities\Conversation;
use Tzookb\TBMsg\Entities\Message;

use Tzookb\TBMsg\Models\Eloquent\Message as MessageEloquent;
use Tzookb\TBMsg\Models\Eloquent\Conversation as ConversationEloquent;
use Tzookb\TBMsg\Models\Eloquent\ConversationUsers;
use Tzookb\TBMsg\Models\Eloquent\MessageStatus;
use Tzookb\TBMsg\Repositories\Contracts\iTBMsgRepository;

class CustomTBMsg extends TBMsg
{

    protected $usersTable;
    protected $usersTableKey;
    protected $tablePrefix;
    /**
     * @var Repositories\Contracts\iTBMsgRepository
     */
    protected $tbmRepo;
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @param iTBMsgRepository $tbmRepo
     * @param Dispatcher $dispatcher
     */
    public function __construct(iTBMsgRepository $tbmRepo, Dispatcher $dispatcher)
    {
        $this->tbmRepo = $tbmRepo;
        $this->dispatcher = $dispatcher;
    }

       /**
     * @param $user_id
     * @return Collection[Conversation]
     */
    public function removeInactiveUsersFromConversation($conv_id)
    {
        $conv = $this->tbmRepo->removeInactiveUsersFromConversation($conv_id);

       


        return $conv;
    }
}
