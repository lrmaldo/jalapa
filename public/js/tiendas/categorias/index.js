let tabla_categorias;

$(document).ready(function () {
    tabla_categorias = $("#tabla_categorias")
        .DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            aLengthMenu: [
                [5, 10, 25, 50, 100, 200, -1],
                [5, 10, 25, 50, 100, 200, "Todos"],
            ],
            iDisplayLength: 10,
            ajax: {
                url: url_get_categorias,
                /*  dataSrc: "", */
            },
            columns: [
                { data: "id" },
                { data: "nombre" },
                

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

const add_categoria = () => {
    Swal.fire({
        title: "Agregar Teléfono",
        html: ` 
            <div class="">
            <div class="md:w-full">
            <!-- nombre -->
            <label for="nombre">Nombre de la categoria</label>
            <input class="rounded-md shadow-sm mt-1 w-full" type="text" 
              id="nombre" name="nombre" value="" placeholder="">
            </div>
            </div>
           
            `,
        didOpen: function () {
            /* console.log("precargar select2"); */
        },
        showCancelButton: true,
        confirmButtonText: "Agregar",
        cancelButtonText: "Cancelar",
        showCloseButton: true,
        showLoaderOnConfirm: true,

        preConfirm: () => {
            /* validacion */
            let _url_store = "/tienda-categorias";
            let nombre = document.querySelector("#nombre");
            

            
            if (nombre.value == "") {
                Swal.showValidationMessage("El nombre es requerido");
                return false;
            }
            

            return fetch(_url_store, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    nombre:nombre.value,
                    tienda_id: tienda_id,
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
                    Swal.showValidationMessage(`Request failed: ${error}`);
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
            tabla_categorias.ajax.reload();
        }
    });
};

/* editar telefono  */
const edit_categoria = (id) => {
    const _url_edit = `/tienda-categorias/${id}/edit`;

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
                title: "Editar Categoria",
                html: `
            <div class="">
            <div class="md:w-full">
            <!-- telefono -->
            <label for=nombre">Nombre de la categoria</label>
            <input class="rounded-md shadow-sm mt-1 w-full" type="text" 
              id="nombre" name="nombre"  placeholder="Articulos " value="${
                  data.nombre
              }">
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
                    let _url_update = `/tienda-categorias/${id}`;
                   
                    let nombre = document.querySelector("#nombre");
                   
                    if (nombre.value == "") {
                        Swal.showValidationMessage("El nombre es requerido");
                        return false;
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
                            
                           nombre:nombre.value,
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
                    tabla_categorias.ajax.reload();
                }
            });
        });
};


const eliminar_categoria = (id) =>{
    const _url_delete = `/tienda-categorias/${id}`
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminarlo!",
        cancelButtonText: "Cancelar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(_url_delete, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    "Content-Type": "application/json",
                },
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
                    Swal.showValidationMessage(`Request failed: ${error}`);
                });
        },
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                icon: "success",
                title: result.value.message,
                showConfirmButton: false,
                timer: 1500,
            });
            tabla_categorias.ajax.reload();
        }
    });
}