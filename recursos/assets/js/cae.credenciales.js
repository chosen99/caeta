/*$(document).on("click", ".consulta_n2", function (e){
    e.preventDefault();
    if ($("#grupo_nuevos").val() !== null){
        $('#grupo_nuevos').val(false);
    }
})

$(document).on("click",".consulta_n",function (){
    $("#nuevos").validate({
        rules:{
            plantel_nuevos: "required",
            grupo_nuevos: "required"
        },
        messages: {
            plantel_nuevos: "Por favor, seleccione su plantel",
            grupo_nuevos: "Por favor, seleccione un grupo",
        },
        submitHandler: function() {
            $("#nu").css("display","block");
        }
    });
}); */

$(document).ready(function () {
    w3.includeHTML(init);
});


function getplantel(p){
    let form = new FormData();
    form.append('plantel',p);
    form.append('bandera','consulta_alumnos');
    fetch('./recurso.php', {
        method: 'POST',
        cache: "no-cache",
        body: form
    }).then(res => res.json())
        .then(res => {
            if (res === 1){
                $("#nu").css("display", "block")
                $("#alumnos").DataTable({
                    language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                    "processing": true,
                    "serverSide": true,
                    "destroy": true,
                    "sAjaxSource": "./SS/alumnos_vista_credenciales.php",
                    "columnDefs":[
                        {
                            targets: [0],
                            render: function (data, type, row){
                                return '<input class="m-auto" type="checkbox" value="'+row[10]+'" name="seleciones[]">'
                            }
                        },
                        {
                            targets: [1],
                            render: function (data, type, row){
                                return '<div class="tooltip_foto"><span class="nombre_tabla'+row[10]+'">'+row[0]+' '+row[1]+' '+row[2]+'</span><span class="tooltiptext"><div class="row"><div class="col-6"><img src="https://images.freeimages.com/images/previews/ac9/railway-hdr-1361893.jpg" alt="foto-" width="100"></div><div class="col-6 text-start"><span style="font-size: 8pt;">Cel alumno: <span class="num1'+row[10]+'">'+row[11]+'</span><br>Cel padre 1: <span class="num2'+row[10]+'">'+row[12]+'</span><br>Cel padre 2: <span class="num3'+row[10]+'">'+row[13]+'</span></span></div></div></span></div>';
                            }
                        },
                        {
                            targets: [2],
                            render: function (data, type, row){
                                return '<span class="Matricula'+row[10]+'">'+row[3]+'</span>'
                            }
                        },
                        {
                            targets: [3],
                            render: function (data, type, row){
                                return '<span class="CURP'+row[10]+'">'+row[4]+'</span>'
                            }
                        },
                        {
                            targets: [4],
                            render: function (data, type, row){
                                return '<span class="Grupo'+row[10]+'">'+row[5]+'</span>'
                            }
                        },
                        {
                            targets: [5],
                            render: function (data, type, row){
                                return '<span class="Espe'+row[10]+'">'+row[6]+'</span>'
                            }
                        },
                        {
                            targets: [6],
                            render: function (data, type, row){
                                return row[7]
                            }
                        },
                        {
                            targets: [7],
                            render: function (data, type, row){
                                return '<span class="Gene'+row[10]+'">'+row[8]+'</span>'
                            }
                        },
                        {
                            targets: [8],
                            render: function (data, type, row){
                                let edo_cred = '';
                                if (row[9] === "Sin"){
                                    edo_cred = '<button class="btn btn-sm btn-danger" style="width: 32px; height: 32px; border-radius: 50%;">S</button>';
                                }else if(row[9] === "Rep"){
                                    edo_cred = '<button class="btn btn-sm btn-info" style="width: 32px; height: 32px; border-radius: 50%;">R</button>';
                                }else {
                                    edo_cred = '<button class="btn btn-sm btn-success" style="width: 32px; height: 32px; border-radius: 50%;">C</button>';
                                }
                                return edo_cred;
                            }
                        },
                        {
                            visible: false,
                            targets: [9]
                        },
                        {
                            visible: false,
                            targets: [10]
                        },
                        {
                            visible: false,
                            targets: [11]
                        },
                        {
                            visible: false,
                            targets: [12]
                        },
                        {
                            targets: [-1],
                            render: function (data, type, row){
                                return '<button class="clase_edita" style="border: none; background: none;" value="'+row[10]+'" data-bs-toggle="modal" data-bs-target="#editar"><img src="../recursos/img/svg/edit.svg" alt="editar" width="32"></button>' +
                                       '<span class="boton-p" data-bs-toggle="modal" data-bs-target="#foto"><img src="../recursos/img/svg/camera.svg" alt="foto" width="32"></span>' +
                                       '<button class="clase_edita_codigo" style="border: none; background: none;" value="'+row[10]+'" data-bs-toggle="modal" data-bs-target="#editar-codigo"><img src="../recursos/img/svg/code.svg" alt="codigo" width="32"></button>' +
                                       '<span class="boton-p" data-bs-toggle="modal" data-bs-target="#imprimir"><img src="../recursos/img/svg/print.svg" alt="impresion" width="32"></span>' +
                                       '<span class="boton-p" data-bs-toggle="modal" data-bs-target="#CA">CA</span>' +
                                       '<span class="boton-p" data-bs-toggle="modal" data-bs-target="#eliminar"><img src="../recursos/img/svg/delete.svg" alt="eliminar" width="32"></span>'
                            }
                        }
                    ]
                });
            }
        });
}

$(document).on('click', '.elimina_foto_alumno', function (e){
    e.preventDefault();
    Swal.fire({
        title: '¿Estas seguro de querer eliminar esta foto?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: 'SI',
    }).then((result) => {
        if (result.isConfirmed) {
            let form = new FormData();
            form.append("bandera","elimina_foto");
            form.append("id", $("#id_save").val());
            fetch("./recurso.php",{
                method: "POST",
                cache: "no-cache",
                body: form
            }).then(res => res.json()).then(res => {
                if (res === "correcto"){
                    $("#get_fo").attr('src','');
                    Swal.fire('Saved!', '', 'success');
                }
            });
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })
});
$(document).on('click', '.elimina_firma_alumno', function (e){
    e.preventDefault();
    Swal.fire({
        title: '¿Estas seguro de querer eliminar esta firma?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: 'SI',
    }).then((result) => {
        if (result.isConfirmed) {
            let form = new FormData();
            form.append("bandera","elimina_firma");
            form.append("id", $("#id_save").val());
            fetch("./recurso.php",{
                method: "POST",
                cache: "no-cache",
                body: form
            }).then(res => res.json()).then(res => {
                if (res === "correcto"){
                    $("#get_fi").attr('src','');
                    Swal.fire('Saved!', '', 'success');
                }
            });
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })
});

$(document).on('click', '.clase_edita', function (){
    let id = $(this).val();
    let form = new FormData();
    form.append('bandera','get_info_edita_alumno');
    form.append('id', id);
    fetch('./recurso.php',{
        method: 'POST',
        body: form
    }).then(res => res.json()).then(res =>{
        if(res['Matricula'] !== ""){
            $('#Grupo option').remove();
            for (let i = 0; i < Object.keys(res['grupos']).length; i++){
                $("#Grupo").append(new Option(res['grupos'][i], res['grupos'][i]));
            }

            $("#id_save").val(res['alumno']['id']);
            $("#matri").val(res['alumno']['Matricula']);
            $("#AP").val(res['alumno']['AP']);
            $("#AM").val(res['alumno']['AM']);
            $("#Nombre").val(res['alumno']['Nombre']);
            $("#CURP").val(res['alumno']['CURP']);
            $('#Grupo').val(res['alumno']['Grupo']);
            $("#Especialidad").val(res['alumno']['Especialidad']);
            $("#Generacion").val(res['alumno']['Generacion']);
            $("#Cel_alumno").val(res['alumno']['Cel_alumno']);
            $("#Cel_p1").val(res['alumno']['Cel_padre1']);
            $("#Cel_p2").val(res['alumno']['Cel_padre2']);
            $("#get_fo").attr('src', res['alumno']['Foto']);
            $("#get_fi").attr('src', res['alumno']['Firma']);
            /*$("#get_fo").val(res['Foto']);
            $("#get_fi").val(res['Firma']);*/
        }
    });
});
$(document).on('click', '.clase_edita_codigo', function (e){
    e.preventDefault();
    let id = $(this).val();
    let form = new FormData();
    form.append("id", id);
    form.append("bandera", "consulta_codigos");
    fetch('./recurso.php', {
        method: "POST",
        cache: "no-cache",
        body: form
    }).then(res => res.json()).then(res => {
        $("#code_1").val(res['Codigo']);
        $("#code_2").val(res['CodigoStick']);
        $("#code_3").val(res['CodigoKey']);
        $("#nombre_editando").html(res['Nombre']+" "+res['AP']+" "+res['AM']);
        $('#boton_guarda_codigos').val(id);
    })
});

$(document).on('click', '.save_update', function (e){
    $('#editar').modal('toggle');
    e.preventDefault();
    let form = new  FormData(document.getElementById('edita_alumno'));
    form.append('bandera','seve_update')
    fetch('./recurso.php',{
        method: 'POST',
        body: form
    }).then(res => res.json()).then(res => {
        $('.nombre_tabla'+res).html($("#AP").val()+ ' ' + $("#AM").val()+' '+$("#Nombre").val())
        $('.Matricula'+res).html($("#matri").val())
        $('.Curp'+res).html($("#CURP").val())
        $('.Grupo'+res).html($("#Grupo").val())
        $('.Espe'+res).html($("#Especialidad").val())
        $('.Gene'+res).html($("#Generacion").val())
        $('.num1'+res).html($("#Cel_alumno").val())
        $('.num2'+res).html($("#Cel_p1").val())
        $('.num3'+res).html($("#Cel_p2").val())
        Swal.fire({
            title: 'Su información se ha guardado correctamente.',
            showDenyButton: false,
            showConfirmButton: false,
            timer: 1500
        });
        /*setTimeout(() => {
            Swal.close();
        }, "1500");*/
    });
});

$(document).on('click', '.sube-masivo', function (e){
    e.preventDefault();
    let form = new FormData(document.getElementById('excel_alumnos'));
    form.append('bandera','up_masivo');
    fetch('./recurso.php',{
        method: "POST",
        body: form
    }).then(res => res.json()).then(res => {
        Swal.fire({
            showConfirmButton: false,
            html: '<div class="loader">Loading...</div>'
        });
        if (res['estado'] === "subido"){
            Swal.close();
            $('#carga-masiva').modal('toggle');
            Swal.fire({
                icon: 'success',
                showConfirmButton: false,
                html: '<div>Se han cargado '+res['total']+' Alumnos</div>'
            });
        }
    });

})

$(document).on('click', '.save_codes', function (){
    let id = $(this).val();
    let form = new FormData(document.getElementById('edita_codigos'));
    form.append("id", id);
    form.append("bandera", "edita_codigos");
    fetch('./recurso.php', {
        method: "POST",
        cache: "no-cache",
        body: form
    }).then(res => res.json()).then(res => {
        if (res === "echo"){
            Swal.fire({
                icon: 'success',
                showConfirmButton: false,
                title: 'Se han modificado correctamente',
                timer: 2000
            });
        }else{
            Swal.fire({
                icon: 'info',
                showConfirmButton: false,
                title: 'Codigo duplicado',
                timer: 2000
            });
        }
    });
});


/*
RETOMAR CAMARA
getCameraSelection();
    const updatedConstraints = {
        ...constraints,
        deviceId: {
            exact: cameraOptions.value
        }
    };
    startStream(updatedConstraints);
*/


// ********************************************************************************

/*carga_foto.onchange = evt => {
    const [file] = carga_foto.files;
    if (file){
        get_fo.src = URL.createObjectURL(file);
    }
}

carga_firma.onchange = evt => {
    const [file] = carga_firma.files;
    if (file){
        get_fi.src = URL.createObjectURL(file);
    }
}*/

function actualiza(imgprev){
    if (imgprev === "get_fo"){
        get_fo.src=URL.createObjectURL(event.target.files[0]);
    }
    else if(imgprev === "get_fi"){
        get_fi.src=URL.createObjectURL(event.target.files[0]);
    }
}

function update_carrera(grupo){
    let form = new FormData();
    form.append("bandera","set_carrera");
    form.append("grupo", grupo)
    fetch("./recurso.php",{
        method: "POST",
        body: form
    }).then(res => res.json()).then(res => {
        $("#Especialidad").val(res)
    });
}