function getplantel(p){
    let form = new FormData();
    form.append('plantel',p);
    form.append('bandera','consulta_docentes');
    fetch('./recurso.php', {
        method: 'POST',
        cache: "no-cache",
        body: form
    }).then(res => res.json())
        .then(res => {
            if (res === 1){
                $("#docentes").DataTable({
                    language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                    "processing": true,
                    "serverSide": true,
                    "destroy": true,
                    "sAjaxSource": "./SS/docentes_vista.php",
                    "columnDefs":[
                        {
                            targets: [0],
                            render: function (data, type, row){
                                return '<input class="m-auto" type="checkbox" name="seleciones[]">'
                            }
                        },
                        {
                            targets: [1],
                            render: function (data, type, row){ <!-- +row[2]+','+row[3]+','+row[1]+','+row[4]+','+row[0]+ -->
                                return '<span>'+row[0]+' '+row[1]+' '+row[2]+'</span>';
                            }
                        },
                        {
                            targets: [2],
                            render: function (data, type, row){
                                return '<span>'+row[3]+'</span>'
                            }
                        },
                        {
                            targets: [3],
                            render: function (data, type, row){
                                return row[4]
                            }
                        },
                        {
                            targets: [4],
                            render: function (data, type, row){
                                return row[5]
                            }
                        },
                        {
                            targets: [5],
                            render: function (data, type, row){
                                return row[6]
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
                                return row[8]
                            }
                        },
                        {
                            targets: [-1],
                            render: function (data, type, row){
                                return '<span class="boton-p" data-bs-toggle="modal" data-bs-target="#editar"><img src="../../recursos/img/svg/edit.svg" alt="editar" width="32"></span>' +
                                    '<span class="boton-p" data-bs-toggle="modal" data-bs-target="#foto"><img src="../../recursos/img/svg/camera.svg" alt="foto" width="32"></span>' +
                                    '<span class="boton-p" data-bs-toggle="modal" data-bs-target="#codigo"><img src="../../recursos/img/svg/code.svg" alt="codigo" width="32"></span>' +
                                    '<span class="boton-p" data-bs-toggle="modal" data-bs-target="#imprimir"><img src="../../recursos/img/svg/print.svg" alt="impresion" width="32"></span>' +
                                    '<span class="boton-p" data-bs-toggle="modal" data-bs-target="#CA">CA</span>' +
                                    '<span class="boton-p" data-bs-toggle="modal" data-bs-target="#eliminar"><img src="../../recursos/img/svg/delete.svg" alt="eliminar" width="32"></span>'
                            }
                        }
                    ]
                });
            }
        });
}