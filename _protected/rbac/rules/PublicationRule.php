<?php
namespace app\rbac\rules;

use app\models\Publicating;
use app\models\User;
use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params.
 * Not used by default since 2.3.0 version.
 */
class PublicationRule extends Rule
{
    public $name = 'isPublicationOwner';

    /**
     * @param  string|integer $user The user ID.
     * @param  Item $item The role or permission that this rule is associated with
     * @param  array $params Parameters passed to ManagerInterface::checkAccess().
     * @return boolean                A value indicating whether the rule permits the role or
     *                                permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return isset($params['publication']) ? Publicating::find()->where(['publication_id' => $params['publication']->id, 'profile_id' => User::findOne($user)->profile_id])->count() > 0 : false;
    }
}