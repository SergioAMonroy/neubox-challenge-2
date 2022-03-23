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
function procesaArchivo($nombreArchivoEntrada, $archivoDeSalida) {
    $ctrlEntrada = new archivoEntradaCtrl();
    try {
        $beanChallenge2 = $ctrlEntrada->leeArchivo($nombreArchivoEntrada);


        $ctrlProceso = new procesaDatosBeanCtrl();
        $marcadores = $ctrlProceso->calculaSnapshotsDeJuego($beanChallenge2->marcadores);

        $ventajaMaxima = $ctrlProceso->obtenLaVentajaMaxima($marcadores);

        $ctrlProceso->almacenaArchivoSalida($archivoDeSalida, $ventajaMaxima);
    } catch (MyException $e) {
        throw $e;
    }
    
    return '{"mensaje":"Exito"}';
}

$uploadfile = __DIR__ . '/subidas/entrada.txt';

if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
    http_response_code(404);
    echo '{"mensaje":"No fue posible subir el archivo"}';
}

try {
    echo procesaArchivo(__DIR__ . "/subidas/entrada.txt", __DIR__ . "/subidas/salida.txt");
} catch (Exception $e) {
    http_response_code(404);
    echo '{"mensaje":"' . $e->getMessage() . '"}';
} 