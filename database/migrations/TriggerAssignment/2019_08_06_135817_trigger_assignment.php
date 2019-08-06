<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;
class TriggerAssignment extends Migration
{
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

    private function buildOnUpdateTriggerCommand($table)
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
                            INSERT INTO `user_mngm_audits` (`effective_utc`, `source`, `source_id`, `type`, `author`, `column`, `old_value`, `new_value`)
                            VALUES (NEW.updated_at, \''.$table.'\', NEW.id, \'UPDATE\', NEW.last_author, \''.$column.'\', OLD.'.$column.', NEW.'.$column.');
                        END IF; ';
            }
        }
        $triggerCmd = $triggerCmd.'END';
        return $triggerCmd;
    }
    private function UserManagementTablesUpdateActions()
    {
        DB::unprepared($this->buildOnUpdateTriggerCommand('users'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('rights'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('roles'));
        DB::unprepared($this->buildOnUpdateTriggerCommand('role_rights'));
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
