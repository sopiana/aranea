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
        $('.dropdown-menu').removeClass("show").delay(100).queue(function(next){
            var btnObj = event.target;
            if(btnObj.nodeName=='I')
                btnObj = $(btnObj).parent()[0];
            let pageURL = $(btnObj).attr('href');
            if(pageURL!=window.location)
            {
                window.history.pushState({path:pageURL},' ',pageURL);
                drawWindow();
            }
            next();
        });
        return false;
    });
    drawWindow();
});

var dashboardPage = {
    page:"dashboard",
    drawPage:function()
    {
        var subPageStr = getWindowParam('page');
        var view = getWindowParam('view');
        view = (view==null?'list':view);
        var filter = getWindowParam('filter');
        filter = (filter==null?'my-open':filter);
        console.log(view +" "+filter);
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
            this.datatable = Utils.renderDataTable("#project-list-table", window.location.origin+'/api/secure/projectList',[
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
                Utils.renderColWithImage("owner", "row.owner_avatar","row.owner"),
                { data: "kind" },
                Utils.renderColDate("created_at","row.created_at"),
                { data:"is_active" }
            ]);
        }
    },
    subMenuTasks:
    {
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#taskList-detail', dashboardPage.page);

            this.datatable = Utils.renderDataTable('#task-list-table', window.location.origin+'/api/secure/taskList', [
                    { data: "id", width:COL_CODE_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return 'TSK_'+row.id;
                        }
                    },
                    { data: "summary" },
                    { data: "status_name", width: COL_STATUS_WIDTH+'px'},
                    Utils.renderColWithImage("submitter_name","row.submitter_avatar","row.submitter_name"),
                    Utils.renderColDate("created_at","row.created_at"),
                    Utils.renderColPriority(),
                    Utils.renderColWithImage("assignee_name","row.assignee_avatar","row.assignee_name")
                ]);
        }
    },
    subMenuAllItems:{
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#allItemList-detail', dashboardPage.page);

            this.datatable = Utils.renderDataTable('#allItem-list-table',window.location.origin+'/api/secure/allItemList', [
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
                Utils.renderColWithImage("submitter_name","row.submitter_avatar","row.submitter_name"),
                Utils.renderColDate("created_at","row.created_at"),
                Utils.renderColPriority(),
                Utils.renderColWithImage("assignee_name","row.assignee_avatar","row.assignee_name")
            ]);
        }
    },
    subMenuRequests:{
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#requestList-detail', dashboardPage.page);

            this.datatable = Utils.renderDataTable('#request-list-table', window.location.origin+'/api/secure/requestList', [
                { data: "id", width:COL_CODE_WIDTH+'px',
                    render: function ( data, type, row ) {
                        return 'RQS_'+row.id;
                    }
                },
                { data: "summary" },
                { data: "status_name", width:COL_STATUS_WIDTH+'px'},
                Utils.renderColWithImage("submitter_name","row.submitter_avatar","row.submitter_name"),
                Utils.renderColDate("created_at","row.created_at"),
                Utils.renderColPriority(),
                Utils.renderColWithImage("assignee_name","row.assignee_avatar","row.assignee_name")
            ]);
        }
    },
    subMenuRequirements:
    {
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#requirementList-detail', dashboardPage.page);
            this.datatable = Utils.renderDataTable("#requirement-list-table", window.location.origin+'/api/secure/requirementList', [
                    { data: "id", width:COL_CODE_WIDTH+'px',
                        render: function ( data, type, row ) {
                            return 'REQ_'+row.id;
                        }
                    },
                    { data: "summary" },
                    { data: "status_name", width: COL_STATUS_WIDTH+'px'},
                    Utils.renderColWithImage("submitter_name","row.submitter_avatar","row.submitter_name"),
                    Utils.renderColDate("created_at","row.created_at"),
                    Utils.renderColPriority(),
                    Utils.renderColWithImage("assignee_name","row.assignee_avatar","row.assignee_name")
            ]);
        }
    },
    subMenuTestCase:
    {
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#testCaseList-detail', dashboardPage.page);

            this.datatable = Utils.renderDataTable('#testCase-list-table', window.location.origin+'/api/secure/testCaseList', [
                { data: "id", width:COL_CODE_WIDTH+'px',
                    render: function ( data, type, row ) {
                        return 'TC_'+row.id;
                    }
                },
                { data: "summary" },
                { data: "status_name", width: COL_STATUS_WIDTH+'px'},
                Utils.renderColWithImage("submitter_name","row.submitter_avatar","row.submitter_name"),
                Utils.renderColDate("created_at","row.created_at"),
                Utils.renderColPriority(),
                Utils.renderColWithImage("assignee_name","row.assignee_avatar","row.assignee_name")
            ]);
        }
    },
    subMenuRelease:
    {
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#releaseList-detail', dashboardPage.page);

            this.datatable = Utils.renderDataTable('#release-list-table', window.location.origin+'/api/secure/releaseList', [
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
                Utils.renderColDate("started_at", "row.started_at", false),
                Utils.renderColDate("ended_at","row.ended_at", false),
                Utils.renderColWithImage("submitter_name","row.submitter_avatar","row.submitter_name"),
                Utils.renderColWithImage("owner_name", "row.owner_avatar","row.owner_name")
            ]);
        }
    },
    subMenuBug:
    {
        datatable:null,
        draw:function(){
            Utils.renderFilterDropdown('#bugList-detail', dashboardPage.page);

            this.datatable = Utils.renderDataTable('#bug-list-table', window.location.origin+'/api/secure/bugList', [
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
                Utils.renderColWithImage("submitter_name", "row.submitter_avatar","row.submitter_name"),
                Utils.renderColDate("created_at", "row.created_at"),
                Utils.renderColPriority(),
                { sType:"priority", data: "severity", width: COL_PRIORITY_WIDTH+'px',
                    render: function ( data, type, row ) {
                        switch(row.severity)
                        {
                            case 'SEVERITY_LOW':
                                return '<div data-priority = "1" class="badge badge-info"><i class="fa fa-chevron-down"></i> Low</div>';
                            case 'SEVERITY_MEDIUM':
                                return '<div data-priority = "2" class="badge badge-warning"><i class="fa fa-chevron-up"></i> Medium</div>';
                            case 'SEVERITY_HIGH':
                                return '<div data-priority = "3" class="badge badge-danger"><i class="fa fa-chevron-up"></i> High</div>';
                            case 'SEVERITY_CRITICAL':
                                return '<div data-priority = "4" class="badge badge-critical"><i class="fa fa-exclamation"></i> Critical</div>';
                            default:
                                return row.severity;
                        }
                    }
                },
                Utils.renderColWithImage("assignee_name", "row.assignee_avatar", "row.assignee_name")
            ]);
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
                    $('.dropdown-menu').removeClass("show").delay(100).queue(function(next){
                        var btnObj = event.target;
                        if(btnObj.nodeName=='I')
                            btnObj = $(btnObj).parent()[0];
                        let pageURL = $(btnObj).attr('href');
                        if(pageURL!=window.location)
                        {
                            window.history.pushState({path:pageURL},' ',pageURL);
                            drawWindow();
                        }
                        next();
                    });
                    return false;
                });
            });

            if(!found)
            {
                defaultElement.className='dropdown-item selected';
            }
        }
    },
    renderDataTable:function(container, url, columnDefinitions)
    {
        var setting = {
            colReorder:true,
            pageLength:25,
            columns:columnDefinitions,
            processing: true,
            serverSide: true,
            ajax:null,
        }
        if(url!=null)
            setting.ajax = url;
        $(container).DataTable().destroy();
        return $(container).DataTable(setting);
    },
    renderColPriority:function()
    {
        let ret= {
            data: "priority", width: COL_PRIORITY_WIDTH+'px',
            sType:"priority",
            render: function ( data, type, row )
            {
                switch(row.priority)
                {
                    case 'PRIORITY_LOW':
                        return '<div data-priority = "1" class="badge badge-info"><i class="fa fa-chevron-down"></i> Low</div>';
                    case 'PRIORITY_MEDIUM':
                        return '<div data-priority = "2" class="badge badge-warning"><i class="fa fa-chevron-up"></i> Medium</div>';
                    case 'PRIORITY_HIGH':
                        return '<div data-priority = "3" class="badge badge-danger"><i class="fa fa-chevron-up"></i> High</div>';
                    case 'PRIORITY_URGENT':
                        return '<div data-priority = "4" class="badge badge-critical"><i class="fa fa-exclamation"></i> Urgent</div>';
                    default:
                        return row.priority;
                }
            }
        }
        return ret;
    },
    renderColWithImage:function(dataEntry, avatar, text, url=null)
    {
        let ret = {
            data: dataEntry, width: COL_USERNAME_WIDTH+'px',
            render: function ( data, type, row ) {
                return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+eval(avatar)+'" width="30px">'+ eval(text);
            }
        }
        return ret;
    },
    renderColDate:function(dataEntry, date, isDateTime=true)
    {
        let ret = { data: dataEntry, width: COL_CREATION_DATE_WIDTH+'px',
            sType:"date",
            render:function(data, type, row) {
                return '<div data-date = "'+eval(date)+'">'+Utils.getDateStr(eval(date), isDateTime)+'</div>';
            }
        }
        return ret;
    }
}

jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "priority-pre": function ( a ) {
        return $(a).data("priority");
    },
    "priority-asc": function( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
    "priority-desc": function(a,b) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    },
    "date-pre":function(a){
        return $(a).data("date");
    },
    "date-asc": function( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
    "date-desc": function(a,b) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});
