function validaArchivoAEnviar() {
    console.log("Validando que el archivo esté lleno para validarlo");
    const archivo = document.getElementById("archivo").files[0];

    if (archivo === undefined) {
        muestraModal("Seleccione el archivo antes de enviar a analizar");
        return;
    }
    console.log("El archivo seleccionado es", archivo);
    enviaArchivoAValidar(archivo);
}

function enviaArchivoAValidar(archivo) {
    const formData = new FormData();
    document.getElementById("botonAnalizar").disabled = true;
    document.getElementById("cargando").style.visibility = "visible" ;

    formData.append('archivo', archivo);

    fetch('convertidor.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())        
        .then(result => {
            document.getElementById("botonAnalizar").disabled = false;
            document.getElementById("cargando").style.visibility = "hidden" ;
            console.log('Exito:', result);
            if(result.mensaje !== 'Exito'){
                muestraModal('Error:'+ result.mensaje);
            }else{
                alert("Conversión correcta del archivo, en seguida le llevará a la dirección de descarga");
                window.open("subidas/salida.txt", "_blank");
            }
        })
    .catch(error => {
        document.getElementById("botonAnalizar").disabled = false;
        document.getElementById("cargando").style.visibility = "hidden" ;
        muestraModal('Error:'+ error);
    });

}

function muestraModal(mensaje) {
    const pMensaje = document.getElementById("mensajeModal").innerHTML = mensaje;
    $('#dialogoMensaje').modal();
}
console.log("ocultando el gif de carga");
document.getElementById("cargando").style.visibility = "hidden" ;
console.log(document.getElementById("cargando"));