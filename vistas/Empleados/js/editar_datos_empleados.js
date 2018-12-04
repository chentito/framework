/*
 *  * Controlador de la interfaz grafica del detalle de empleados
 *   * con las funcionalidades del sistema
 *    * @Autor Mexagon.net / Jose Gutierrez
 *     * @Fecha Febrero 2016
 *      */


$(function() {
    $("#altaEmpleados_comboSexo").val($("#sexoEmp_edita").val());
    $("#altaEmpleados_comboDepartamentos option:contains(" + $("#departamentoEmp_edita").val() + ")").attr('selected', 'selected');
    $('#fechaNacimientoEmp_edita').datepicker( {dateFormat:"yy-mm-dd", changeYear: true, minDate: -24600, monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"], dayNamesMin: ["Dom","Lun","Mar","Mie","Jue","Vie","Sab"]} ).datepicker();
});

function buscaDatosSepomexEdita(value){
    var cp = value;
    $.post( "/Empleados/buscaDatosSepomex/",
        {cp:cp},
        function( mensaje ){
            var json = $.parseJSON(mensaje);
            var comboColonia = "";
            var comboMunicipio = "";
            var comboEstado = "";
            var comboCiudad = "";
            $(json).each(function(i,val){
                $.each(val,function(k,v){
                    if(k == "colonia"){
                        comboColonia += "<option value=\'"+v+"\'>"+v+"</option>";
                    }
                    if(k == "estado"){
                        comboEstado = v;
                    }
                    if(k == "municipio"){
                        comboMunicipio = v;
                    }
                    if(k == "ciudad"){
                        comboCiudad = v;
                    }
                });
            }); 
            $("#altaEmpleadosInd_colonia").html(comboColonia);
            $("#estadoEmp_edita").val(comboEstado);
            $("#municipioEmp_edita").val(comboMunicipio);
            $("#localidadEmp_edita").val(comboCiudad);
        }
    );
}

function updateComboSexo(){
    alert("sdadas")
}
