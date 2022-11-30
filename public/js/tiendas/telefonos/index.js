let tabla;

$(document).ready(function () {
    tabla = $("#tabla_telefonos")
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
                { data: "tipo" },
                { data: "telefono" },
                { data: "is_whatsapp" },

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

const add_telefono = () => {
    Swal.fire({
        title: "Agregar Teléfono",
        html: ` <div class="">
            <p>Agrega un telefono a esta tienda</p>
              
            <div class="md:w-full">
            <label for="tipo">Tipo</label>
            <select class="rounded-md shadow-sm mt-1 w-full" style="width: 100% !important" id="tipo" name="tipo">
                <option selected disabled>Seleccionar</option>
                <option value="fijo" >Fijo </option>
                <option value="celular" >Celular </option>
            </select>
            </div>
            </div>
            <div class="">
            <div class="md:w-full">
            <!-- telefono -->
            <label for="telefono">Teléfono</label>
            <input class="rounded-md shadow-sm mt-1 w-full" type="text" maxlength="10"
            onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode &gt;= 48 && event.charCode &lt;= 57"
              id="telefono" name="telefono" value="" placeholder="10 digitos">
            </div>
            </div>
            <div class="md:w-full mt-1">
            <label for="is_whatsapp">Es Whatsapp</label>
            <input class="rounded-md y-2" type="checkbox" value="1" id="is_whatsapp" name="is_whatsapp">
            </div>
            `,
        didOpen: function () {
            console.log("precargar select2");
        },
        showCancelButton: true,
        confirmButtonText: "Agregar",
        cancelButtonText: "Cancelar",
        showCloseButton: true,
        showLoaderOnConfirm: true,

        preConfirm: () => {
            /* validacion */
            let _url_store = "/telefonos";
            let tipo = document.querySelector("#tipo").value;
            let telefono = document.querySelector("#telefono");
            let is_whatsapp = document.querySelector("#is_whatsapp").checked;

            if (tipo.trim() == "Seleccionar") {
                Swal.showValidationMessage("Elige un tipo de teléfono");
                return false;
            }
            if (telefono.value == "") {
                Swal.showValidationMessage("El telefono es requerido");
                return false;
            }
            if (telefono.value.length < 10) {
                Swal.showValidationMessage(
                    "El teléfono debe ser igual a 10 digitos"
                );
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
                    tipo: tipo,
                    telefono: telefono.value,
                    is_whatsapp: is_whatsapp,
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
            tabla.ajax.reload();
        }
    });
};

/* editar telefono  */
const edit_telefono = (id) => {
    const _url_edit = `/telefonos/${id}/edit`;

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
            <p>Agrega un telefono a esta tienda</p>
              
            <div class="md:w-full">
            <label for="tipo">Tipo</label>
            <select class="rounded-md shadow-sm mt-1 w-full" style="width: 100% !important" id="tipo" name="tipo">
                <option selected disabled>Seleccionar</option>
                <option value="fijo" ${
                    data.tipo == "fijo" ? "selected" : ""
                }>Fijo </option>
                <option value="celular" ${
                    data.tipo == "celular" ? "selected" : ""
                }>Celular </option>
            </select>
            </div>
            </div>
            <div class="">
            <div class="md:w-full">
            <!-- telefono -->
            <label for="telefono">Teléfono</label>
            <input class="rounded-md shadow-sm mt-1 w-full" type="text" maxlength="10"
            onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode &gt;= 48 && event.charCode &lt;= 57"
              id="telefono" name="telefono"  placeholder="10 digitos" value="${
                  data.telefono
              }">
            </div>
            </div>
            <div class="md:w-full mt-1">
            <label for="is_whatsapp">Es Whatsapp</label>
            <input class="rounded-md y-2" type="checkbox" value="1" id="is_whatsapp" name="is_whatsapp" ${
                data.is_whatsapp ? "checked" : ""
            } >
            </div>
            `,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar",
                showCloseButton: true,
                showLoaderOnConfirm: true,

                preConfirm: () => {
                    /* validacion */
                    let _url_update = `/telefonos/${id}`;
                    let tipo = document.querySelector("#tipo").value;
                    let telefono = document.querySelector("#telefono");
                    let is_whatsapp =
                        document.querySelector("#is_whatsapp").checked;

                    if (tipo.trim() == "Seleccionar") {
                        Swal.showValidationMessage("Elige un tipo de teléfono");
                        return false;
                    }
                    if (telefono.value == "") {
                        Swal.showValidationMessage("El telefono es requerido");
                        return false;
                    }
                    if (telefono.value.length < 10) {
                        Swal.showValidationMessage(
                            "El teléfono debe ser igual a 10 digitos"
                        );
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
                            tipo: tipo,
                            telefono: telefono.value,
                            is_whatsapp: is_whatsapp,
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


const eliminar_telefono = (id) =>{
    const _url_delete = `/telefonos/${id}`
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