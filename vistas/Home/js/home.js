/* 
 * Funcionamiento de la interfaz grafica en la pantalla principal del sistema
 * @Autor Carlos Reyes
 * @Fecha Octubre 2018
 */

// Path absoluto del sitio
var pathSite = $('#absolutePathSite').val();

$(document).ready(function(){
    // Cierra loading principal
    $('#inicializaSistema').css({"visibility":"hidden","display":"none"});
    
    // Botones
    $( '#home_logout' ).button().click(function(){
        logout();
    });
    
    // Salir header
    $( '#home_salir_header' ).css('cursor','pointer').click(function(){
    	logout();
    });

    // Paneles
    $( 'body' ).layout({
        west__spacing_open:1,
        west__resizable: false,
        north__resizable: false,
        north__spacing_open:1,
        contentSelector: ".ui-widget-content"
    });
    
    // Tabs
    $.jgrid.defaults = $.extend($.jgrid.defaults,{ loadui: 'enable' });
    var maintab =jQuery( '#tabs' , '#RightPane' ).tabs({
                    add: function(e, ui) {
                        $(ui.tab).parents( 'li:first' )
                        .append( '<span class="ui-tabs-close ui-icon ui-icon-close" title="Cerrar Secci&oacute;n"></span>' )
                        .find( 'span.ui-tabs-close' )
                        .click(function() {
                            maintab.tabs( 'remove' , $('li', maintab).index($(this).parents('li:first')[0]) );
                        });
                        maintab.tabs( 'select' , '#' + ui.panel.id );
                    },
                    select: function(e,ui){
                        if( ('#'+ui.panel.id) == "#tabs-1" ){
                            $("#loading-gral-sitio").dialog("close");
                        }
                    },
                    spinner: 'Cargando ...'
                });
    
    // Menu
    $( '#home_grid_menu' ).jqGrid({
        url           : '../Home/menu/',
        datatype      : 'xml',
        height        : 'auto',
        loadui        : 'disable',
        pager         : false,
        hidegrid      : false,      
        colNames      : [ 'id' , 'Opciones' , 'URL' ],
        colModel      : [
                            {name: 'id'  , width:1  , hidden:true     , key:true      },
                            {name: 'menu', width:150, resizable: false, sortable:false},
                            {name: 'url' , width:1  , hidden:true                     }
                        ],
        treeGrid      : true,
        caption       : '',
        ExpandColumn  : 'menu',
        autowidth     : true,
        rowNum        : 200,
        ExpandColClick: true,
        treeIcons     : {plus:'ui-icon-folder-collapsed',minus:'ui-icon-folder-open',leaf:'ui-icon-document'},
        onSelectRow   : function(rowid) {
                            var treedata = $('#home_grid_menu').jqGrid('getRowData',rowid);
                            if(treedata.isLeaf=='true') {
                                var st = '#t'+treedata.id;
                                var tabNameExists = false;

                                $('#tabs ul li a').each(function(i) {
                                    partesSecciones = treedata.menu;
                                    if ($(this).text().search(partesSecciones) != -1) {
                                        getID         = this.href.split('-');
                                        elementos     = getID.length;
                                        idSelectedTab = getID[elementos-1];
                                        tabNameExists = true;
                                    }
                                });

                                if(tabNameExists) {
                                    maintab.tabs('select','#ui-tabs-'+idSelectedTab);
                                } else {
                                    $('#loading-gral-sitio').dialog({zIndex:10500,width:300,height:120,modal:true,resizable:false,closeOnEscape:false,draggable:false,title:false,bgiframe:true}).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
                                    maintab.tabs('add',treedata.url,treedata.menu);
                                    $.ajax({
                                        url     : treedata.url,
                                        type    : 'GET',
                                        dataType: 'html',
                                        cache   : false,
                                        complete: function (req, err) {
                                            $(treedata.url,'#tabs').append(req.responseText);
                                        }
                                    });
                                }
                            }
                        }
    });
    
    
    
});

function logout(){
    location.replace( '../../Home/logout/' );
}
 
function preload( arrayOfImages ) {
    $( arrayOfImages ).each(function(){
        $('<img/>')[0].src = this;
    });
}
