$(document).on('click', '.login', function (e) {
    $("#form_login").validate({
        rules:{
            escuela: "required",
            usuario: "required",
            pwd: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            escuela: "Por favor, seleccione su plantel",
            usuario: "Por favor, introduzca su usuario",
            pwd: {
                required: "Por favor proporcione una contraseña",
                minlength: "Su contraseña debe tener al menos 5 caracteres."
            }
        },
        submitHandler: function() {
            e.preventDefault();
            let form = new FormData(document.getElementById('form_login'));
            fetch('./recurso.php', {
                method: 'POST',
                cache: 'no-cache',
                mode: 'cors',
                body: form
            }).then(res => res.json())
                .then(res => {
                    if (res === "error"){
                        Swal.fire({
                            icon: 'error',
                            title: 'Ha ocurrido un error',
                            text: 'Por favor, verifique sus datos'
                        });
                    }
                    else if (res === "valido") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Entrando a tu cuenta',
                            showConfirmButton: false,
                            html: '<div style="overflow:hidden;"><div class="loader-spin"></div></div>'
                        });
                        setTimeout(function () {
                            window.location.replace("./admin/");
                        }, 3000);
                    }
                });
        }
    });

})