let tabla;

$(document).ready(function () {
    tabla = $("#tabla_tiendas")
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
                { data: "categoria" },
                { data: "tipo" },
                { data: "estatus" },

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

eliminar = (id) => {
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
            return fetch("/tiendas/" + id, {
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
                    title: "Se ha eliminado la tienda correctamente",
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
                "Ocurrio un problema, no se ha podido eliminar la tienda correctamente",
                error,
                "error"
            );
        });
};
