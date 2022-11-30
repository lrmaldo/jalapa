let tabla;

$(document).ready(function () {
    tabla = $("#tabla_giros")
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
                url: url_get,
                /*  dataSrc: "", */
            },
            columns: [
                { data: "id" },
                { data: "nombre" },
                { data: "is_active" },

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

const agregarGiro = () => {
    Swal.fire({
        title: "Agregar Giro",
        html: ` <div class="">
        <p>Agrega Giro (Categoria)</p>
        </div>
        <div class="">
        <div class="md:w-full">
        <!-- nombre -->
        <label for="nombre">Nombre</label>
        <input class="rounded-md shadow-sm mt-1 w-full" type="text" 
          id="nombre" name="nombre" value="" placeholder="Ejemplo. Restaurantes">
        </div>
        </div>
        <div class="md:w-full mt-1">
        <label for="is_whatsapp">¿Activar?</label>
        <input class="rounded-md y-2" type="checkbox" value="1" id="is_active" name="is_active">
        </div>
        `,
        showCancelButton: true,
        confirmButtonText: "Agregar",
        cancelButtonText: "Cancelar",
        showCloseButton: true,
        showLoaderOnConfirm: true,

        preConfirm: () => {
            let _url_store = "/giros";
            let nombre = document.querySelector("#nombre");
            let is_active = document.querySelector("#is_active");
            /* validaciones */
            if (nombre.value == "") {
                Swal.showValidationMessage("El nombre es requerido");
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
                    nombre: nombre.value,
                    is_active: is_active.checked,
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
            tabla.ajax.reload();
        }
    });
};

const edit_giro = (id) => {
    const _url_edit = `/giros/${id}/edit`;

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
                title: "Editar Teléfono",
                html: ` <div class="">
            <p>Editar Giro (Categoria)</p>
            </div>
            <div class="">
            <div class="md:w-full">
            <!-- telefono -->
            <label for="nombre">Nombre</label>
            <input class="rounded-md shadow-sm mt-1 w-full" type="text" 
              id="nombre" name="nombre" value="${
                  data.nombre
              }" placeholder="Ejemplo. Restaurantes">
            </div>
            </div>
            <div class="md:w-full mt-1">
            <label for="is_whatsapp">¿Activar?</label>
            <input class="rounded-md y-2" type="checkbox" value="1" id="is_active" name="is_active"
            ${data.is_active ? "checked" : ""}>
            </div>
            `,
                showCancelButton: true,
                confirmButtonText: "Agregar",
                cancelButtonText: "Cancelar",
                showCloseButton: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    /* validacion */
                    let _url_update = `/telefonos/${id}`;
                    let nombre = document.querySelector("#nombre");
                    let is_active = document.querySelector("#is_active");
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
                            is_active: is_active.checked,
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
};


const eliminar_giro = (id) =>{
    const _url_delete = `/giros/${id}`
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
            tabla.ajax.reload();
        }
    });
}