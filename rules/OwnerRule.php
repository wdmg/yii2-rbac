<?php

namespace wdmg\rbac\rules;
use yii\rbac\Rule;

class OwnerRule extends Rule
{
    public $name = 'isOwner';

    public function execute($user_id, $item, $params)
    {
        return isset($params['post']) ? $params['post']->owner_id == $user_id : false;
    }
}

?>