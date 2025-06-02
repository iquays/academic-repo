<?php
namespace app\rbac\rules;

use app\models\CommunityServicing;
use app\models\User;
use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params.
 * Not used by default since 2.3.0 version.
 */
class CommunityServiceRule extends Rule
{
    public $name = 'isCommunityServiceOwner';

    /**
     * @param  string|integer $user The user ID.
     * @param  Item $item The role or permission that this rule is associated with
     * @param  array $params Parameters passed to ManagerInterface::checkAccess().
     * @return boolean                A value indicating whether the rule permits the role or
     *                                permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
//        return true;
        return isset($params['communityService']) ? CommunityServicing::find()->where(['community_service_id' => $params['communityService']->id, 'profile_id' => User::findOne($user)->profile_id])->count() > 0 : false;
    }
}