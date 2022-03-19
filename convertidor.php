<?php
require_once __DIR__ . '/ctrl/archivoEntradaCtrl.php';
require_once __DIR__ . '/ctrl/procesaDatosBeanCtrl.php';
require_once __DIR__ . '/bean/challenge2Bean.php';
require_once __DIR__ . '/bean/marcadoresBean.php';
require_once __DIR__ . '/bean/snapshotJuegoBean.php';

/**
 * Realiza la rutina de validar las entradas, limpiar lo puesto en el archivo y crear el archivo de salida
 * @param String $nombreArchivoEntrada La ubicación donde se encuentra el archivo de entrada.
 * @param String $archivoDeSalida La ruta donde se almacenará el archivo de salida.
 */
function procesaArchivo($nombreArchivoEntrada, $archivoDeSalida){
    $ctrlEntrada = new archivoEntradaCtrl();
	$beanChallenge2 = $ctrlEntrada->leeArchivo($nombreArchivoEntrada);
    
    $ctrlProceso =new procesaDatosBeanCtrl();
	$marcadores = $ctrlProceso->calculaSnapshotsDeJuego($beanChallenge2->marcadores);
    
    $ventajaMaxima = $ctrlProceso->obtenLaVentajaMaxima($marcadores);
   
    $ctrlProceso->almacenaArchivoSalida($archivoDeSalida, $ventajaMaxima);
}

procesaArchivo(__DIR__ ."/entrada.txt", __DIR__ . "/salida.txt");
