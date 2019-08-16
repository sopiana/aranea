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
// require('quill');
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
            case 'issues-request':
                this.subMenuRequests.draw();
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
        overlay : new LoadOverlay('#project-list-table'),
        draw: function()
        {
            $('#projectList-detail').appendTo('#pageContainer');
            $('#project-list-table').DataTable( {
                colReorder:true,
                // dom:'Bfrtip',
                // buttons:['colvis'],
                retrieve: true,
                "ajax": {
                    "url": window.location.origin+'/api/secure/projectList',
                    "dataSrc": ""
                },
                "columns": [
                    { "data": "name",
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.avatar +'" width="30px">'+ row.name;}
                    },
                    { "data": "project_code" },
                    { "data": "owner",
                        render: function ( data, type, row ) {
                            return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.owner_avatar +'" width="30px">'+ row.owner;}},
                    { "data": "kind" },
                    { "data": "created_at" },
                    { "data": "is_active" }
                ]
            } );
        }
    },
    subMenuRequests:{
        draw:function(){
            $('#requestList-detail').appendTo('#pageContainer');
            // $('#project-list-table').DataTable( {
            //     colReorder:true,
            //     // dom:'Bfrtip',
            //     // buttons:['colvis'],
            //     retrieve: true,
            //     "ajax": {
            //         "url": window.location.origin+'/api/secure/projectList',
            //         "dataSrc": ""
            //     },
            //     "columns": [
            //         { "data": "name",
            //             render: function ( data, type, row ) {
            //                 return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.avatar +'" width="30px">'+ row.name;}
            //         },
            //         { "data": "project_code" },
            //         { "data": "owner",
            //             render: function ( data, type, row ) {
            //                 return '<img class="img-avatar pr-2" src="'+window.location.origin+'/'+row.owner_avatar +'" width="30px">'+ row.owner;}},
            //         { "data": "kind" },
            //         { "data": "created_at" },
            //         { "data": "is_active" }
            //     ]
            // } );
        }
    }
}

function LoadOverlay(id){
    this.id = id;
    this.show = function(id){
        if(id){
            this.id=id;
        }
        console.log($(this.id));
        $(this.id).children('#load-overlay').remove();
        $(this.id).append('<div id="load-overlay" class="overlay text-center pt-4" style="display:block">'+
                '<div id="load-spinner" class="load-spinner" style="display:block"></div>'+
            '</div>');
    }

    this.hide = function(id){
        if(id)
            this.id=id;
        console.log('close :' +$(this.id));
        $(this.id).children('#load-overlay').remove();
    }
}


