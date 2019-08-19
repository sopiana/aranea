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
        $triggerCmd = 'CREATE TRIGGER `'.$table.'_update_action` AFTER UPDATE ON `'.$table.'`
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
        DB::unprepared('CREATE TRIGGER `users_insert_action` AFTER INSERT ON `users`
            FOR EACH ROW
                INSERT INTO `user_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'users\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, NEW.username);'
            );

        DB::unprepared('CREATE TRIGGER `rights_insert_action` AFTER INSERT ON `rights`
            FOR EACH ROW
                INSERT INTO `user_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'rights\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.key,\' : \',NEW.description));'
            );
        DB::unprepared('CREATE TRIGGER `roles_insert_action` AFTER INSERT ON `roles`
            FOR EACH ROW
                INSERT INTO `user_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'roles\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.description,\' : \',NEW.note));'
            );
        DB::unprepared('CREATE TRIGGER `role_rights_insert_action` AFTER INSERT ON `role_rights`
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
        DB::unprepared('CREATE TRIGGER `projects_insert_action` AFTER INSERT ON `projects`
            FOR EACH ROW
                INSERT INTO `project_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'projects\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.prefix,\'_\',NEW.id))'
            );
        DB::unprepared('CREATE TRIGGER `project_assignments_insert_action` AFTER INSERT ON `project_assignments`
            FOR EACH ROW
                INSERT INTO `project_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'project_assignments\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.project_id,\':\',NEW.user_id,\':\', NEW.role_id))'
            );
        DB::unprepared('CREATE TRIGGER `project_kinds_insert_action` AFTER INSERT ON `project_kinds`
            FOR EACH ROW
                INSERT INTO `project_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'project_kinds\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.name))'
            );
        DB::unprepared('CREATE TRIGGER `project_favorites_insert_action` AFTER INSERT ON `project_favorites`
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
        DB::unprepared('CREATE TRIGGER `action_insert_action` AFTER INSERT ON `action`
            FOR EACH ROW
                INSERT INTO `action_status_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'action\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.name,\':\',NEW.status_origin,\':\',NEW.status_destination))'
            );
        DB::unprepared('CREATE TRIGGER `status_insert_action` AFTER INSERT ON `status`
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
        DB::unprepared('CREATE TRIGGER `requests_insert_action` AFTER INSERT ON `requests`
            FOR EACH ROW
                INSERT INTO `request_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'requests\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.summary))'
            );
        DB::unprepared('CREATE TRIGGER `folder_request_insert_action` AFTER INSERT ON `folder_requests`
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
        DB::unprepared('CREATE TRIGGER `requirements_insert_action` AFTER INSERT ON `requirements`
            FOR EACH ROW
                INSERT INTO `requirement_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                VALUES (NEW.updated_at, \'requirements\', NEW.id, \'CREATE\', NEW.last_author, NULL, NULL, CONCAT(NEW.id,\':\',NEW.summary))'
            );
        DB::unprepared('CREATE TRIGGER `folder_requirement_insert_action` AFTER INSERT ON `folder_requirements`
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
