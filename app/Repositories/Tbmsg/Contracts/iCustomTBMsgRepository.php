<?php
/**
 * Created by PhpStorm.
 * User: tzookb
 * Date: 7/6/14
 * Time: 10:57 AM
 */

namespace App\Repositories\Tbmsg\Contracts;

use  Tzookb\TBMsg\Repositories\Contracts\iTBMsgRepository;


interface iCustomTBMsgRepository extends iTBMsgRepository {

   
    public function removeInactiveUsersFromConversation($conv_id);
}