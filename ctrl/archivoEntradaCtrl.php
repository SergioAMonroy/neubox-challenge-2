<?php

/**
 * Clase con el control de apertura y validación del archivo de entrada.
 */
class archivoEntradaCtrl {
    private $partidas;
    private $marcadores = [];

    /**
     * Lunción que lee el archivo y llena el bean con los datos del archivo cuando se ha validado el archivo.
     * @param String $nombreArchivo La ruta al archivo de entrada
     * @return \challenge1Bean 
     */
    public function leeArchivo($nombreArchivo) {
        $arrayLineas = file($nombreArchivo);
        //var_dump($arrayLineas);

        $validadasLineas = $this->validaLineas($arrayLineas);
        //echo "lineas validadas ". $validadasLineas;
        if ($validadasLineas) {
            $bean = new challenge2Bean();
            $bean->partidas = $this->partidas;
            $bean->marcadores = $this->marcadores;
            return $bean;
        }
    }

    /**
     * Aplica las reglas de validación de las líneas al array de cadenas del archivo
     * @param Array $arrayLineas Un array con las líneas del archivo de entrada
     * @return Boolean Con las validaciones por línea acumuladas.
     */
    private function validaLineas($arrayLineas) {
        
        $conteoArrayLineas = count($arrayLineas);
        //echo "numero de lineas en array ". $conteoArrayLineas; 
        $validadasLineas = $this->validaPrimerLineaEntrada(trim($arrayLineas[0]));
        for($i = 1; $i<$conteoArrayLineas; $i++){
            //echo "<br>validando marcadores";
            $validadasLineas = $validadasLineas && $this->validaSegundasLineasEntrada(trim($arrayLineas[$i]));
        }
        $validadasLineas = $validadasLineas && $this->partidas == count($this->marcadores);
        return $validadasLineas;
    }

    /**
     * Valida y en caso de terminar de manera correcta asigna los valores de la linea 1 a las propiedades de la clase.
     * @param String $lineaUno el valor encontrado en la primer línea del archivo de inicio.
     * @return boolean El valor de si pasó las validaciones del archivo.
     * @throws Exception
     */
    private function validaPrimerLineaEntrada($lineaUno) {
        
        $limiteSuperiorPartidas = 10000;

        $partidas = trim($lineaUno);


        if (preg_match('/[^0-9]/', $partidas)) {
            throw new Exception('El elemento no es una cadena de números');
        }
        //echo "Valor de partidas " . $partidas;
        $n = (int) $partidas;

        if ($n > $limiteSuperiorPartidas) {
           // echo "El número de partidas no está dentro de los límites";
            throw new Exception('El número de partidas no está dentro de los límites');
        }
        $this->partidas = $n;
        return true;
    }

    /**
     * Valida los datos de las líneas de marcadores del archivo
     * @param type $linea
     * @return boolean
     * @throws Exception
     */
    private function validaSegundasLineasEntrada($linea) {
        $numeroElementosEnLinea = 2;

        $arrayElementosLinea = explode(" ", $linea);
        //echo "<br>Elementos en linea ".count($arrayElementosLinea);
        
        if (count($arrayElementosLinea) != $numeroElementosEnLinea) {
            throw new Exception('Elementos de linea  de resultados no coinciden con especificación');
        }

        if (preg_match('/[^0-9]/', $arrayElementosLinea[0])) {
            throw new Exception('La linea no cumple con los requerimientos de caracteres');
        }
        if (preg_match('/[^0-9]/', $arrayElementosLinea[1])) {
            throw new Exception('La línea no cumple con los requerimientos de caracteres');
        }

        $marcador = new marcadoresBean();
        $marcador->marcador1= (int)$arrayElementosLinea[0];
        $marcador->marcador2= (int)$arrayElementosLinea[1];
        
        array_push($this->marcadores, $marcador);
        return true;
    }

}
