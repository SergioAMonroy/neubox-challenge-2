<?php

/**
 * Clase con el control de apertura y validación del archivo de entrada.
 */
class archivoEntradaCtrl {

    private $partidas;
    private $marcadores = [];

    /**
     * Función que lee el archivo y llena el bean con los datos del archivo cuando se ha validado el archivo.
     * @param String $nombreArchivo La ruta al archivo de entrada
     * @return \challenge1Bean 
     */
    public function leeArchivo($nombreArchivo) {
        $arrayLineas = file($nombreArchivo);
        try {
            $validadasLineas = $this->validaLineas($arrayLineas);
        } catch (Exception $ex) {
            throw $ex;
        }

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
        try {
            $validadasLineas = $this->validaPrimerLineaEntrada(trim($arrayLineas[0]));
            for ($i = 1; $i < $conteoArrayLineas; $i++) {
                $validadasLineas = $validadasLineas && $this->validaSegundasLineasEntrada(trim($arrayLineas[$i]));
            }
            if($this->partidas != count($this->marcadores)){
                throw new Exception('La cantidad de partidas no corresponde con el numero de marcadores en el archivo ' . $this->partidas . ' != ' .count($this->marcadores));
            }
        } catch (Exception $ex) {
            throw $ex;
        }

        return $validadasLineas;
    }

    /**
     * Valida y en caso de terminar de manera correcta asigna los valores de la linea 1 a las propiedades de la clase.
     * @param String $lineaUno el valor encontrado en la primer línea del archivo de inicio.
     * @return boolean El valor de si pasó las validaciones del archivo.
     * @throws Exception
     */
    private function validaPrimerLineaEntrada($lineaUno) {
        $limiteInferiorPartidas = 1;
        $limiteSuperiorPartidas = 10000;

        $partidas = trim($lineaUno);


        if (preg_match('/[^0-9]/', $partidas)) {
            throw new Exception('El elemento n no es una cadena de números');
        }
        $n = (int) $partidas;

        if ($n<$limiteInferiorPartidas) {
            throw new Exception('El número de partidas no está dentro de los límites');
        }
        if ($n > $limiteSuperiorPartidas) {
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
        $marcador->marcador1 = (int) $arrayElementosLinea[0];
        $marcador->marcador2 = (int) $arrayElementosLinea[1];

        array_push($this->marcadores, $marcador);
        return true;
    }

}
