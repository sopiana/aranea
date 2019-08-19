<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class AssignForeignkey extends Migration
{
    private function assignUserManagementForeignKey()
    {
/**
         * Assign Foreignkey for User Management Table
         **/
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });
        Schema::table('rights', function (Blueprint $table) {
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('role_rights', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('right_id')->references('id')->on('rights');
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('user_mngm_audits', function (Blueprint $table) {
            $table->foreign('author')->references('id')->on('users');
        });
    }

    private function assignProjectManagementForeignKey()
    {
/**
         * Assign Foreignkey for Project Management Table
         **/
        Schema::table('projects', function(Blueprint $table){
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('kind_id')->references('id')->on('project_kinds');
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('project_assignments', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('project_views', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('project_kinds', function (Blueprint $table) {
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('project_favorites',function(Blueprint $table){
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('project_mngm_audits', function (Blueprint $table) {
            $table->foreign('author',false,true)->references('id')->on('users');
        });
    }

    private function assignStatusActionManagementForeignKey()
    {
        /**
         * Assign foreign key for Status Action Management
         */
        Schema::table('status', function (Blueprint $table){
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('action',function(Blueprint $table){
            $table->foreign('status_origin')->references('id')->on('status');
            $table->foreign('status_destination')->references('id')->on('status');
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('action_status_audits', function (Blueprint $table) {
            $table->foreign('author')->references('id')->on('users');
        });
    }

    private function assignRequestManagementForeignKey()
    {
        /**
         * Assign Foreign Key for Request Management
         */
        Schema::table('requests', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('submitter_id')->references('id')->on('users');
            $table->foreign('folder_id')->references('id')->on('folder_requests');
            $table->foreign('status')->references('id')->on('status');
            $table->foreign('assignee')->references('id')->on('users');
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('folder_requests', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('request_audits', function (Blueprint $table) {
            $table->foreign('author')->references('id')->on('users');
        });
    }

    private function assignRequirementManagementForeignKey()
    {
        /**
         * Assign Foreign Key for Request Management
         */
        Schema::table('requirements', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('submitter_id')->references('id')->on('users');
            $table->foreign('folder_id')->references('id')->on('folder_requests');
            $table->foreign('status')->references('id')->on('status');
            $table->foreign('assignee')->references('id')->on('users');
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('folder_requirements', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('last_author')->references('id')->on('users');
        });
        Schema::table('requirement_audits', function (Blueprint $table) {
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
        $this->assignUserManagementForeignKey();
        $this->assignProjectManagementForeignKey();
        $this->assignStatusActionManagementForeignKey();
        $this->assignRequestManagementForeignKey();
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
