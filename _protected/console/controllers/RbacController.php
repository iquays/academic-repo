<?php
namespace app\console\controllers;

use app\rbac\rules\AuthorRule;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Creates base RBAC authorization data for our application.
 * -----------------------------------------------------------------------------
 * Creates 5 roles:
 *
 * - theCreator : you, developer of this site (super admin)
 * - admin      : your direct clients, administrators of this site
 * - employee   : employee of this site / company, this may be someone who should not have admin rights
 * - premium    : premium member of this site (authenticated users with extra powers)
 * - member     : authenticated user, this role is equal to default '@', and it does not have to be set upon sign up
 *
 * Creates 2 permissions:
 *
 * - usePremiumContent  : allows premium users to use premium content
 * - manageUsers        : allows admin+ roles to manage users (CRUD plus role assignment)
 *
 * Creates 1 rule:
 *
 * - AuthorRule : allows employee+ roles to update their own content (not used by default)
 */
class RbacController extends Controller
{
    /**
     * Initializes the RBAC authorization data.
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        //---------- RULES ----------//

        // add the rule (not used by default)
        $rule = new AuthorRule;
        $auth->add($rule);

        //---------- PERMISSIONS ----------//

        // add "usePremiumContent" permission
        $usePremiumContent = $auth->createPermission('usePremiumContent');
        $usePremiumContent->description = 'Allows premium+ roles to use premium content';
        $auth->add($usePremiumContent);

        // add "manageUsers" permission
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Allows admin+ roles to manage users';
        $auth->add($manageUsers);

        //---------- ROLES ----------//

        // add "member" role
        $member = $auth->createRole('member');
        $member->description = 'Authenticated user, equal to "@"';
        $auth->add($member);

        // add "premium" role
        $premium = $auth->createRole('premium');
        $premium->description = 'Premium users. Authenticated users with extra powers';
        $auth->add($premium);
        $auth->addChild($premium, $member);
        $auth->addChild($premium, $usePremiumContent);

        // add "employee" role and give this role: 
        // createArticle, updateOwnArticle and adminArticle permissions, plus premium role.
        $employee = $auth->createRole('employee');
        $employee->description = 'Employee of this site/company who has lower rights than admin';
        $auth->add($employee);
        $auth->addChild($employee, $premium);

        // add "admin" role and give this role: 
        // manageUsers, updateArticle adn deleteArticle permissions, plus employee role.
        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator of this application';
        $auth->add($admin);
        $auth->addChild($admin, $employee);
        $auth->addChild($admin, $manageUsers);

        // add "theCreator" role ( this is you :) )
        // You can do everything that admin can do plus more (if You decide so)
        $theCreator = $auth->createRole('theCreator');
        $theCreator->description = 'You!';
        $auth->add($theCreator);
        $auth->addChild($theCreator, $admin);

        if ($auth) {
            $this->stdout("\nRbac authorization data are installed successfully.\n", Console::FG_GREEN);
        }
    }

    /**
     * Initializes the rule for Training model.
     */
    public function actionTrainingRule()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\rbac\rules\TrainingRule;
        $auth->add($rule);

        // add the "updateOwnTraining" permission and associate the rule with it.
        $updateOwnTraining = $auth->createPermission('updateOwnTraining');
        $updateOwnTraining->description = 'Update own training';
        $updateOwnTraining->ruleName = $rule->name;
        $auth->add($updateOwnTraining);

        // "updateOwnTraining" will be used from "updatePost"
//        $auth->addChild($updateOwnTraining, $updateTraining);

        // allow "member" to update their own posts
        $member = $auth->getRole('member');
        $auth->addChild($member, $updateOwnTraining);
    }

    /**
     * Initializes the rule for Research model.
     */
    public function actionResearchRule()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\rbac\rules\ResearchRule;
        $auth->add($rule);

        // add the "updateOwnResearch" permission and associate the rule with it.
        $updateOwnResearch = $auth->createPermission('updateOwnResearch');
        $updateOwnResearch->description = 'Update own research';
        $updateOwnResearch->ruleName = $rule->name;
        $auth->add($updateOwnResearch);

        // allow "member" to update their own posts
        $member = $auth->getRole('member');
        $auth->addChild($member, $updateOwnResearch);
    }

    /**
     * Initializes the rule for Publication model.
     */
    public function actionPublicationRule()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\rbac\rules\PublicationRule();
        $auth->add($rule);

        // add the "updateOwnPublication" permission and associate the rule with it.
        $updateOwnPublication = $auth->createPermission('updateOwnPublication');
        $updateOwnPublication->description = 'Update own publication';
        $updateOwnPublication->ruleName = $rule->name;
        $auth->add($updateOwnPublication);

        // allow "member" to update their own posts
        $member = $auth->getRole('member');
        $auth->addChild($member, $updateOwnPublication);
    }

    /**
     * Initializes the rule for ScientificEvent model.
     */
    public function actionScientificEventRule()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\rbac\rules\ScientificEventRule();
        $auth->add($rule);

        // add the "updateOwnScientificEvent" permission and associate the rule with it.
        $updateOwnScientificEvent = $auth->createPermission('updateOwnScientificEvent');
        $updateOwnScientificEvent->description = 'Update own Scientific Event';
        $updateOwnScientificEvent->ruleName = $rule->name;
        $auth->add($updateOwnScientificEvent);

        // allow "member" to update their own posts
        $member = $auth->getRole('member');
        $auth->addChild($member, $updateOwnScientificEvent);
    }

    /**
     * Initializes the rule for LecturingHistory model.
     */
    public function actionLecturingHistoryRule()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\rbac\rules\LecturingHistoryRule();
        $auth->add($rule);

        // add the "updateOwnLecturingHistory" permission and associate the rule with it.
        $updateOwnLecturingHistory = $auth->createPermission('updateOwnLecturingHistory');
        $updateOwnLecturingHistory->description = 'Update own Lecturing History';
        $updateOwnLecturingHistory->ruleName = $rule->name;
        $auth->add($updateOwnLecturingHistory);

        // allow "lecturer" to update their own posts
        $lecturer = $auth->getRole('lecturer');
        $auth->addChild($lecturer, $updateOwnLecturingHistory);
    }

    /**
     * Initializes the rule for CommunityService model.
     */
    public function actionCommunityServiceRule()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\rbac\rules\CommunityServiceRule();
        $auth->add($rule);

        // add the "updateOwnCommunityService" permission and associate the rule with it.
        $updateOwnCommunityService = $auth->createPermission('updateOwnCommunityService');
        $updateOwnCommunityService->description = 'Update own Community Service';
        $updateOwnCommunityService->ruleName = $rule->name;
        $auth->add($updateOwnCommunityService);

        // allow "member" to update their own posts
        $member = $auth->getRole('member');
        $auth->addChild($member, $updateOwnCommunityService);
    }

    /**
     * Initializes the rule for WorkHistory model.
     */
    public function actionWorkHistoryRule()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\rbac\rules\WorkHistoryRule();
        $auth->add($rule);

        // add the "updateOwnWorkHistory" permission and associate the rule with it.
        $updateOwnWorkHistory = $auth->createPermission('updateOwnWorkHistory');
        $updateOwnWorkHistory->description = 'Update own Work History';
        $updateOwnWorkHistory->ruleName = $rule->name;
        $auth->add($updateOwnWorkHistory);

        // allow "member" to update their own posts
        $member = $auth->getRole('member');
        $auth->addChild($member, $updateOwnWorkHistory);
    }

    /**
     * Initializes the rule for AwardHistory model.
     */
    public function actionAwardHistoryRule()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\rbac\rules\AwardHistoryRule();
        $auth->add($rule);

        // add the "updateOwnAwardHistory" permission and associate the rule with it.
        $updateOwnAwardHistory = $auth->createPermission('updateOwnAwardHistory');
        $updateOwnAwardHistory->description = 'Update own Award History';
        $updateOwnAwardHistory->ruleName = $rule->name;
        $auth->add($updateOwnAwardHistory);

        // allow "member" to update their own posts
        $member = $auth->getRole('member');
        $auth->addChild($member, $updateOwnAwardHistory);
    }

    /**
     * Initializes the rule for ProfessionalMembership model.
     */
    public function actionProfessionalMembershipRule()
    {
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\rbac\rules\ProfessionalMembershipRule();
        $auth->add($rule);

        // add the "updateOwnProfessionalMembership" permission and associate the rule with it.
        $updateOwnProfessionalMembership = $auth->createPermission('updateOwnProfessionalMembership');
        $updateOwnProfessionalMembership->description = 'Update own Professional Membership';
        $updateOwnProfessionalMembership->ruleName = $rule->name;
        $auth->add($updateOwnProfessionalMembership);

        // allow "member" to update their own posts
        $member = $auth->getRole('member');
        $auth->addChild($member, $updateOwnProfessionalMembership);
    }


}