/* 
 * Control de interfaz para el envio de credenciales de acceso a usuarios de captura
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Abril 2018
 */
$( document ).ready(function() {

    cargaListadoUsuarios();

    $( '#envioCredenciales_btnGeneraDatos' ).button().click(function() {
        generaDatosAcceso();
    });

    $( '#envioCredenciales_btnEnviarMensaje' ).button().click( function() {
        enviaDatosAcceso();
    });

});


function cargaListadoUsuarios() {
    $( '#envioCredenciales_contenedorUsuarios' ).html( '' );
    $.post( '../../Sistema/listadoUsuariosAccesos/' , function( d ) {
        datos = JSON.parse( d );
        
        $.each( datos , function( i , e ) {
            htmlSTR  = '<tr class="ui-widget ui-widget-content"><input type="hidden" id="usrCapEditaID_'+i+'" name="usrCapEditaID_'+i+'" value="'+e.id+'" />';
            htmlSTR += '<td width="20%" align="left"><span class="listadoUsuariosCaptura_read_'+i+'">'+e.nombre+'</span><span class="listadoUsuariosCaptura_write_'+i+'"><input type="text" maxlength="100" id="usrCapEditaNombre_'+i+'" name="usrCapEditaNombre_'+i+'" value="'+e.nombre+'"/></span></td>';
            htmlSTR += '<td width="20%" align="center"><span class="listadoUsuariosCaptura_read_'+i+'">'+e.usuario+'</span><span class="listadoUsuariosCaptura_write_'+i+'"><input type="text" maxlength="20" id="usrCapEditaUsuario_'+i+'" name="usrCapEditaUsuario_'+i+'" value="'+e.usuario+'" /></span></td>';
            htmlSTR += '<td width="20%" align="center"><span class="listadoUsuariosCaptura_read_'+i+'">'+e.contrasena+'</span><span class="listadoUsuariosCaptura_write_'+i+'"><input type="text" maxlength="20" id="usrCapEditaContrasena_'+i+'" name="usrCapEditaContrasena_'+i+'" value="'+e.contrasena+'" /></span></td>';
            htmlSTR += '<td width="20%" align="center"><span class="listadoUsuariosCaptura_read_'+i+'">'+e.email+'</span><span class="listadoUsuariosCaptura_write_'+i+'"><input type="text" maxlength="100" id="usrCapEditaEmail_'+i+'" name="usrCapEditaEmail_'+i+'" value="'+e.email+'" /></span></td>';
            htmlSTR += '<td width="20%" align="center">';
            htmlSTR += '<span class="listadoUsuariosCaptura_read_'+i+'">';
            htmlSTR += '<button id="btnActualizaUsuario_'+i+'" name="btnActualizaUsuario_'+i+'">Actualizar</button>&nbsp;&nbsp;';
            htmlSTR += '</span>';
            htmlSTR += '<span class="listadoUsuariosCaptura_write_'+i+'">&nbsp;&nbsp;';
            htmlSTR += '<button id="btnGdaCambioActualizacion_'+i+'" name="btnGdaCambioActualizacion_'+i+'">Guardar Cambios</button>&nbsp;';
            htmlSTR += '<button id="btnCancelaActualizacion_'+i+'" name="btnCancelaActualizacion_'+i+'">Cancelar Edicion</button>&nbsp;&nbsp;';
            htmlSTR += '</span>';
            htmlSTR += '<button id="btnEliminaUsuario_'+i+'" name="btnEliminaUsuario_'+i+'">Eliminar</button>';
            htmlSTR += '</td>';
            htmlSTR += '</tr>';
            $( '#envioCredenciales_contenedorUsuarios' ).append( htmlSTR );

            $( '#btnEliminaUsuario_' + i ).button().click(function() {
                eliminaUsuario( e.id );
            });

            $( '#btnActualizaUsuario_' + i ).button().click(function() {
                editaUsuario( e.id , i );
            });
            
            $( '#btnGdaCambioActualizacion_'+i ).button({
                icons:{
                    primary: "ui-icon-disk"
                },
                text: false
            }).click( function(){
                guardaCambiosEdicionUsuarioCaptura( i );
            });

            $( '#btnCancelaActualizacion_'+i ).button({
                icons:{
                    primary: "ui-icon-circle-close"
                },
                text: false
            }).click( function(){
                cancelaEdicionUsuarioCaptura( i );
            });

            $( '.listadoUsuariosCaptura_write_' + i ).hide();
        });

    });

}

function guardaCambiosEdicionUsuarioCaptura( linea ) {
    id         = $( '#usrCapEditaID_' + linea ).val();
    nombre     = $( '#usrCapEditaNombre_' + linea ).val();
    usuario    = $( '#usrCapEditaUsuario_' + linea ).val();
    contrasena = $( '#usrCapEditaContrasena_' + linea ).val();
    email      = $( '#usrCapEditaEmail_' + linea ).val();
    
    $.post( '../../Sistema/actualizaDatosUsuarioCaptura/id='+id+'|nombre='+nombre+'|usuario='+usuario+'|contrasena='+contrasena+'|email='+email+'/' , function( r ){
        if( r == '1' ){
                mensaje = "Usuario actualizado correctamente";
            } else {
                mensaje = "Error al actualizar, intente m&aacute;s tarde.";
        }
        dialogoAviso( "Actualizacion usuario" , mensaje );
        cargaListadoUsuarios();
    });
    
}

function cancelaEdicionUsuarioCaptura( linea ) {
    $( '.listadoUsuariosCaptura_read_' + linea ).show();
    $( '.listadoUsuariosCaptura_write_' + linea ).hide();
}

function editaUsuario( id , linea ) {
    $( '.listadoUsuariosCaptura_read_' + linea ).hide();
    $( '.listadoUsuariosCaptura_write_' + linea ).show();
}

function eliminaUsuario( id ) {
    $( '#dialogoEliminaUsuarioCaptura' ).remove();
    $( 'body' ).append( '<div id="dialogoEliminaUsuarioCaptura" name="dialogoEliminaUsuarioCaptura" title="Elimina Usuario Captura"><center>El usuario se eliminar&aacute;, desea continuar?</center></div>' );
    
    $( '#dialogoEliminaUsuarioCaptura' ).dialog({
        modal: true, draggable: false, closeOnEscape: false, resizable: false, width:600, height:100,
        buttons: {
            'Eliminar':function() {
                $.post( '../../Sistema/eliminaUsuarioCaptura/id='+id+'/' , function(){
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#dialogoEliminaUsuarioCaptura' ).remove();
                    dialogoAviso( "Control de Usuarios" , "El usuario se ha eliminado correctamente." );
                    cargaListadoUsuarios();
                });
            },
            'Cancelar': function() {
                $( this ).dialog( 'close' );
                $( this ).dialog( 'destroy' );
                $( '#dialogoEliminaUsuarioCaptura' ).remove();
            }
        }
    }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();

}


function generaDatosAcceso() {
    email = $( '#envioCredenciales_email' ).val();
    if( email == '' ) {
        dialogoAviso( "Error env&iacute;o" , "Debe proporcionar una cuenta de correo eletr&oacute;nico v&aacute;lida." );
    } else {
        $.post( '../../Sistema/verificaEmailAcceso/email='+email+'/' , function(a){
            if( a == '0' ) {
                email = $( '#envioCredenciales_email' ).val().split( '@' );
                pass  = generaContrasenia();
                $( '#envioCredenciales_usuario' ).val( email[ 0 ] );
                $( '#envioCredenciales_password' ).val( pass );
            } else {
                dialogoAviso( "Error env&iacute;o" , "La cuenta proporcionada ya se encuentra en uso." );
            }
        });
    }
}


function generaContrasenia() {
    numeros      = [ 0 , 1 , 2 , 3 , 4 , 5 , 6 , 7 , 8 , 9 ];
    letras       = [ 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    var password = '';

    for( i = 0 ; i < 6 ; i ++ ) {
        password += letras[Math.floor(Math.random() * letras.length)];
    }

    for( j = 0 ; j < 3 ; j ++ ) {
        password += numeros[Math.floor(Math.random() * numeros.length)];
    }

    return password;
}


function enviaDatosAcceso() {
    if( $( '#envioCredenciales_usuario' ).val() == '' || $( '#envioCredenciales_password' ).val() == '' ) {
        dialogoAviso( "Error env&iacute;o" , "No ha asignado credenciales de acceso v&aacute;lidas." );
    } else {
        abreModalSistema();
        correo     = $( '#envioCredenciales_email' ).val();
        nombre     = $( '#envioCredenciales_nombre' ).val();
        usuario    = $( '#envioCredenciales_usuario' ).val();
        contrasena = $( '#envioCredenciales_password' ).val();

        $.post( '../../Sistema/enviaDatosDeAcceso/correo='+correo+'|nombre='+nombre+'|usuario='+usuario+'|contrasena='+contrasena+'/' , function( a ) {
            if( a == '1' ) {
                dialogoAviso( 'Alta Usuario' , 'El usuario ha sido agregado y notificado.' );
                cargaListadoUsuarios();
            } else {
                dialogoAviso( 'Error Alta' , 'Se present&oacute; un error al dar al usuario de alta.' );
            }
            cierraModalSistema();
        });
        
        $( '#envioCredenciales_email' ).val( '' );
        $( '#envioCredenciales_nombre' ).val( '' );
        $( '#envioCredenciales_usuario' ).val( '' );
        $( '#envioCredenciales_password' ).val( '' );
    }
}

























