<script>
            $(document).ready(function () {
                $('#efectivo').on('keyup', function () {
                    if ($('#efectivo').val() > 0) {
                        if ((parseFloat($('#efectivo').val()) < parseFloat($('#totalinput').val())) || (parseInt($('#efectivo').val().length) >= (parseInt($('#totalinput').val()).length))) {
                            var subtotal = parseFloat($('#totalinput').val()) - parseFloat($('#efectivo').val());
                            $('#message').html('<div class="alert alert-warning flash-msg">Le falta <strong>$' + parseFloat(subtotal) + '</strong> para completar su pago</div>');
                            $('.flash-msg').delay(5000).fadeOut('slow');
                            $("#cambio").css("background-color", "#FFFFFF");
                            $('#cambio').val(parseFloat(subtotal));
                        } else {
                            var pago = parseFloat($('#efectivo').val()) - parseFloat($('#totalinput').val());
                            $('#message').html('<div class="alert alert-success flash-msg">Su cambio es: <strong>$' + parseFloat(pago) + '</strong></div>');
                            $('.flash-msg').delay(5000).fadeOut('slow');
                            $("#cambio").css("background-color", "#FFFFFF");
                            $('#cambio').val(parseFloat(pago));
                        }
                    } else {
                        $('#message').html('<div class="alert alert-danger flash-msg">Ingrese un valor mayor a cero</div>');
                        $('.flash-msg').delay(5000).fadeOut('slow');
                        //$("#cambio").css("background-color", "#FFFFFF");
                    }
                });
            });
        </script>