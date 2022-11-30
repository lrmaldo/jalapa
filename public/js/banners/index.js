let tabla;

$(document).ready(function () {
    tabla = $("#tabla_banners")
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
                { data: "imagen" },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
                /* {data: 'updated_at'} */
            ],
            order: [[0, "desc"]],
            language: lenguaje,
        })
        .columns.adjust()
        .responsive.recalc();
});

const addBanner = () => {
    Swal.fire({
        title: "Agregar Banner",
        html: `<div class="md:w-full"><!-- input file photo banner -->
        <label for="banner">banner</label>
        <input type="file" class="rounded-md shadow-sm mt-1 w-full" id="imagen_url" name="imagen_url"  accept="image/*" placeholder="Ingresa el banner" autocomplete="off">
        </div>`,
        showCancelButton: true,
        confirmButtonText: "Guardar Banner",
        cancelButtonText: "Cancelar",
        showCloseButton: true,
        showConfirmButton: true,
        confirmButtonColor: "#00a8ff",

        showLoaderOnConfirm: true,
        preConfirm:()=>{
            let file = $("#imagen_url")[0].files[0];
            let _url_store =  "/banners"
            if(document.getElementById('imagen_url').files.length == 0){
                Swal.showValidationMessage("Es requerido una imagen");
                return false;
            }
            let formData  = new FormData()
            formData.append('imagen_url',file);
            return fetch(_url_store,{
                method:'POST',
                headers:{
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                },
                body:formData,

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
};


const edit_banner = (id) =>{
    Swal.fire({
        title: "Editar Banner",
        html: `<div class="md:w-full"><!-- input file photo banner -->
        <label for="banner">banner</label>
        <input type="file" class="rounded-md shadow-sm mt-1 w-full" id="imagen_url" name="imagen_url"  accept="image/*" placeholder="Ingresa el banner" autocomplete="off">
        </div>`,
        showCancelButton: true,
        confirmButtonText: "Guardar Banner",
        cancelButtonText: "Cancelar",
        showCloseButton: true,
        showConfirmButton: true,
        confirmButtonColor: "#00a8ff",

        showLoaderOnConfirm: true,
        preConfirm:()=>{
            let file = $("#imagen_url")[0].files[0];
            let _url_update =  "/banners/"+id;
            if(document.getElementById('imagen_url').files.length == 0){
                Swal.showValidationMessage("Es requerido una imagen");
                return false;
            }
            let formData  = new FormData()
            formData.append('_method','PUT')
            formData.append('imagen_url',file);
            console.log(file);
            return fetch(_url_update,{
                method:'POST',
                headers:{
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),

                },
                body:formData,

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

const eliminar_banner = (id) =>{
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
            return fetch("/banners/" + id, {
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
                    title: "Se ha eliminado el banner correctamente",
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