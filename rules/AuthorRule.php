<?php

namespace wdmg\rbac\rules;

use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    public function execute($user_id, $item, $params)
    {
        //return isset($params['created_by']) ? ($params['created_by'] == $user_id) : false;
        return isset($params['created_by']) ? ($params['created_by'] == $user_id || (isset($params['updated_by']) ? $params['updated_by'] == $user_id : false)) : false;

    }
}

?>