<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;
class TriggerAssignment extends Migration
{

    private function buildOnUpdateTriggerCommand($table, $table_audits)
    {
        $columns = Schema::getColumnListing($table);
        $triggerCmd = 'DROP TRIGGER IF EXISTS `'.$table.'_update_action`;
            CREATE TRIGGER `'.$table.'_update_action` AFTER UPDATE ON `'.$table.'`
            FOR EACH ROW
                BEGIN ';
        foreach($columns as $column)
        {
            if(($column!='last_author')&&($column!='updated_at')&&
                ($column!='remember_token')&&($column!='id'))
            {
                $triggerCmd = $triggerCmd.'IF NOT(NEW.'.$column.' <=> OLD.'.$column.') THEN
                            INSERT INTO `'.$table_audits.'` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                            VALUES (NEW.updated_at, \''.$table.'\', NEW.id, \'UPDATE\', NEW.last_author, \''.$column.'\', OLD.'.$column.', NEW.'.$column.');
                        END IF; ';
            }
        }
        $triggerCmd = $triggerCmd.'END';
        return $triggerCmd;
    }
    /**
     *
     */
    private function UserManagementTablesInsertActions()
    {
        //Assign Trigger for User Management
        DB::unprepared('DROP TRIGGER IF EXISTS `users_insert_action`;
            CREATE TRIGGER `users_insert_action` AFTER INSERT ON `users`
            FOR EACH ROW
                INSERT INTO `user_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'users\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, NEW.username);'
            );

        DB::unprepared('DROP TRIGGER IF EXISTS `rights_insert_action`;
            CREATE TRIGGER `rights_insert_action` AFTER INSERT ON `rights`
            FOR EACH ROW
                INSERT INTO `user_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'rights\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.key,\' : \',NEW.description));'
            );
        DB::unprepared('DROP TRIGGER IF EXISTS `roles_insert_action`;
            CREATE TRIGGER `roles_insert_action` AFTER INSERT ON `roles`
            FOR EACH ROW
                INSERT INTO `user_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'roles\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.description,\' : \',NEW.note));'
            );
        DB::unprepared('DROP TRIGGER IF EXISTS `role_rights_insert_action`;
            CREATE TRIGGER `role_rights_insert_action` AFTER INSERT ON `role_rights`
            FOR EACH ROW
                INSERT INTO `user_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'role_rights\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.role_id,\' : \',NEW.right_id));'
            );
    }

    private function UserManagementTablesUpdateActions()
    {
        DB::unprepared($this->buildOnUpdateTriggerCommand('users','user_mngm_audits'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('rights','user_mngm_audits'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('roles','user_mngm_audits'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('role_rights','user_mngm_audits'));
    }

    private function ProjectManagementTablesInsertActions()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `projects_insert_action`;
            CREATE TRIGGER `projects_insert_action` AFTER INSERT ON `projects`
            FOR EACH ROW
                INSERT INTO `project_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'projects\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.prefix,\'_\',NEW.id))'
            );
        DB::unprepared('DROP TRIGGER IF EXISTS `project_assignments_insert_action`;
            CREATE TRIGGER `project_assignments_insert_action` AFTER INSERT ON `project_assignments`
            FOR EACH ROW
                INSERT INTO `project_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'project_assignments\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.project_id,\':\',NEW.user_id,\':\', NEW.role_id))'
            );
        DB::unprepared('DROP TRIGGER IF EXISTS `project_kinds_insert_action`;
            CREATE TRIGGER `project_kinds_insert_action` AFTER INSERT ON `project_kinds`
            FOR EACH ROW
                INSERT INTO `project_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'project_kinds\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.name))'
            );
        DB::unprepared('DROP TRIGGER IF EXISTS `project_favorites_insert_action`;
            CREATE TRIGGER `project_favorites_insert_action` AFTER INSERT ON `project_favorites`
            FOR EACH ROW
                INSERT INTO `project_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'project_favorites\', NEW.project_id, \'CREATE\', NEW.user_id, NULL, NULL, CONCAT(NEW.project_id,\':\',NEW.user_id))'
            );
    }

    private function ProjectManagementTablesUpdateActions()
    {
        DB::unprepared($this->buildOnUpdateTriggerCommand('projects','project_mngm_audits'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('project_assignments','project_mngm_audits'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('project_kinds','project_mngm_audits'));
    }

    private function StatusActionTablesInsertActions(){
        DB::unprepared('DROP TRIGGER IF EXISTS `action_insert_action`;
            CREATE TRIGGER `action_insert_action` AFTER INSERT ON `action`
            FOR EACH ROW
                INSERT INTO `action_status_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'action\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.name,\':\',NEW.status_origin,\':\',NEW.status_destination))'
            );
        DB::unprepared('DROP TRIGGER IF EXISTS `status_insert_action`;
            CREATE TRIGGER `status_insert_action` AFTER INSERT ON `status`
            FOR EACH ROW
                INSERT INTO `action_status_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'status\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.type,\':\',NEW.name))'
            );
    }

    private function StatusActionTablesUpdateActions()
    {
        DB::unprepared($this->buildOnUpdateTriggerCommand('action','action_status_audits'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('status','action_status_audits'));
    }

    private function RequestTablesInsertActions(){
        DB::unprepared('DROP TRIGGER IF EXISTS `requests_insert_action`;
            CREATE TRIGGER `requests_insert_action` AFTER INSERT ON `requests`
            FOR EACH ROW
                INSERT INTO `request_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'requests\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.summary))'
            );
        DB::unprepared('DROP TRIGGER IF EXISTS `folder_request_insert_action`;
            CREATE TRIGGER `folder_request_insert_action` AFTER INSERT ON `folder_requests`
            FOR EACH ROW
                INSERT INTO `request_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'folder_requests\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.name))'
            );
    }

    private function RequestTablesUpdateActions()
    {
        DB::unprepared($this->buildOnUpdateTriggerCommand('requests','request_audits'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('folder_requests','request_audits'));
    }

    private function RequirementTablesInsertActions(){
        DB::unprepared('DROP TRIGGER IF EXISTS `requirements_insert_action`;
            CREATE TRIGGER `requirements_insert_action` AFTER INSERT ON `requirements`
            FOR EACH ROW
                INSERT INTO `requirement_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'requirements\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.summary))'
            );
        DB::unprepared('DROP TRIGGER IF EXISTS `folder_requirement_insert_action`;
            CREATE TRIGGER `folder_requirement_insert_action` AFTER INSERT ON `folder_requirements`
            FOR EACH ROW
                INSERT INTO `requirement_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'folder_requirements\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.name))'
            );
    }

    private function RequirementTablesUpdateActions()
    {
        DB::unprepared($this->buildOnUpdateTriggerCommand('requirements','requirement_audits'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('folder_requirements','requirement_audits'));
    }

    private function TestCaseTablesInsertActions(){
        DB::unprepared('DROP TRIGGER IF EXISTS `test_suites_insert_action`;
            CREATE TRIGGER `test_suites_insert_action` AFTER INSERT ON `test_suites`
            FOR EACH ROW
                INSERT INTO `test_case_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'test_suites\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.name))'
            );
        DB::unprepared('DROP TRIGGER IF EXISTS `test_cases_insert_action`;
            CREATE TRIGGER `test_cases_insert_action` AFTER INSERT ON `test_cases`
            FOR EACH ROW
                INSERT INTO `test_case_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'test_cases\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.summary))'
            );
        DB::unprepared('DROP TRIGGER IF EXISTS `test_case_steps_insert_action`;
            CREATE TRIGGER `test_case_steps_insert_action` AFTER INSERT ON `test_case_steps`
            FOR EACH ROW
                INSERT INTO `test_case_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'test_case_steps\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id))'
            );
        DB::unprepared('DROP TRIGGER IF EXISTS `test_case_step_links_insert_action`;
            CREATE TRIGGER `test_case_step_links_insert_action` AFTER INSERT ON `test_case_step_links`
            FOR EACH ROW
                INSERT INTO `test_case_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'test_case_step_links\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.test_case_id,\':\',NEW.test_step_id))'
            );
    }

    private function TestCaseTablesUpdateActions()
    {
        DB::unprepared($this->buildOnUpdateTriggerCommand('test_suites','test_case_audits'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('test_cases','test_case_audits'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('test_case_steps','test_case_audits'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('test_case_step_links','test_case_audits'));
    }

    private function ReleaseTablesInsertActions(){
        DB::unprepared('DROP TRIGGER IF EXISTS `releases_insert_action`;
            CREATE TRIGGER `releases_insert_action` AFTER INSERT ON `releases`
            FOR EACH ROW
                INSERT INTO `release_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'releases\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id))'
            );
        DB::unprepared('DROP TRIGGER IF EXISTS `release_builds_insert_action`;
            CREATE TRIGGER `release_builds_insert_action` AFTER INSERT ON `release_builds`
            FOR EACH ROW
                UPDATE `releases` SET
                    `last_build_number` = NEW.build_number,
                    `last_author` = NEW.author WHERE `releases`.`id` = NEW.release_id;'
            );
    }

    private function ReleaseTablesUpdateActions()
    {
        DB::unprepared($this->buildOnUpdateTriggerCommand('releases','release_audits'));
    }

    private function BugTablesInsertActions(){
        DB::unprepared('DROP TRIGGER IF EXISTS `bugs_insert_action`;
            CREATE TRIGGER `bugs_insert_action` AFTER INSERT ON `bugs`
            FOR EACH ROW
                INSERT INTO `bug_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'bugs\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id))'
            );
    }

    private function BugTablesUpdateActions()
    {
        DB::unprepared($this->buildOnUpdateTriggerCommand('bugs','bug_audits'));
    }

    private function TaskTablesInsertActions(){
        DB::unprepared('DROP TRIGGER IF EXISTS `tasks_insert_action`;
            CREATE TRIGGER `tasks_insert_action` AFTER INSERT ON `tasks`
            FOR EACH ROW
                INSERT INTO `tasks_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'tasks\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id))'
            );
    }

    private function TaskTablesUpdateActions()
    {
        DB::unprepared($this->buildOnUpdateTriggerCommand('tasks','tasks_audits'));
    }


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->UserManagementTablesInsertActions();
        $this->UserManagementTablesUpdateActions();

        $this->ProjectManagementTablesInsertActions();
        $this->ProjectManagementTablesUpdateActions();

        $this->StatusActionTablesInsertActions();
        $this->StatusActionTablesUpdateActions();

        $this->RequestTablesInsertActions();
        $this->RequestTablesUpdateActions();

        $this->RequirementTablesInsertActions();
        $this->RequirementTablesUpdateActions();

        $this->TestCaseTablesInsertActions();
        $this->TestCaseTablesUpdateActions();

        $this->ReleaseTablesInsertActions();
        $this->ReleaseTablesUpdateActions();

        $this->BugTablesInsertActions();
        $this->BugTablesUpdateActions();

        $this->TaskTablesInsertActions();
        $this->TaskTablesUpdateActions();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
