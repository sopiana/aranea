require('./bootstrap');
window.$ = window.jQuery = require('jquery');
require('popper.js');
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

function drawWindow(){
    let pageMenu=window.location.href.substr(window.location.origin.length+1);
    pageMenu = pageMenu.substr(0,pageMenu.indexOf('/'));

    switch(pageMenu){
        case "dashboard":
            dashboardPage.drawPage();
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
    //
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
                this.datatable = $('#project-list-table').DataTable( {
                    colReorder:true,
                    // dom:'Bfrtip',
                    // buttons:['colvis'],
                    retrieve: true,
                    ajax: {
                        url: window.location.origin+'/api/secure/projectList',
                        dataSrc: ""
                    },
                    processing: true,
                    language: {
                        loadingRecords: "&nbsp;",
                        processing: '<div class="load-spinner"></div>'
                    },
                    columns: [
                        { data: "project_code", width:COL_CODE_WIDTH+'px'},
                        { data: "name",
                            render: function ( data, type, row ) {
                                return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.avatar +'" width="30px">'+ row.name;}
                        },
                        { data: "owner", width:COL_USERNAME_WIDTH+'px',
                            render: function ( data, type, row ) {
                                return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.owner_avatar +'" width="30px">'+ row.owner;}},
                        { data: "kind" },
                        { data: "created_at" },
                        { data: "is_active" }
                    ]
                } );
            }
            else
                this.datatable.ajax.reload();
        }
    },
    subMenuTasks:
    {
        datatable:null,
        draw:function(){
            $('#taskList-detail').appendTo('#pageContainer');
            if(this.datatable == null)
            {
                this.datatable = $('#task-list-table').DataTable( {
                    colReorder:true,
                    retrieve: true,
                    ajax: {
                        url: window.location.origin+'/api/secure/taskList',
                        dataSrc: ""
                    },
                    processing: true,
                    language: {
                        loadingRecords: "&nbsp;",
                        processing: '<div class="load-spinner"></div>'
                    },
                    columns: [
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
                        { data: "created_at", width: COL_CREATION_DATE_WIDTH+'px'},
                        { data: "priority", width: COL_PRIORITY_WIDTH+'px',
                            render: function ( data, type, row ) {
                                switch(row.priority)
                                {
                                    case 'PRIORITY_LOW':
                                        return '<i class="fa fa-chevron-down" style="color:#63c2de"></i> Low';
                                    case 'PRIORITY_MEDIUM':
                                        return '<i class="fa fa-chevron-up" style="color:#4dbd74"></i> Medium';
                                    case 'PRIORITY_HIGH':
                                        return '<i class="fa fa-chevron-up" style="color:#ffc107"></i> High';
                                    case 'PRIORITY_URGENT':
                                        return '<i class="fa fa-chevron-up" style="color:#f86c6b"></i> Urgent';
                                    default:
                                        return row.priority;
                                }
                            }
                        },
                        { data: "assignee_name", width: COL_USERNAME_WIDTH+'px',
                            render: function ( data, type, row ) {
                                return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.assignee_avatar +'" width="30px">'+ row.assignee_name;}}
                    ]
                } );
            }
            else
                this.datatable.ajax.reload();
        }
    },
    subMenuAllItems:{
        datatable:null,
        draw:function(){
            $('#allItemList-detail').appendTo('#pageContainer');
            if(this.datatable==null)
            {
                this.datatable = $('#allItem-list-table').DataTable( {
                    colReorder:true,
                    // dom:'Bfrtip',
                    // buttons:['colvis'],
                    retrieve: true,
                    ajax: {
                        url: window.location.origin+'/api/secure/allItemList',
                        dataSrc: ""
                    },
                    processing: true,
                    language: {
                        loadingRecords: "&nbsp;",
                        processing: '<div class="load-spinner"></div>'
                    },
                    columns: [
                        {
                            data:"item_type",
                            render: function ( data, type, row ) {
                                switch(row.item_type)
                                {
                                    case 'REQUEST': return '<i class="nav-icon icon-tag pr-2 bg-plum-plate"></i>Request';
                                    case 'REQUIREMENT': return '<i class="nav-icon icon-layers pr-2 bg-plum-plate"></i>Requirement';
                                    case 'TEST_CASE': return '<i class="nav-icon icon-target pr-2 bg-plum-plate"></i>Test Case';
                                    case 'BUG': return '<i class="nav-icon icon-ghost pr-2 bg-plum-plate"></i>Bug';
                                    case 'RELEASE': return '<i class="nav-icon icon-rocket pr-2 bg-plum-plate"></i>Release';
                                    default: return '<i class="nav-icon icon-social-steam pr-2 bg-plum-plate"></i>Test Run';
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
                        { data: "created_at", width: COL_CREATION_DATE_WIDTH+'px'},
                        { data: "priority", width: COL_PRIORITY_WIDTH+'px',
                            render: function ( data, type, row ) {
                                switch(row.priority)
                                {
                                    case 'PRIORITY_LOW':
                                        return '<i class="fa fa-chevron-down" style="color:#63c2de"></i> Low';
                                    case 'PRIORITY_MEDIUM':
                                        return '<i class="fa fa-chevron-up" style="color:#4dbd74"></i> Medium';
                                    case 'PRIORITY_HIGH':
                                        return '<i class="fa fa-chevron-up" style="color:#ffc107"></i> High';
                                    case 'PRIORITY_URGENT':
                                        return '<i class="fa fa-chevron-up" style="color:#f86c6b"></i> Urgent';
                                    default:
                                        return row.priority;
                                }
                            }
                        },
                        { data: "assignee_name", width: COL_USERNAME_WIDTH,
                            render: function ( data, type, row ) {
                                return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.assignee_avatar +'" width="30px">'+ row.assignee_name;}}
                    ]
                } );
            }
            else
                this.datatable.ajax.reload();
        }
    },
    subMenuRequests:{
        datatable:null,
        draw:function(){
            $('#requestList-detail').appendTo('#pageContainer');
            if(this.datatable==null)
            {
                this.datatable = $('#request-list-table').DataTable( {
                    colReorder:true,
                    // dom:'Bfrtip',
                    // buttons:['colvis'],
                    retrieve: true,
                    ajax: {
                        url: window.location.origin+'/api/secure/requestList',
                        dataSrc: ""
                    },
                    processing: true,
                    language: {
                        loadingRecords: "&nbsp;",
                        processing: '<div class="load-spinner"></div>'
                    },
                    columns: [
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
                        { data: "created_at", width: COL_CREATION_DATE_WIDTH+'px'},
                        { data: "priority", width: COL_PRIORITY_WIDTH+'px',
                            render: function ( data, type, row ) {
                                switch(row.priority)
                                {
                                    case 'PRIORITY_LOW':
                                        return '<i class="fa fa-chevron-down" style="color:#63c2de"></i> Low';
                                    case 'PRIORITY_MEDIUM':
                                        return '<i class="fa fa-chevron-up" style="color:#4dbd74"></i> Medium';
                                    case 'PRIORITY_HIGH':
                                        return '<i class="fa fa-chevron-up" style="color:#ffc107"></i> High';
                                    case 'PRIORITY_URGENT':
                                        return '<i class="fa fa-chevron-up" style="color:#f86c6b"></i> Urgent';
                                    default:
                                        return row.priority;
                                }
                            }
                        },
                        { data: "assignee_name", width: COL_USERNAME_WIDTH,
                            render: function ( data, type, row ) {
                                return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.assignee_avatar +'" width="30px">'+ row.assignee_name;}}
                    ]
                } );
            }
            else
                this.datatable.ajax.reload();
        }
    },
    subMenuRequirements:
    {
        datatable:null,
        draw:function(){
            $('#requirementList-detail').appendTo('#pageContainer');
            if(this.datatable == null)
            {
                this.datatable = $('#requirement-list-table').DataTable( {
                    colReorder:true,
                    retrieve: true,
                    ajax: {
                        url: window.location.origin+'/api/secure/requirementList',
                        dataSrc: ""
                    },
                    processing: true,
                    language: {
                        loadingRecords: "&nbsp;",
                        processing: '<div class="load-spinner"></div>'
                    },
                    columns: [
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
                        { data: "created_at", width: COL_CREATION_DATE_WIDTH+'px'},
                        { data: "priority", width: COL_PRIORITY_WIDTH+'px',
                            render: function ( data, type, row ) {
                                switch(row.priority)
                                {
                                    case 'PRIORITY_LOW':
                                        return '<i class="fa fa-chevron-down" style="color:#63c2de"></i> Low';
                                    case 'PRIORITY_MEDIUM':
                                        return '<i class="fa fa-chevron-up" style="color:#4dbd74"></i> Medium';
                                    case 'PRIORITY_HIGH':
                                        return '<i class="fa fa-chevron-up" style="color:#ffc107"></i> High';
                                    case 'PRIORITY_URGENT':
                                        return '<i class="fa fa-chevron-up" style="color:#f86c6b"></i> Urgent';
                                    default:
                                        return row.priority;
                                }
                            }
                        },
                        { data: "assignee_name", width: COL_USERNAME_WIDTH+'px',
                            render: function ( data, type, row ) {
                                return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.assignee_avatar +'" width="30px">'+ row.assignee_name;}}
                    ]
                } );
            }
            else
                this.datatable.ajax.reload();
        }
    },
    subMenuTestCase:
    {
        datatable:null,
        draw:function(){
            $('#testCaseList-detail').appendTo('#pageContainer');
            if(this.datatable == null)
            {
                this.datatable = $('#testCase-list-table').DataTable( {
                    colReorder:true,
                    retrieve: true,
                    ajax: {
                        url: window.location.origin+'/api/secure/testCaseList',
                        dataSrc: ""
                    },
                    processing: true,
                    language: {
                        loadingRecords: "&nbsp;",
                        processing: '<div class="load-spinner"></div>'
                    },
                    columns: [
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
                        { data: "created_at", width: COL_CREATION_DATE_WIDTH+'px'},
                        { data: "priority", width: COL_PRIORITY_WIDTH+'px',
                            render: function ( data, type, row ) {
                                switch(row.priority)
                                {
                                    case 'PRIORITY_LOW':
                                        return '<i class="fa fa-chevron-down" style="color:#63c2de"></i> Low';
                                    case 'PRIORITY_MEDIUM':
                                        return '<i class="fa fa-chevron-up" style="color:#4dbd74"></i> Medium';
                                    case 'PRIORITY_HIGH':
                                        return '<i class="fa fa-chevron-up" style="color:#ffc107"></i> High';
                                    case 'PRIORITY_URGENT':
                                        return '<i class="fa fa-chevron-up" style="color:#f86c6b"></i> Urgent';
                                    default:
                                        return row.priority;
                                }
                            }
                        },
                        { data: "assignee_name", width: COL_USERNAME_WIDTH+'px',
                            render: function ( data, type, row ) {
                                return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.assignee_avatar +'" width="30px">'+ row.assignee_name;}}
                    ]
                } );
            }
            else
                this.datatable.ajax.reload();
        }
    },

    subMenuRelease:
    {
        datatable:null,
        draw:function(){
            $('#releaseList-detail').appendTo('#pageContainer');
            if(this.datatable == null)
            {
                this.datatable = $('#release-list-table').DataTable( {
                    colReorder:true,
                    retrieve: true,
                    ajax: {
                        url: window.location.origin+'/api/secure/releaseList',
                        dataSrc: ""
                    },
                    processing: true,
                    language: {
                        loadingRecords: "&nbsp;",
                        processing: '<div class="load-spinner"></div>'
                    },
                    columns: [
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
                        { data: "started_at", width: COL_DATE_WIDTH+'px'},
                        { data: "ended_at", width: COL_DATE_WIDTH+'px'},
                        { data: "submitter_name", width:COL_USERNAME_WIDTH+'px',
                            render: function ( data, type, row ) {
                                return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.submitter_avatar +'" width="30px">'+ row.submitter_name;}},
                        { data: "owner_name", width: COL_USERNAME_WIDTH+'px',
                            render: function ( data, type, row ) {
                                return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.owner_avatar +'" width="30px">'+ row.owner_name;}}
                    ]
                } );
            }
            else
                this.datatable.ajax.reload();
        }
    },
    subMenuBug:
    {
        datatable:null,
        draw:function(){
            $('#bugList-detail').appendTo('#pageContainer');
            if(this.datatable == null)
            {
                this.datatable = $('#bug-list-table').DataTable( {
                    colReorder:true,
                    retrieve: true,
                    ajax: {
                        url: window.location.origin+'/api/secure/bugList',
                        dataSrc: ""
                    },
                    processing: true,
                    language: {
                        loadingRecords: "&nbsp;",
                        processing: '<div class="load-spinner"></div>'
                    },
                    columns: [
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
                        { data:"created_at", width:COL_CREATION_DATE_WIDTH+'px'},
                        { data: "priority", width: COL_PRIORITY_WIDTH+'px',
                            render: function ( data, type, row ) {
                                switch(row.priority)
                                {
                                    case 'PRIORITY_LOW':
                                        return '<i class="fa fa-chevron-down" style="color:#63c2de"></i> Low';
                                    case 'PRIORITY_MEDIUM':
                                        return '<i class="fa fa-chevron-up" style="color:#4dbd74"></i> Medium';
                                    case 'PRIORITY_HIGH':
                                        return '<i class="fa fa-chevron-up" style="color:#ffc107"></i> High';
                                    case 'PRIORITY_URGENT':
                                        return '<i class="fa fa-chevron-up" style="color:#f86c6b"></i> Urgent';
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
                                        return '<i class="fa fa-chevron-down" style="color:#63c2de"></i> Low';
                                    case 'SEVERITY_MEDIUM':
                                        return '<i class="fa fa-chevron-up" style="color:#4dbd74"></i> Medium';
                                    case 'SEVERITY_HIGH':
                                        return '<i class="fa fa-chevron-up" style="color:#ffc107"></i> High';
                                    case 'SEVERITY_CRITICAL':
                                        return '<i class="fa fa-chevron-up" style="color:#f86c6b"></i> Urgent';
                                    default:
                                        return row.priority;
                                }
                            }
                        },
                        { data: "assignee_name", width: COL_USERNAME_WIDTH+'px',
                            render: function ( data, type, row ) {
                                return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.assignee_avatar +'" width="30px">'+ row.assignee_name;}}
                    ]
                } );
            }
            else
                this.datatable.ajax.reload();
        }
    }
}



