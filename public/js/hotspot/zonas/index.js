let tabla;

$(document).ready(function () {
    tabla = $("#tabla_zonas")
        .DataTable({
            columnDefs: [
                {
                    targets: [0,-1],
                    className: 'dt-body-center'
                }
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
                { data: "nombre" },
                { data: "preview" },
                

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

agregarZona = () =>{
    Swal.fire({
        title: "Agregar Zona",
        html: `
        <div class="">
        <div class="md:w-full">
        <!-- nombre -->
        <label for="nombre">Nombre</label>
        <input class="rounded-md shadow-sm mt-1 w-full" type="text" 
          id="nombre" name="nombre" value="" placeholder="Ejemplo. Hotspot Centro">
        </div>
        </div>
        `,
        showCancelButton: true,
        confirmButtonText: "Guardar Zona",
        cancelButtonText: "Cancelar",
        showCloseButton: true,
        showConfirmButton: true,
        confirmButtonColor: "#00a8ff",

        showLoaderOnConfirm: true,
        preConfirm:()=>{
            //let file = $("#imagen_url")[0].files[0];
            let _url_store =  "/zonas"
            let nombre = document.getElementById("nombre")
            if(document.getElementById('nombre').value == ""){
                Swal.showValidationMessage("Es requerido un nombre");
                return false;
            }

            
            return fetch(_url_store,{
                method:'POST',
                headers:{
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    nombre: nombre.value,
                    //is_active: is_active.checked,
                }),

            }).then((response)=>{
                if(!response.ok){
                    return Swal.showValidationMessage(
                        `${response.statusText}`
                    );
                }
                return response.json();
            });

        }
    }).then((result)=>{
        if(result.value){
            Swal.fire({
                icon: "success",
                title: result.value.message,
                showConfirmButton: false,
                timer: 1500,

            })
            tabla.ajax.reload();
        }
    }).catch((error)=>{
        console.log(error);
        Swal.showValidationMessage(`Request failed: ${error}`);
        return false;
    })

}

edit_zona =(id)=>{
    const _url_edit = `/zonas/${id}/edit`;

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
                title: "Editar Zona",
                html: ` 
            <div class="">
            <div class="md:w-full">
            <!-- telefono -->
            <label for="nombre">Nombre</label>
            <input class="rounded-md shadow-sm mt-1 w-full" type="text" 
              id="nombre" name="nombre" value="${
                  data.nombre
              }" placeholder="Ejemplo. Hostpot Centro">
            </div>
            </div>
            `,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar",
                showCloseButton: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    /* validacion */
                    let _url_update = `/zonas/${id}`;
                    let nombre = document.querySelector("#nombre");
        
                    /* validaciones */
                    if (nombre.value == "") {
                        Swal.showValidationMessage("El nombre es requerido");
                    }
                    return fetch(_url_update, {
                        method: "PUT",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            nombre: nombre.value,
                           
                        }),
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

}



eliminar_zona = (id) => {
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
            return fetch("/zonas/" + id, {
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
            });
        },
    })
        .then((result) => {
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
        })
        .catch((error) => {
            Swal.fire(
                "Ocurrio un problema, no se ha podido eliminar la zona correctamente",
                error,
                "error"
            );
        });
};
