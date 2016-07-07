<?php
/**
 * Created by PhpStorm.
 * User: tzookb
 * Date: 7/6/14
 * Time: 10:58 AM
 */

namespace App\Repositories\TBMsg;

use Illuminate\Database\DatabaseManager;
use Tzookb\TBMsg\Exceptions\ConversationNotFoundException;
use Tzookb\TBMsg\Exceptions\NotEnoughUsersInConvException;
use Tzookb\TBMsg\Exceptions\UserNotInConvException;
use Tzookb\TBMsg\Models\Eloquent\ConversationUsers;
use Tzookb\TBMsg\Models\Eloquent\MessageStatus;
use App\Repositories\Tbmsg\Contracts\iCustomTBMsgRepository;
use Tzookb\TBMsg\Models\Eloquent\Message as MessageEloquent;
use Tzookb\TBMsg\Models\Eloquent\Conversation as ConversationEloquent;
use Tzookb\TBMsg\Repositories\EloquentTBMsgRepository as EloquentTBMsgRepository;
use Sentinel;

class CustomEloquentTBMsgRepository extends EloquentTBMsgRepository implements iCustomTBMsgRepository
{
    protected $usersTable;
    protected $usersTableKey;
    protected $tablePrefix;
    /**
     * @var DatabaseManager
     */
    private $db;

    public function __construct($tablePrefix, $usersTable, $usersTableKey, DatabaseManager $db)
    {
        parent::__construct($tablePrefix, $usersTable, $usersTableKey, $db);
    }

    public function removeInactiveUsersFromConversation($conv_id)
    {
        $participants = ConversationUsers::where('conv_id', $conv_id)->get(['user_id']);

        if (!is_null($participants)) {
            foreach ($participants as $key => $participant) {
                if ($participant->user_id != Sentinel::getUser()->id) {
                    $user = Sentinel::findById($participant->user_id);
                    if ($user->inRole('expert')) {
                        // $this->removeConvUserRow($conv_id, $participant);
                    }
                }
            }
            $participants->save();
        } else {
            throw new ConversationNotFoundException;
        }
    }

    protected function removeConvUserRow($conv_id, $user_id)
    {
        $this->db->table($this->tablePrefix.'conv_users')->delete(
            array('conv_id' => $conv_id, 'user_id' => $user_id)
        );
    }
}
