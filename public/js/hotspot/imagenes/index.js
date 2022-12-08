let tabla;

$(document).ready(function () {
    tabla = $("#tabla_imagenes")
        .DataTable({
            columnDefs: [
                {
                    targets: [0, -1],
                    className: "dt-body-center",
                },
            ],
            responsive: true,
            processing: true,
            serverSide: true,
            aLengthMenu: [
                [5, 10, 25, 50, 100, 200, -1],
                [5, 10, 25, 50, 100, 200, "Todos"],
            ],
            iDisplayLength: 10,
            ajax: {
                url: url_get,
                /*  dataSrc: "", */
            },
            columns: [
                { data: "id" },
                {data:'estatus'},
                { data: "imagen" },
                { data: "zonas" },

                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
                /* {data: 'updated_at'} */
            ],
            language: lenguaje,
            order: [[0, "desc"]],
        })
        .columns.adjust()
        .responsive.recalc();
});

agregarImagen = () => {
    event.preventDefault();
    event.stopPropagation();
    Swal.fire({
        title: "Agregar Imagen",
        html: ` <div class="md:w-full">
        <label for="imagen">Selecciona una imagen</label>
        <input id="imagen" type="file" accept="image/*"  class="rounded-md shadow-sm mt-1 w-full" placeholder="Nombre para identificar al Mikrotik" />
        
    </div>
    
    <div class="md:w-full">
    <label for="zonas">Zonas disponibles para esta publicidad</label>
    <select class="rounded-md shadow-sm mt-1 w-full" style="width: 100% !important" id="zonas" name="zonas[]"  multiple="multiple"></select>
    </div>`,
        showCancelButton: true,
        confirmButtonText: "Agregar Imagen",
        cancelButtonText: "Cancelar",
        showLoaderOnConfirm: true,
        showCloseButton: true,
        didOpen: function () {
            console.log("precargar select2");

            $(document).ready(function () {
                let data = $.map(zonas, function (obj) {
                    obj.id = obj.id;
                    obj.text = obj.text || obj.nombre;
                    return obj;
                });
                console.log("data", data);
                $("#zonas").select2({
                    data: data,
                });
            });

            $(".select2-dropdown").css({
                "margin-top": "0 !important",
                "line-height": "1.5rem !important",
            });
        },
        preConfirm: () => {
            let _url_store = "/imagen-hotspot";
            let file = $("#imagen")[0].files[0];
            let zonas_selected = $("#zonas").val();
            if (document.getElementById("imagen").files.length == 0) {
                Swal.showValidationMessage("Es requerido una imagen");
                return false;
            }
            if (zonas_selected.length == 0) {
                Swal.showValidationMessage("Es requerido una o más zonas");
                return false;
            }

            let formData = new FormData();
            formData.append("imagen", file);
            formData.append("zonas", zonas_selected);

            return fetch(_url_store, {
                method: "POST",
                headers: {
                    /*  'Accept':'application/json',
                    'Content-Type':'application/json', */
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: formData,
            }).then((response) => {
                if (!response.ok) {
                    return Swal.showValidationMessage(`${response.statusText}`);
                }
                return response.json();
            });
        },
    })
        .then((result) => {
            if (result.value) {
                Swal.fire({
                    icon: "success",
                    title: result.value.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
                tabla.ajax.reload();
            }
        })
        .catch((error) => {
            console.log(error);
            Swal.showValidationMessage(`Request failed: ${error}`);
            return false;
        });
};

edit_imagen = (id) => {
    const _url_edit = `/imagen-hotspot/${id}/edit`;

    let loading = Swal.fire({
        title: "Cargando",
        html: "<strong>Espere por favor...</strong>",
        allowOutsideClick: false,
        showLoading: true,
        timerProgressBar: true,
        showConfirmButton: false,
        didOpen: function () {
            Swal.showLoading();
        },
    });
    fetch(_url_edit)
        .finally(() => {
            loading.then((result) => {
                Swal.close();
            });
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error(response.statusText);
            }
            return response.json();
        })
        .then((data) => {
            Swal.fire({
                title: "Editar Imagen",
                html: ` <div class="md:w-full">
                <label for="imagen">Selecciona una imagen</label>
                <input id="imagen" type="file" accept="image/*"  class="rounded-md shadow-sm mt-1 w-full" placeholder="" />
                
            </div>
            <div class="md:w-full mt-1">
            <label for="is_active">¿Activar?</label>
            <input class="rounded-md y-2" type="checkbox" value="1" id="is_active" name="is_active"
            ${data.is_active ? "checked" : ""}>
            </div>
            
            <div class="md:w-full">
            <label for="zonas">Zonas disponibles para esta publicidad</label>
            <select class="rounded-md shadow-sm mt-1 w-full" style="width: 100% !important" id="zonas" name="zonas[]"  multiple="multiple"></select>
            </div>`,

                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar",
                showCloseButton: true,
                showLoaderOnConfirm: true,
                didOpen:function(){
                    $(document).ready(function () {
                       // console.log('zonas',zonas)
                        let data_select = $.map(zonas,function (obj) {
                            obj.id = obj.id;
                            obj.text = obj.text || obj.nombre;
                            obj.selected = data.zonas.find(element => element.id === obj.id)?true:false ;
                            return obj
                        })
                        
                        $("#zonas").select2({
                            data:data_select
                        });
                    });
                },
                preConfirm: () => {
                    /* validacion */
                    let file = $("#imagen")[0].files[0];
                    let zonas_selected = $("#zonas").val();
                    let is_active =  document.querySelector("#is_active")
                   /*  if (document.getElementById("imagen").files.length == 0) {
                        Swal.showValidationMessage("Es requerido una imagen");
                        return false;
                    } */
                    if (zonas_selected.length == 0) {
                        Swal.showValidationMessage("Es requerido una o más zonas");
                        return false;
                    }
        
                    let formData = new FormData();
                    formData.append('_method','PUT')
                    formData.append("imagen", file);
                    formData.append("zonas", JSON.stringify(zonas_selected));
                    formData.append('is_active',is_active.checked )

                    let _url_update = "/imagen-hotspot/"+id;
                    return fetch(_url_update, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                            
                        },
                        body: formData,
                    })
                        .then((response) => {
                            if (!response.ok) {
                                console.log(response);
                                throw new Error(response.statusText);
                            }
                            return response.json();
                        })
                        .catch((error) => {
                            console.log(error);
                            Swal.showValidationMessage(
                                `Request failed: ${error}`
                            );
                        });
                },
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: result.value.message,
                        text: "",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    tabla.ajax.reload();
                }
            });
        });
};


eliminar_imagen  = (id) =>{
    Swal.fire({
        title: "¿Estas seguro en eliminar?",
        text: "Una vez que lo elimines no hay vuelta atrás",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, borrar!",
        cancelButtonText: "Cancelar",
        showCloseButton: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch("/imagen-hotspot/" + id, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    "Content-Type": "application/json",
                },
            }).then((response) => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error(response.statusText);
            })
            .catch((error) => {
                Swal.showValidationMessage(error)
            })
        },
    })
        .then((result) => {
            if (result.value) {
                Swal.fire({
                    title: result.value.message,
                    text: "",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 2000,
                });
                tabla.ajax.reload();
            }
        })
        .catch((error) => {
            Swal.fire(
                "Ocurrio un problema, no se ha podido eliminar el banner correctamente",
                error,
                "error"
            );
        });  
}