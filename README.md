# neubox-challenge-2
La challenge 2 de Neubox
Existe un juego en el que hay dos jugadores y varias rondas en los que cada jugador obtiene
una puntuación. Al final de cada ronda se observa el acumulado de la puntuación y la
diferencia. Al terminar el juego quien gana es aquel que haya conseguido la mayor ventaja
Por ejemplo esto pudiera ser el marcador de 5 rondas:

Este es un ejemplo con el marcador acumulado al final de cada ronda y la ventaja obtenida.


1 140 82 Jugador1 58
2 229 216 Jugador1 13
3 319 326 Jugador2 7
4 431 432 Jugador2 1
5 519 522 Jugador2 3


El ganador en este caso sería el Jugador 1 ya que el obtuvo la máxima ventaja (58) al final de
la primera ronda durante el juego.

El programa recibe los marcadores y deberá indicar el ganador (no hay empates, se puede
asumir siempre existe un ganador único)

Formato de Entrada

● La entrada al programa es un archivo de texto que consiste en varias líneas.
o La primer línea es un entero menor o igual a 10000 indicando el número de
rondas
o Después hay una línea por ronda con los marcadores de los dos jugadores

Ejemplo

Entrada
5
140 82
89 134
90 110
112 106
88 90


Formato de Salida

● La salida del programa es un archivo que contiene una línea
o Esta línea contiene dos enteros, el primer entero es 1 o 2 indicando quien fue
el ganador, y el segundo entero es la ventaja con la que gana ese jugador

1 58
