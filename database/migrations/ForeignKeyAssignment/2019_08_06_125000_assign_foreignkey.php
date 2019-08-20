<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\ConsoleOutput;
class AssignForeignkey extends Migration
{
    private function dropForeignIfExist($tableName, $foreignKeys)
    {
        Schema::table($tableName, function (Blueprint $table) use ($tableName,$foreignKeys)
        {
            foreach($foreignKeys as $foreignKey)
            {
                $data = DB::select('SHOW INDEXES FROM '.$tableName." WHERE Key_name = '".$tableName."_".$foreignKey."_foreign'");
                if (sizeof($data)>0)
                    $table->dropForeign($tableName.'_'.$foreignKey.'_foreign');
            }
        });
    }
    private function assignUserManagementForeignKey()
    {
        /**
         * Assign Foreignkey for User Management Table
         **/
        $this->dropForeignIfExist('users',['role_id']);
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });

        $this->dropForeignIfExist('rights',['last_author']);
        Schema::table('rights', function (Blueprint $table) {
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('roles',['last_author']);
        Schema::table('roles', function (Blueprint $table) {
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('role_rights',['role_id','right_id','last_author']);
        Schema::table('role_rights', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('right_id')->references('id')->on('rights');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('user_mngm_audits',['author']);
        Schema::table('user_mngm_audits', function (Blueprint $table) {
            $table->foreign('author')->references('id')->on('users');
        });
    }

    private function assignProjectManagementForeignKey()
    {
        /**
         * Assign Foreignkey for Project Management Table
         **/
        $this->dropForeignIfExist('projects',['owner_id','kind_id','last_author']);
        Schema::table('projects', function(Blueprint $table){
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('kind_id')->references('id')->on('project_kinds');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('project_assignments',['user_id','project_id','role_id','last_author']);
        Schema::table('project_assignments', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('project_views',['project_id','user_id']);
        Schema::table('project_views', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('user_id')->references('id')->on('users');
        });

        $this->dropForeignIfExist('project_kinds',['last_author']);
        Schema::table('project_kinds', function (Blueprint $table) {
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('project_favorites',['project_id','user_id']);
        Schema::table('project_favorites',function(Blueprint $table){
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('user_id')->references('id')->on('users');
        });

        $this->dropForeignIfExist('project_mngm_audits',['author']);
        Schema::table('project_mngm_audits', function (Blueprint $table) {
            $table->foreign('author',false,true)->references('id')->on('users');
        });
    }

    private function assignStatusActionManagementForeignKey()
    {
        /**
         * Assign foreign key for Status Action Management
         */
        $this->dropForeignIfExist('status',['last_author']);
        Schema::table('status', function (Blueprint $table){
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('action',['status_origin','status_destination','last_author']);
        Schema::table('action',function(Blueprint $table){
            $table->foreign('status_origin')->references('id')->on('status');
            $table->foreign('status_destination')->references('id')->on('status');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('action_status_audits',['author']);
        Schema::table('action_status_audits', function (Blueprint $table) {
            $table->foreign('author')->references('id')->on('users');
        });
    }

    private function assignRequestManagementForeignKey()
    {
        /**
         * Assign Foreign Key for Request Management
         */
        $this->dropForeignIfExist('requests',['project_id','submitter_id','folder_id','status','assignee','last_author']);
        Schema::table('requests', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('submitter_id')->references('id')->on('users');
            $table->foreign('folder_id')->references('id')->on('folder_requests');
            $table->foreign('status')->references('id')->on('status');
            $table->foreign('assignee')->references('id')->on('users');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('folder_requests',['project_id','creator_id','last_author']);
        Schema::table('folder_requests', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('request_audits',['author']);
        Schema::table('request_audits', function (Blueprint $table) {
            $table->foreign('author')->references('id')->on('users');
        });
    }

    private function assignRequirementManagementForeignKey()
    {
        /**
         * Assign Foreign Key for Request Management
         */
        $this->dropForeignIfExist('requirements',['project_id','submitter_id','folder_id','status','assignee','last_author']);
        Schema::table('requirements', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('submitter_id')->references('id')->on('users');
            $table->foreign('folder_id')->references('id')->on('folder_requirements');
            $table->foreign('status')->references('id')->on('status');
            $table->foreign('assignee')->references('id')->on('users');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('folder_requirements',['project_id','creator_id','last_author']);
        Schema::table('folder_requirements', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('requirement_audits',['author']);
        Schema::table('requirement_audits', function (Blueprint $table) {
            $table->foreign('author')->references('id')->on('users');
        });
    }

    private function assignTestCaseManagementForeignKey()
    {
        $this->dropForeignIfExist('test_suites',['project_id','creator_id','last_author']);
        Schema::table('test_suites', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('test_cases',['project_id','submitter_id','test_suite_id','status','assignee','last_author']);
        Schema::table('test_cases', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('submitter_id')->references('id')->on('users');
            $table->foreign('test_suite_id')->references('id')->on('test_suites');
            $table->foreign('status')->references('id')->on('status');
            $table->foreign('assignee')->references('id')->on('users');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('test_case_steps',['last_author']);
        Schema::table('test_case_steps', function (Blueprint $table) {
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('test_case_step_links',['test_case_id','test_step_id','last_author']);
        Schema::table('test_case_step_links', function (Blueprint $table) {
            $table->foreign('test_case_id')->references('id')->on('test_cases');
            $table->foreign('test_step_id')->references('id')->on('test_case_steps');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('test_case_audits',['author']);
        Schema::table('test_case_audits', function (Blueprint $table) {
            $table->foreign('author')->references('id')->on('users');
        });
    }

    private function assignReleaseManagementForeignKey()
    {
        $this->dropForeignIfExist('releases',['project_id','status','submitter_id','owner_id']);
        Schema::table('releases', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('status')->references('id')->on('status');
            $table->foreign('submitter_id')->references('id')->on('users');
            $table->foreign('owner_id')->references('id')->on('users');
        });

        $this->dropForeignIfExist('release_builds',['release_id','last_author']);
        Schema::table('release_builds', function (Blueprint $table) {
            $table->foreign('release_id')->references('id')->on('releases');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('release_audits',['author']);
        Schema::table('release_audits', function (Blueprint $table) {
            $table->foreign('author')->references('id')->on('users');
        });
    }

    private function assignBugManagementForeignKey()
    {
        $this->dropForeignIfExist('bugs',['project_id','status','detected_release_id',
            'resolved_release_id','verified_release_id','submitter_id','assignee','last_author']);
        Schema::table('bugs', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('status')->references('id')->on('status');
            $table->foreign('detected_release_id')->references('id')->on('releases');
            $table->foreign('resolved_release_id')->references('id')->on('releases');
            $table->foreign('verified_release_id')->references('id')->on('releases');
            $table->foreign('submitter_id')->references('id')->on('users');
            $table->foreign('assignee')->references('id')->on('users');
            $table->foreign('last_author')->references('id')->on('users');
        });

        $this->dropForeignIfExist('bug_audits',['author']);
        Schema::table('bug_audits', function (Blueprint $table) {
            $table->foreign('author')->references('id')->on('users');
        });
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        $this->assignUserManagementForeignKey();
        $this->assignProjectManagementForeignKey();
        $this->assignStatusActionManagementForeignKey();
        $this->assignRequestManagementForeignKey();
        $this->assignRequirementManagementForeignKey();
        $this->assignTestCaseManagementForeignKey();
        $this->assignReleaseManagementForeignKey();
        $this->assignBugManagementForeignKey();
        Schema::enableForeignKeyConstraints();
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
