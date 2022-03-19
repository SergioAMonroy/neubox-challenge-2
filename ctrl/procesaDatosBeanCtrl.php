<?php
/**
 * Clase para el proceso de los datos del control.
 */
class procesaDatosBeanCtrl{
    /**
     * Genera el resumen del juego con cada linea de marcador
     * @param type $marcadores
     * @return array Regresa una lista de resumen del juego para poder encontrar al vencedor del juego
     */
    public function calculaSnapshotsDeJuego($marcadores){
        $snapshots =[];
        $acumuladoJugador1 = 0;
        $acumuladoJugador2 = 0;

        for($i = 0;$i<count($marcadores);$i++){
            $marcador = $marcadores[$i];

            $snapshot = new snapshotJuegoBean();
            $snapshot->round = $i+1;
            
            $acumuladoJugador1 = $acumuladoJugador1 + $marcador->marcador1;
            $acumuladoJugador2 = $acumuladoJugador2 + $marcador->marcador2;

            $snapshot->jugador1 = $acumuladoJugador1;
            $snapshot->jugador2 = $acumuladoJugador2;
            $snapshot->lider = ($snapshot->jugador1>$snapshot->jugador2)?"1":"2";
            $snapshot->ventaja = abs($snapshot->jugador1-$snapshot->jugador2);
            array_push($snapshots, $snapshot);
        }
        return $snapshots;
    }

    /**
     * Con la lista de snapshots se busca el registro con la ventaja maxima
     * @param type $snapshots La lista de Snapshots creados con los registros del archivo de inicio
     * @return type regresa un objeto de tipo Snapshot con la ventaja mayor del juego
     */
    public function obtenLaVentajaMaxima($snapshots){
        $ventajaMaxima = $snapshots[0];
        for($i = 0;$i<count($snapshots);$i++){
            $snapshotsActual = $snapshots[$i];
            if($snapshotsActual->ventaja > $ventajaMaxima->ventaja){
                $ventajaMaxima = $snapshotsActual;
            }
        
        }
        return $ventajaMaxima;
    }
    
    /**
     * Crea el archivo de salida con los datos del registro donde se obtuvo la ventaja maxima
     * @param type $archivoDeSalida
     * @param type $snapshotMaximo
     */
    public function almacenaArchivoSalida($archivoDeSalida, $snapshotMaximo){
        
        $myfile = fopen($archivoDeSalida, "w") or die("No se puede abrir el archivo!");
        
        fwrite($myfile, $snapshotMaximo->lider . " " . $snapshotMaximo->ventaja);
        fclose($myfile);
    }
}
