function validateCorreo (e){
    var exprecion_validadora_de_correo = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    var bolean_validate = exprecion_validadora_de_correo.test(e.target.value);

    if (!bolean_validate){
        Swal.fire({
            title: 'Error!',
            text: 'Por favor agrega un correo electronico valido',
            confirmButtonText: 'Cerrar'
        })
    }

}