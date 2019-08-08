require('./bootstrap');
window.$ = window.jQuery = require('jquery');
require('popper.js');
require('@coreui/coreui/dist/js/coreui');

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
        }
    },
    subMenuProfile:{
        draw: function()
        {
            $('#profile-detail').appendTo('#pageContainer');
        }
    }
}


