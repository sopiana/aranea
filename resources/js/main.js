require('./bootstrap');
require('@coreui/coreui/dist/js/coreui');
require('jquery-sortable');
require('datatables.net/js/jquery.dataTables');
require('datatables.net-bs4/js/dataTables.bootstrap4');
require('datatables.net-colreorder-dt');
require('datatables.net-buttons/js/dataTables.buttons');
require('datatables.net-buttons/js/buttons.colVis');
require('quill');

const COL_USERNAME_WIDTH = 120;
const COL_CREATION_DATE_WIDTH = 90;
const COL_DATE_WIDTH = 70;
const COL_PRIORITY_WIDTH = 60;
const COL_STATUS_WIDTH = 65;
const COL_CODE_WIDTH = 58;

function getWindowParam(paramName){
    let url = window.location.href;
    paramName = paramName.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]"+paramName+"(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if(!results) return null;
    if(!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g," "));
}

function drawWindow()
{
    let pageMenu=window.location.href.substr(window.location.origin.length+1);
    pageMenu = pageMenu.substr(0,pageMenu.indexOf('/'));

    switch(pageMenu){
        case "dashboard":
            dashboardPage.drawPage();
            break;
        case "project":
            projectPage.drawPage();
            break;
    }
}

$(document).ready(function()
{
    window.addEventListener('popstate',function(e){
        drawWindow();
    });
    $('.right-nav').off('click').on('click',function(event){
        $('.dropdown-menu').removeClass("show");

        var btnObj = event.target;
        if(btnObj.nodeName=='I')
            btnObj = $(btnObj).parent()[0];
        let pageURL = $(btnObj).attr('href');
        if(pageURL!=window.location)
        {
            window.history.pushState({path:pageURL},' ',pageURL);
            drawWindow();
        }
        return false;
    });
    drawWindow();
});

var dashboardPage = {
    page:"dashboard",
    drawPage:function()
    {
        var subPageStr = getWindowParam('page');
        var subPage = $('#pageContainer').children();
        if(subPage.length>0)
        {
            subPage = subPage[0];
            $(subPage).appendTo('#hidden-div');
        }
        switch(subPageStr){
            case 'profile':
                this.subMenuProfile.draw();
                break;
            case 'projects':
                this.subMenuProjects.draw();
                break;
            case 'tasks':
                this.subMenuTasks.draw();
                break;
            case 'issues-all':
                this.subMenuAllItems.draw();
                break;
            case 'issues-request':
                this.subMenuRequests.draw();
                break;
            case 'issues-req':
                this.subMenuRequirements.draw();
                break;
            case 'issues-tc':
                this.subMenuTestCase.draw();
                break;
            case 'release':
                this.subMenuRelease.draw();
                break;
            case 'issues-bugs':
                this.subMenuBug.draw();
                break;
        }
    },
    subMenuProfile:{
        draw: function()
        {
            $('#profile-detail').appendTo('#pageContainer');
        }
    },
    subMenuProjects:{
        datatable :null,
        draw: function()
        {
            $('#projectList-detail').appendTo('#pageContainer');
            if(this.datatable==null)
            {
                var dataTableConfig = Utils.buildDataTableTemplate(window.location.origin+'/api/secure/projectList');
                dataTableConfig.columns = [
                    { data: "project_code", width:COL_CODE_WIDTH+'px',
                      render:function( data, type, row ){
                        return '<a href="'+window.location.origin+'/project/'+row.project_code+'">'+row.project_code+'</a>';
                      }
                    },
                    { data: "name",
                        render: function ( data, type, row ) {
                            return '<a href="'+window.location.origin+'/project/'+row.project_code+'">'+
                                '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.avatar +'" width="30px">'+ row.name+
                                '</a>';}
                    },
                    { data: "owner", width:COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.owner_avatar +'" width="30px">'+ row.owner;}},
                    { data: "kind" },
                    { data: "created_at",
                        render:function(data, type, row) {
                            return Utils.getDateStr(row.created_at);
                        }
                    },
                    { data: "is_active" }
                ];

                this.datatable = $('#project-list-table').DataTable(dataTableConfig);
            }
            else
                this.datatable.ajax.reload();
        }
    },
    subMenuTasks:
    {
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#taskList-detail', dashboardPage.page);
            if(this.datatable == null)
            {
                var dataTableConfig = Utils.buildDataTableTemplate(window.location.origin+'/api/secure/taskList');
                dataTableConfig.columns = [
                    { data: "id", width:COL_CODE_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return 'TSK_'+row.id;
                        }
                    },
                    { data: "summary" },
                    { data: "status_name", width: COL_STATUS_WIDTH+'px'},
                    { data: "submitter_name", width:COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.submitter_avatar +'" width="30px">'+ row.submitter_name;}},
                    { data: "created_at", width: COL_CREATION_DATE_WIDTH+'px',
                        render:function(data, type, row) {
                            return Utils.getDateStr(row.created_at);
                        }
                    },
                    { data: "priority", width: COL_PRIORITY_WIDTH+'px',
                        render: function ( data, type, row ) {
                            switch(row.priority)
                            {
                                case 'PRIORITY_LOW':
                                    return '<div class="badge badge-info"><i class="fa fa-chevron-down"></i> Low</div>';
                                case 'PRIORITY_MEDIUM':
                                    return '<div class="badge badge-warning"><i class="fa fa-chevron-up"></i> Medium</div>';
                                case 'PRIORITY_HIGH':
                                    return '<div class="badge badge-danger"><i class="fa fa-chevron-up"></i> High</div>';
                                case 'PRIORITY_URGENT':
                                    return '<div class="badge badge-critical"><i class="fa fa-exclamation"></i> Urgent</div>';
                                default:
                                    return row.priority;
                            }
                        }
                    },
                    { data: "assignee_name", width: COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.assignee_avatar +'" width="30px">'+ row.assignee_name;}}
                ];

                this.datatable = $('#task-list-table').DataTable(dataTableConfig);
            }
            else
                this.datatable.ajax.reload();
        }
    },
    subMenuAllItems:{
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#allItemList-detail', dashboardPage.page);
            if(this.datatable==null)
            {
                var dataTableConfig = Utils.buildDataTableTemplate(window.location.origin+'/api/secure/allItemList');
                dataTableConfig.columns = [
                    {
                        data:"item_type",
                        render: function ( data, type, row ) {
                            switch(row.item_type)
                            {
                                case 'REQUEST': return '<i class="nav-icon icon-tag pr-2 icon-gradient bg-plum-plate"></i>Request';
                                case 'REQUIREMENT': return '<i class="nav-icon icon-layers pr-2 icon-gradient bg-plum-plate"></i>Requirement';
                                case 'TEST_CASE': return '<i class="nav-icon icon-target pr-2 icon-gradient bg-plum-plate"></i>Test Case';
                                case 'BUG': return '<i class="nav-icon icon-ghost pr-2 icon-gradient bg-plum-plate"></i>Bug';
                                case 'RELEASE': return '<i class="nav-icon icon-rocket pr-2 icon-gradient bg-plum-plate"></i>Release';
                                default: return '<i class="nav-icon icon-social-steam pr-2 icon-gradient bg-plum-plate"></i>Test Run';
                            }
                        }
                    },
                    {
                        data: "id", width:COL_CODE_WIDTH+'px',
                        render: function ( data, type, row ) {
                            switch(row.item_type)
                            {
                                case 'REQUEST': return 'RQS_'+row.id;
                                case 'REQUIREMENT': return 'REQ_'+row.id;
                                case 'TEST_CASE': return 'TC_'+row.id;
                                case 'BUG': return 'BUG_'+row.id;
                                case 'RELEASE': return 'REL_'+row.id;
                                default:
                                        return 'TR_'+row.id;
                            }
                        }
                    },
                    { data: "summary" },
                    { data: "status_name", width:COL_STATUS_WIDTH+'px'},
                    { data: "submitter_name", width:COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.submitter_avatar +'" width="30px">'+ row.submitter_name;}},
                    { data: "created_at", width: COL_CREATION_DATE_WIDTH+'px',
                        render:function(data, type, row) {
                            return Utils.getDateStr(row.created_at);
                        }
                    },
                    { data: "priority", width: COL_PRIORITY_WIDTH+'px',
                        render: function ( data, type, row ) {
                            switch(row.priority)
                            {
                                case 'PRIORITY_LOW':
                                    return '<div class="badge badge-info"><i class="fa fa-chevron-down"></i> Low</div>';
                                case 'PRIORITY_MEDIUM':
                                    return '<div class="badge badge-warning"><i class="fa fa-chevron-up"></i> Medium</div>';
                                case 'PRIORITY_HIGH':
                                    return '<div class="badge badge-danger"><i class="fa fa-chevron-up"></i> High</div>';
                                case 'PRIORITY_URGENT':
                                    return '<div class="badge badge-critical"><i class="fa fa-exclamation"></i> Urgent</div>';
                                default:
                                    return row.priority;
                            }
                        }
                    },
                    { data: "assignee_name", width: COL_USERNAME_WIDTH,
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.assignee_avatar +'" width="30px">'+ row.assignee_name;}}
                ];

                this.datatable = $('#allItem-list-table').DataTable(dataTableConfig);
            }
            else
                this.datatable.ajax.reload();
        }
    },
    subMenuRequests:{
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#requestList-detail', dashboardPage.page);
            if(this.datatable==null)
            {
                var dataTableConfig = Utils.buildDataTableTemplate(window.location.origin+'/api/secure/requestList');
                dataTableConfig.columns = [
                    { data: "id", width:COL_CODE_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return 'RQS_'+row.id;
                        }
                    },
                    { data: "summary" },
                    { data: "status_name", width:COL_STATUS_WIDTH+'px'},
                    { data: "submitter_name", width:COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.submitter_avatar +'" width="30px">'+ row.submitter_name;}},
                    { data: "created_at", width: COL_CREATION_DATE_WIDTH+'px',
                        render:function(data, type, row) {
                            return Utils.getDateStr(row.created_at);
                        }
                    },
                    { data: "priority", width: COL_PRIORITY_WIDTH+'px',
                        render: function ( data, type, row ) {
                            switch(row.priority)
                            {
                                case 'PRIORITY_LOW':
                                    return '<div class="badge badge-info"><i class="fa fa-chevron-down"></i> Low</div>';
                                case 'PRIORITY_MEDIUM':
                                    return '<div class="badge badge-warning"><i class="fa fa-chevron-up"></i> Medium</div>';
                                case 'PRIORITY_HIGH':
                                    return '<div class="badge badge-danger"><i class="fa fa-chevron-up"></i> High</div>';
                                case 'PRIORITY_URGENT':
                                    return '<div class="badge badge-critical"><i class="fa fa-exclamation"></i> Urgent</div>';
                                default:
                                    return row.priority;
                            }
                        }
                    },
                    { data: "assignee_name", width: COL_USERNAME_WIDTH,
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.assignee_avatar +'" width="30px">'+ row.assignee_name;}}
                ];

                this.datatable = $('#request-list-table').DataTable(dataTableConfig);
            }
            else
                this.datatable.ajax.reload();
        }
    },
    subMenuRequirements:
    {
        datatable:null,
        draw:function(){

            Utils.renderFilterDropdown('#requirementList-detail', dashboardPage.page);
            if(this.datatable == null)
            {
                var dataTableConfig = Utils.buildDataTableTemplate(window.location.origin+'/api/secure/requirementList');
                dataTableConfig.columns = [
                    { data: "id", width:COL_CODE_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return 'REQ_'+row.id;
                        }
                    },
                    { data: "summary" },
                    { data: "status_name", width: COL_STATUS_WIDTH+'px'},
                    { data: "submitter_name", width:COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.submitter_avatar +'" width="30px">'+ row.submitter_name;}},
                    { data: "created_at", width: COL_CREATION_DATE_WIDTH+'px',
                        render:function(data, type, row) {
                            return Utils.getDateStr(row.created_at);
                        }
                    },
                    { data: "priority", width: COL_PRIORITY_WIDTH+'px',
                        render: function ( data, type, row ) {
                            switch(row.priority)
                            {
                                case 'PRIORITY_LOW':
                                    return '<div class="badge badge-info"><i class="fa fa-chevron-down"></i> Low</div>';
                                case 'PRIORITY_MEDIUM':
                                    return '<div class="badge badge-warning"><i class="fa fa-chevron-up"></i> Medium</div>';
                                case 'PRIORITY_HIGH':
                                    return '<div class="badge badge-danger"><i class="fa fa-chevron-up"></i> High</div>';
                                case 'PRIORITY_URGENT':
                                    return '<div class="badge badge-critical"><i class="fa fa-exclamation"></i> Urgent</div>';
                                default:
                                    return row.priority;
                            }
                        }
                    },
                    { data: "assignee_name", width: COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.assignee_avatar +'" width="30px">'+ row.assignee_name;}}
                ];
                this.datatable = $('#requirement-list-table').DataTable(dataTableConfig);
            }
            else
                this.datatable.ajax.reload();
        }
    },
    subMenuTestCase:
    {
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#testCaseList-detail', dashboardPage.page);
            if(this.datatable == null)
            {
                var dataTableConfig = Utils.buildDataTableTemplate(window.location.origin+'/api/secure/testCaseList');
                dataTableConfig.columns = [
                    { data: "id", width:COL_CODE_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return 'TC_'+row.id;
                        }
                    },
                    { data: "summary" },
                    { data: "status_name", width: COL_STATUS_WIDTH+'px'},
                    { data: "submitter_name", width:COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.submitter_avatar +'" width="30px">'+ row.submitter_name;}},
                    { data: "created_at", width: COL_CREATION_DATE_WIDTH+'px',
                        render:function(data, type, row) {
                            return Utils.getDateStr(row.created_at);
                        }
                    },
                    { data: "priority", width: COL_PRIORITY_WIDTH+'px',
                        render: function ( data, type, row ) {
                            switch(row.priority)
                            {
                                case 'PRIORITY_LOW':
                                    return '<div class="badge badge-info"><i class="fa fa-chevron-down"></i> Low</div>';
                                case 'PRIORITY_MEDIUM':
                                    return '<div class="badge badge-warning"><i class="fa fa-chevron-up"></i> Medium</div>';
                                case 'PRIORITY_HIGH':
                                    return '<div class="badge badge-danger"><i class="fa fa-chevron-up"></i> High</div>';
                                case 'PRIORITY_URGENT':
                                    return '<div class="badge badge-critical"><i class="fa fa-exclamation"></i> Urgent</div>';
                                default:
                                    return row.priority;
                            }
                        }
                    },
                    { data: "assignee_name", width: COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.assignee_avatar +'" width="30px">'+ row.assignee_name;}}
                ];
                this.datatable = $('#testCase-list-table').DataTable(dataTableConfig);
            }
            else
                this.datatable.ajax.reload();
        }
    },

    subMenuRelease:
    {
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#releaseList-detail', dashboardPage.page);
            if(this.datatable == null)
            {
                var dataTableConfig = Utils.buildDataTableTemplate(window.location.origin+'/api/secure/releaseList');
                dataTableConfig.columns = [
                    { data: "id", width:COL_CODE_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return 'REL_'+row.id;
                        }
                    },
                    { data: "name" },
                    { data: "version", width: COL_STATUS_WIDTH+'px'},
                    { data: "status_name", width: COL_STATUS_WIDTH+'px'},
                    { data: "type", width: COL_PRIORITY_WIDTH+'px',
                        render: function ( data, type, row ) {
                            switch(row.type)
                            {
                                case 'REL_TYPE_MAJOR':
                                    return 'Major';
                                case 'REL_TYPE_MINOR':
                                    return 'Minor';
                                case 'REL_TYPE_SPRINT':
                                    return 'Sprint';
                                default:
                                    return row.type;
                            }
                        }
                    },
                    { data: "started_at", width: COL_DATE_WIDTH+'px',
                        render:function(data, type, row) {
                            return Utils.getDateStr(row.started_at, false);
                        }
                    },
                    { data: "ended_at", width: COL_DATE_WIDTH+'px',
                        render:function(data, type, row) {
                            return Utils.getDateStr(row.ended_at, false);
                        }
                    },
                    { data: "submitter_name", width:COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.submitter_avatar +'" width="30px">'+ row.submitter_name;}},
                    { data: "owner_name", width: COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.owner_avatar +'" width="30px">'+ row.owner_name;}}
                ];

                this.datatable = $('#release-list-table').DataTable(dataTableConfig);
            }
            else
                this.datatable.ajax.reload();
        }
    },
    subMenuBug:
    {
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#bugList-detail', dashboardPage.page);
            if(this.datatable == null)
            {
                var dataTableConfig = Utils.buildDataTableTemplate(window.location.origin+'/api/secure/bugList');
                dataTableConfig.columns = [
                    { data: "id", width:COL_CODE_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return 'BUG_'+row.id;
                        }
                    },
                    { data: "summary" },
                    { data: "status_name", width: COL_STATUS_WIDTH+'px'},
                    { data: "type", width: COL_PRIORITY_WIDTH+'px',
                        render: function ( data, type, row ) {
                            switch(row.type)
                            {
                                case 'TYPE_BUG':
                                    return 'Bug';
                                case 'TYPE_ISSUE':
                                    return 'Issue';
                                case 'TYPE_LIMITATION':
                                    return 'Limitation';
                                default:
                                    return row.type;
                            }
                        }
                    },
                    { data: "submitter_name", width:COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.submitter_avatar +'" width="30px">'+ row.submitter_name;}},
                    { data:"created_at", width:COL_CREATION_DATE_WIDTH+'px',
                        render:function(data, type, row) {
                            return Utils.getDateStr(row.created_at);
                        }
                    },
                    { data: "priority", width: COL_PRIORITY_WIDTH+'px',
                        render: function ( data, type, row ) {
                            switch(row.priority)
                            {
                                case 'PRIORITY_LOW':
                                    return '<div class="badge badge-info"><i class="fa fa-chevron-down"></i> Low</div>';
                                case 'PRIORITY_MEDIUM':
                                    return '<div class="badge badge-warning"><i class="fa fa-chevron-up"></i> Medium</div>';
                                case 'PRIORITY_HIGH':
                                    return '<div class="badge badge-danger"><i class="fa fa-chevron-up"></i> High</div>';
                                case 'PRIORITY_URGENT':
                                    return '<div class="badge badge-critical"><i class="fa fa-exclamation"></i> Urgent</div>';
                                default:
                                    return row.priority;
                            }
                        }
                    },
                    { data: "severity", width: COL_PRIORITY_WIDTH+'px',
                        render: function ( data, type, row ) {
                            switch(row.severity)
                            {
                                case 'SEVERITY_LOW':
                                    return '<div class="badge badge-info"><i class="fa fa-chevron-down"></i> Low</div>';
                                case 'SEVERITY_MEDIUM':
                                    return '<div class="badge badge-warning"><i class="fa fa-chevron-up"></i> Medium</div>';
                                case 'SEVERITY_HIGH':
                                    return '<div class="badge badge-danger"><i class="fa fa-chevron-up"></i> High</div>';
                                case 'SEVERITY_CRITICAL':
                                    return '<div class="badge badge-critical"><i class="fa fa-exclamation"></i> Critical</div>';
                                default:
                                    return row.severity;
                            }
                        }
                    },
                    { data: "assignee_name", width: COL_USERNAME_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.assignee_avatar +'" width="30px">'+ row.assignee_name;}}
                ];

                this.datatable = $('#bug-list-table').DataTable(dataTableConfig);
            }
            else
                this.datatable.ajax.reload();
        }
    }
}

var projectPage =
{
    page:"project",
    projectCode: "",
    drawPage:function()
    {
        let pageMenu = window.location.href.substr(window.location.origin.length+1);
        this.projectCode = pageMenu.substr(pageMenu.indexOf('/')+1, pageMenu.lastIndexOf('/')-(pageMenu.indexOf('/')+1));
        var subPageStr = getWindowParam('page');
        var subPage = $('#pageContainer').children();
        if(subPage.length>0)
        {
            subPage = subPage[0];
            $(subPage).appendTo('#hidden-div');
        }
        switch(subPageStr){
            case 'profile':
                this.subMenuProfile.draw();
                break;
            case 'projects':
                this.subMenuProjects.draw();
                break;
            case 'tasks':
                this.subMenuTasks.draw();
                break;
            case 'issues-all':
                this.subMenuAllItems.draw();
                break;
            case 'issues-request':
                this.subMenuRequests.draw();
                break;
            case 'issues-req':
                this.subMenuRequirements.draw();
                break;
            case 'issues-tc':
                this.subMenuTestCase.draw();
                break;
            case 'release':
                this.subMenuRelease.draw();
                break;
            case 'issues-bugs':
                this.subMenuBug.draw();
                break;
        }
    },
    subMenuRequests:{
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#requestList-detail', projectPage.page+'/'+projectPage.projectCode);
        }
    }
}

var Utils =
{
    monthName:['','Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
    getDateStr:function(date, isDatetime=true)
    {
        if(isDatetime)
            date = date.substr(0, date.indexOf(' '));
        dateComponents =date.split('-');

        return dateComponents[2]+' '+this.monthName[parseInt(dateComponents[1])]+' '+dateComponents[0];
    },
    renderFilterDropdown:function(container, page)
    {
        let subpage = getWindowParam('page');
        let filter = getWindowParam('filter');
        let view = getWindowParam('view');
        $(container).appendTo('#pageContainer');
        var pageNavbar = $(container+' .card-body .page-title-heading').children('.page-navbar');
        for(var i=0;i<pageNavbar.length;++i)
        {
            var $viewFilterOptions = $(pageNavbar[i]).children('.dropdown-menu').children();
            var found = false;
            var defaultElement = null;

            $viewFilterOptions.each(function()
            {
                let href = window.location.origin+'/'+page+'/?page='+subpage;
                if(this.attributes['default'])
                    defaultElement = this;
                if(this.attributes['filter'])
                {
                    href+='&filter='+this.attributes['filter'].nodeValue;
                    if(filter===this.attributes['filter'].nodeValue)
                    {
                        this.className='dropdown-item selected';
                        found = true;
                    }
                    else
                        this.className='dropdown-item';
                    if(view)
                        href+='&view='+view;
                }
                else if(this.attributes['view'])
                {
                    if(filter)
                        href+='&filter='+filter;
                    href+='&view='+this.attributes['view'].nodeValue;
                    if(view===this.attributes['view'].nodeValue)
                    {
                        this.className='dropdown-item selected';
                        found = true;
                    }
                    else
                        this.className='dropdown-item';

                }
                $(this).prop('href', href);
                $(this).off('click').on('click',function(event){
                    $('.dropdown-menu').removeClass("show");

                    var btnObj = event.target;
                    if(btnObj.nodeName=='I')
                        btnObj = $(btnObj).parent()[0];
                    let pageURL = $(btnObj).attr('href');
                    if(pageURL!=window.location)
                    {
                        window.history.pushState({path:pageURL},' ',pageURL);
                        drawWindow();
                    }
                    return false;
                });
            });
            if(!found)
            {
                defaultElement.className='dropdown-item selected';
            }
        }
    },
    buildDataTableTemplate:function(dataUrl)
    {
        var ret = {
            colReorder:true,
            pageLength:25,
            retrieve: true,
            ajax: {
                url: dataUrl,
                dataSrc: ""
            },
            processing: true,
            language: {
                loadingRecords: "&nbsp;",
                processing: '<div class="load-spinner"></div>'
            },
            columns:null
        }
        return ret;
    }
}
