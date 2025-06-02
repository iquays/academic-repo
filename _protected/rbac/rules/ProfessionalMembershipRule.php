<?php
namespace app\rbac\rules;

use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params.
 * Not used by default since 2.3.0 version.
 */
class ProfessionalMembershipRule extends Rule
{
    public $name = 'isProfessionalMembershipOwner';

    /**
     * @param  string|integer $user The user ID.
     * @param  Item $item The role or permission that this rule is associated with
     * @param  array $params Parameters passed to ManagerInterface::checkAccess().
     * @return boolean                A value indicating whether the rule permits the role or
     *                                permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return isset($params['professionalMembership']) ? $params['professionalMembership']->profile_id == \app\models\User::findOne($user)->profile_id : false;
    }
}