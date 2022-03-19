<?php
class procesaDatosBeanCtrl{
    public function calculaSnapshotsDeJuego($marcadores){
        echo "Calculando los snapshots del juego";
        $snapshots =[];
        $acumuladoJugador1 = 0;
        $acumuladoJugador2 = 0;

        echo "Número de marcadores ".count($marcadores) ;
        for($i = 0;$i<count($marcadores);$i++){
            $marcador = $marcadores[$i];

            $snapshot = new snapshotJuegoBean();
            $snapshot->round = $i+1;
            
            $acumuladoJugador1 = $acumuladoJugador1 + $marcador->marcador1;
            $acumuladoJugador2 = $acumuladoJugador2 + $marcador->marcador2;
            echo "acumulados " . $acumuladoJugador1 . " - " . $acumuladoJugador2;
            $snapshot->jugador1 = $acumuladoJugador1;
            $snapshot->jugador2 = $acumuladoJugador2;
            $snapshot->lider = ($snapshot->jugador1>$snapshot->jugador2)?"1":"2";
            $snapshot->ventaja = abs($snapshot->jugador1-$snapshot->jugador2);
            array_push($snapshots, $snapshot);
        }
        //var_dump($snapshots);
        return $snapshots;
    }

    public function obtenLaVentajaMaxima($snapshots){
        echo "<br>buscando la ventaja maxima <br>"; 
        var_dump($snapshots);
        $ventajaMaxima = $snapshots[0];
        for($i = 0;$i<count($snapshots);$i++){
            $snapshotsActual = $snapshots[$i];
            if($snapshotsActual->ventaja > $ventajaMaxima->ventaja){
                $ventajaMaxima = $snapshotsActual;
            }
        
        }
        return $ventajaMaxima;
    }

    public function almacenaArchivoSalida($archivoDeSalida, $snapshotMaximo){
        
        $myfile = fopen($archivoDeSalida, "w") or die("No se puede abrir el archivo!");
        
        fwrite($myfile, $snapshotMaximo->lider . " " . $snapshotMaximo->ventaja);
        fclose($myfile);
    }
}
