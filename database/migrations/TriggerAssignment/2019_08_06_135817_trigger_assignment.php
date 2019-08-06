<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->UserManagementTablesInsertActions();
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
