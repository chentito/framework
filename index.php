<?php
/* 
 * Script inicial de la aplicacion, recibe la peticion http/https y la
 * procesa de acuerdo a los parametros adicionales recibidos.
 * 
 * @Framework 
 * @Autor Carlos Reyes
 * @Fecha Octubre 2018
 */

/*
 * Agrega archivo de configuracion para constantes globales del sistema
 */
include_once './config/config.php';
include_once './config/dialogos.php';

/*
 * Agrega la instancia al despachador de peticiones para realizar el direccionamiento solicitado
 */
include_once './sistema/Peticiones/Despachador.php';
$sistema = new Despachador();

/*
 * Inicia la ejecucion del sistema
 */
$sistema->ejecuta(); 
