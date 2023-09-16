$(document).on('click', '.editar_plantel', function (e){
    e.preventDefault();
    let form = new FormData();
    form.append("bandera","get_info_plantel");
    form.append("db",$(this).val());
    fetch('./recurso.php',{
        method: "POST",
        body: form
    }).then(res => res.json()).then(res => {
        let c_g = '';
        for (let i = 0; i<Object.keys(res['carr_gru']).length; i++){
            if (i < (Object.keys(res['carr_gru']).length-1))
                c_g += res['carr_gru'][i]+"\n";
            else
                c_g += res['carr_gru'][i]
        }
        $("#carreras_grupos").html(c_g);
    });
})