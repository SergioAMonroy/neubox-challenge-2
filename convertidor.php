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
    //echo "Iniciando la rutina";
    $ctrlEntrada = new archivoEntradaCtrl();
	$beanChallenge2 = $ctrlEntrada->leeArchivo($nombreArchivoEntrada);
    echo "Datos en el bean ";
    var_dump($beanChallenge2);
    $ctrlProceso =new procesaDatosBeanCtrl();
	$marcadores = $ctrlProceso->calculaSnapshotsDeJuego($beanChallenge2->marcadores);
    echo "<br>MArcadores<br>";
    var_dump($marcadores);
    $ventajaMaxima = $ctrlProceso->obtenLaVentajaMaxima($marcadores);
    echo "<br>Ventaja máxima<br>";
    var_dump($ventajaMaxima);
    $ctrlProceso->almacenaArchivoSalida($archivoDeSalida, $ventajaMaxima);
}

procesaArchivo(__DIR__ ."/entrada.txt", __DIR__ . "/salida.txt");
