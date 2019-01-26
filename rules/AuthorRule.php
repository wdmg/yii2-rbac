<?php

namespace wdmg\rbac\rules;
use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    public function execute($user_id, $item, $params)
    {
        return isset($params['post']) ? $params['post']->created_by == $user_id : false;
    }
}

?>