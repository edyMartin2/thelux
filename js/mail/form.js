$(document).ready(function () {

    $('form').submit(function (event) {
        var valMail = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
        var valMoney = /^[0-9\.\,]/;
        $('#Alert').css({ 'color': 'white' }).html('');
        var numeros = ['Lada', 'Telefono', 'Extension'], mail = ['Email', 'Correo'], moneda = ['Costo'];
        var css = { "border": "1px solid red", "selected": "selected" };
        var form = $("form input, select, textarea").css({ "border": "1px solid " });
        // var count = form.length;
        var envia = true;
        $('input[type="submit"]').attr("disabled", true);
        form.each(function (i) {
            if ($(this).val() != "") {
                if ($(this).attr('money')) {
                    if (isNaN($(this).val())) {
                        $('input[name="' + $(this).attr('name') + '"]').focus();
                        $('input[name="' + $(this).attr('name') + '"]').css(css);
                        $('#Alert').html('El campo debe ser númerico y con dos decimales.');
                        $('input[type="submit"]').attr("disabled", false);
                        envia = false;
                        return false;
                    }
                } else
                    if ($(this).attr('number')) {
                        if (isNaN($(this).val())) {
                            $('input[name="' + $(this).attr('name') + '"]').focus();
                            $('input[name="' + $(this).attr('name') + '"]').css(css);
                            $('#Alert').html('El campo debe ser númerico.');
                            $('input[type="submit"]').attr("disabled", false);
                            envia = false;
                            return false;
                        }
                    } else
                        if ($(this).attr('correo')) {
                            if (!valMail.test($(this).val())) {
                                $('input[name="' + $(this).attr('name') + '"]').focus();
                                $('input[name="' + $(this).attr('name') + '"]').css(css);
                                $('#Alert').html('El campo debe tener el formato de un correo electrónico.');
                                $('input[type="submit"]').attr("disabled", false);
                                envia = false;
                                return false;
                            }
                        }
            } else if ($(this).val() == "" && $(this).attr('required')) {
                $('input[name="' + $(this).attr('name') + '"]').focus();
                $('input[name="' + $(this).attr('name') + '"]').css(css);
                $('select[name="' + $(this).attr('name') + '"]').css(css);
                $('select[name="' + $(this).attr('name') + '"]').focus();
                $('#Alert').html('El campo es obligatorio.');
                $('input[type="submit"]').attr("disabled", false);
                envia = false;
                return false;
            }
        });
        var datos = $('form input, select, textarea').serialize();
        event.preventDefault();
        if (envia == true) {
            $('#Alert').addClass('icon fa-envelope').html(' Enviando mensaje...');
            $.ajax({
                type: 'POST',
                url: './Mailer/send/index.php',
                data: datos,
                dataType: 'jsonp',
                jsonp: 'callback',
                success: function (jsonp) {
                    if (jsonp == 1) {
                        $('form').css({ 'align-items': 'center', 'display': 'flex', 'justify-content': 'center' });
                        $('form').html('<center class="icon fa-envelope" style="margin-bottom:50px;"><br>Se ha enviado.<br><br>¡Gracias por tu mensaje!</center>');
                    } else {
                        $('#Alert').removeClass();
                        $('#Alert').css({ 'color': 'white' }).html('Se encontro un problema al procesar la información.');
                        $('input[type="submit"]').attr("disabled", false);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(this);
                    console.log(error);
                    $('#Alert').removeClass();
                    $('#Alert').css({ 'color': 'white' }).html('Ocurrio un problema al procesar la información.');
                    $('input[type="submit"]').attr("disabled", false);
                }
            });
        }
    });

    /**/
});
