$(document).on('click', '.logout', function () {
    Swal.fire({
        title: 'Desea continuar?',
        showDenyButton: true,
        showCancelButton: true,
        showConfirmButton: false,
        confirmButtonText: 'Save',
        denyButtonText: `Cerrar Sessión`,
    }).then((result) => {
        /*if (result.isConfirmed) {
            Swal.fire('Saved!', '', 'success')
        } else */
        if (result.isDenied) {
            Swal.fire({
                title: 'Cerrando sessión',
                html: '<div style="overflow: hidden;"><div class="loader-spin"></div></div>'

            });
            setTimeout(function () {
                window.location.replace("../recursos/funciones/logout.php");
            }, 3000);
        }
    })
});