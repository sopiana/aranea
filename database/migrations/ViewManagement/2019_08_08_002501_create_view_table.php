<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewTable extends Migration
{
    private function createViewUsers()
    {
        DB::statement('DROP VIEW IF EXISTS `view_users`');
        DB::statement("CREATE VIEW view_users AS(
            select `users`.`id` AS `user_id`,
                   `users`.`username` AS `username`,
                   `users`.`email` AS `email`,
                   concat(`users`.`first_name`,' ',`users`.`last_name`) AS `fullname`,
                   `users`.`avatar` AS `avatar`,
                   `users`.`company` AS `company`,
                   `users`.`phone` AS `phone`,
                   `users`.`mobile` AS `mobile`,
                   `users`.`is_active` AS `is_active`,
                   `users`.`comment` AS `comment`,
                   `roles`.`id` AS `role_id`,
                   `roles`.`description` AS `role`
            from (`users` join `roles` on(`users`.`role_id` = `roles`.`id`)))");
    }

    private function createViewProjects()
    {
        DB::statement('DROP VIEW IF EXISTS `view_projects`');
        DB::statement("CREATE VIEW view_projects AS(
            SELECT projects.id as id,
                projects.prefix as prefix,
                CONCAT(projects.prefix,'_',projects.id) as project_code,
                projects.name as name,
                projects.summary as summary,
                projects.description as description,
                projects.avatar as avatar,
                projects.owner_id as owner_id,
                users.username as owner,
                users.avatar as owner_avatar,
                projects.kind_id as kind_id,
                project_kinds.name as kind,
                projects.end_date as end_date,
                projects.is_public as is_public,
                projects.is_active as is_active,
                projects.opt_request as opt_request,
                projects.opt_requirement as opt_requirement,
                projects.opt_testcase as opt_testcase,
                projects.opt_testexecution as opt_testexecution,
                projects.opt_bugs as opt_bugs,
                projects.notif_setting as notif_setting,
                projects.api_key as api_key,
                projects.created_at as created_at
            FROM `projects`
            JOIN project_kinds on (projects.kind_id = project_kinds.id)
            JOIN users ON (users.id = projects.owner_id))");
    }
    private function createViewProjectAssignments()
    {
        DB::statement('DROP VIEW IF EXISTS `view_project_assignments`');
        DB::statement("CREATE VIEW view_project_assignments AS(
            SELECT project_assignments.id as assignment_id,
                project_assignments.project_id as project_id,
                projects.prefix as prefix,
                CONCAT(projects.prefix,'_',projects.id) as project_code,
                project_assignments.user_id as user_id,
                users.username as username,
                project_assignments.role_id as role_id,
                roles.description as role
            FROM `project_assignments`
            JOIN projects ON (project_assignments.project_id=projects.id)
            JOIN users ON (project_assignments.user_id = users.id)
            JOIN roles ON  (project_assignments.role_id = roles.id))");
    }

    private function createViewActionStatus(){
        DB::statement('DROP VIEW IF EXISTS `view_action_status`');
        DB::statement("CREATE VIEW view_action_status AS(
            SELECT action.id, action.name,
                action.status_origin as origin_id,
                status_origin.name as origin,
                status_origin.type as origin_type,
                action.status_destination as destination_id,
                status_destination.name as destination,
                status_destination.type as destination_type
            FROM `action` JOIN status as status_origin ON (status_origin.id = action.status_origin)
            JOIN status as status_destination ON (action.status_destination = status_destination.id)
        )");
    }

    private function createViewRequest(){
        DB::statement('DROP VIEW IF EXISTS `view_request`');
        DB::statement("CREATE VIEW view_request AS(
            SELECT  requests.id, projects.id as project_id, projects.prefix as project_prefix,
                requests.submitter_id, submitter.username as submitter_name, submitter.avatar as submitter_avatar,
                requests.folder_id,
                requests.status as status_id, status.name as status_name,
                requests.summary,
                requests.description,
                requests.visibility,
                requests.is_active,
                requests.assignee as assignee_id, assignee.username as assignee_name, assignee.avatar as assignee_avatar,
                requests.priority,
                requests.due_date,
                requests.attachment,
                requests.created_at
            FROM `requests`
            JOIN projects on (projects.id = project_id)
            JOIN users As submitter on (submitter.id = submitter_id)
            JOIN users As assignee on (assignee.id = assignee)
            JOIN status on (status = status.id)
        )");
    }

    private function createViewRequirement(){
        DB::statement('DROP VIEW IF EXISTS `view_requirement`');
        DB::statement("CREATE VIEW view_requirement AS(
            SELECT  requirements.id, projects.id as project_id, projects.prefix as project_prefix,
                requirements.submitter_id, submitter.username as submitter_name, submitter.avatar as submitter_avatar,
                requirements.folder_id,
                requirements.status as status_id, status.name as status_name,
                requirements.summary,
                requirements.description,
                requirements.visibility,
                requirements.is_active,
                requirements.assignee as assignee_id, assignee.username as assignee_name, assignee.avatar as assignee_avatar,
                requirements.priority,
                requirements.due_date,
                requirements.attachment,
                requirements.created_at
            FROM `requirements`
            JOIN projects on (projects.id = project_id)
            JOIN users As submitter on (submitter.id = submitter_id)
            JOIN users As assignee on (assignee.id = assignee)
            JOIN status on (status = status.id)
        )");
    }

    private function createViewTestCase(){
        DB::statement('DROP VIEW IF EXISTS `view_test_case`');
        DB::statement("CREATE VIEW view_test_case AS(
            SELECT test_cases.id, projects.prefix as project_prefix, projects.id as project_id,
                submitter.username as submitter_name, submitter.avatar as submitter_avatar,`submitter_id`,
                `test_suite_id`, `version`,
                test_cases.status as status_id, status.name as status_name,
                test_cases.summary, test_cases.description, `objective`, `preconditions`, `visibility`, test_cases.is_active,
                assignee.username as assignee_name, assignee.avatar as assignee_avatar, test_cases.assignee as assignee_id,
                `priority`, `due_date`, `attachment`,
                test_cases.created_at
            FROM `test_cases`
            JOIN projects ON (test_cases.project_id=projects.id)
            JOIN users as submitter ON (submitter.id=submitter_id)
            JOIN status ON (status.id=test_cases.status)
            JOIN users as assignee ON (assignee.id=test_cases.assignee)
        )");
    }

    private function createViewRelease(){
        DB::statement('DROP VIEW IF EXISTS `view_release`');
        DB::statement("CREATE VIEW view_release AS(
            SELECT releases.id, releases.name, releases.type,
                releases.project_id, projects.prefix as project_prefix,
                releases.status as status_id, status.name as status_name,
                releases.submitter_id, submitter.username as submitter_name, submitter.avatar as submitter_avatar,
                releases.owner_id, owner.username as owner_name, owner.avatar as owner_avatar,
                `version`, `started_at`, `ended_at`, releases.created_at
            FROM `releases`
                JOIN projects ON (projects.id=releases.project_id)
                JOIN status ON (status.id=releases.status)
                JOIN users as submitter ON (submitter.id=releases.submitter_id)
                JOIN users as owner ON (owner.id=releases.owner_id)
        )");
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createViewUsers();
        $this->createViewProjects();
        $this->createViewProjectAssignments();
        $this->createViewActionStatus();
        $this->createViewRequest();
        $this->createViewRequirement();
        $this->createViewTestCase();
        $this->createViewRelease();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //do nothing
    }
}
