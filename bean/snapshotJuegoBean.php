<?php

class snapshotJuegoBean{
    public $round;
    public $jugador1;
    public $jugador2;
    public $lider;
    public $ventaja;

    public function __construct(){
        $this->round = 0;
        $this->jugador1 = 0;
        $this->jugador2 = 0;
        $this->lider = 0;
        $this->ventaja = 0;
    }
}
