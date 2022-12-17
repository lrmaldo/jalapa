let tabla_productos;

$(document).ready(function () {
    tabla_productos = $("#tabla_productos")
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
                url: url_get_productos,
                /*  dataSrc: "", */
            },
            columns: [
                { data: "id" },
                { data: "imagen"},
                { data: "estatus" },
                { data: "nombre" },
                { data: "precio" },
                { data: "categoria" },

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

const add_producto = () => {
    Swal.fire({
        title: "Agregar producto o servicio",
        html: ` 
            <div class="">
            <div class="md:w-full">
            <!-- nombre -->
            <label for="nombre">Nombre de producto</label>
            <input class="rounded-md shadow-sm mt-1 w-full" type="text" 
              id="nombre" name="nombre" value="" placeholder="Ejem. sombrero">
            </div>
            <div class="md:w-full">
            <!-- descripcion -->
            <label for="descripcion">Descripción</label>
            <textarea class="rounded-md shadow-sm mt-1 w-full" type="text" 
              id="descripcion" name="descripcion"  placeholder="Describe el producto o servicio"></textarea>
            </div>
            <div class="md:w-full">
            <!-- categoria -->
            <label for="categoria_id">Categoria</label>
            <select class="rounded-md shadow-sm mt-1 w-full" type="text" 
              id="categoria_id" name="categoria_id">
              <option selected disabled>Seleccionar Categoria</option>
            </select>
            </div>
            <div class="md:w-full">
            <!-- existencia -->
            <label for="existencia">Existecia</label>
            <input class="rounded-md shadow-sm mt-1 w-full" type="number"  step="1" min="0" pattern="[0-9]{10}"
            oninput="this.value = this.value.replace(/[^0-9.]/g, ''); "
              id="existencias" name="existencias" value="" placeholder="Este campo puede estar vacio">
            </div>
            <div class="md:w-full">
            <!-- precio -->
            <label for="precio">Precio</label>
            <input class="rounded-md shadow-sm mt-1 w-full" type="number"  step="0.01" min="0"
              id="precio" name="precio" value="" placeholder="Escribe el precio">
            </div>
            </div>
            <div class="md:w-full">
            <!-- precio -->
            <label for="precio">Imagen</label>
            <input class="rounded-md shadow-sm mt-1 w-full" type="file" accept="image/*"  
              id="imagen_url" name="imagen_url" value="" placeholder="Escribe el precio">
            </div>
            </div>
           
            `,

        /* 'nombre',
        'descripcion',
        'existencias',
        'precio',
        'imagen_url',
        'is_active',
        'categria_id',
        'tienda_id', */
        didOpen: function () {
            console.log('cargar select de categorias en productos')
            

                const categorias  = async ()=>{
                   const response =  await fetch(`/api/tienda/${tienda_id}/categorias/all`)
                   const categoriasData = await response.json();
                   // console.log(categoriasData);
                    return categoriasData.map(function(data){
                        console.log(data);
                        $("#categoria_id").append(
                            `<option value="${data.id}">${data.nombre}</option>`
                        )
                    })
                }
                categorias()
                /* categorias.then(function(data){
                    console.log(data);
                }) */
                 
                //console.log('categorias',categorias);

          /*   categorias.forEach((categoria)=>{
               
            }) */
        },
        showCancelButton: true,
        confirmButtonText: "Agregar",
        cancelButtonText: "Cancelar",
        showCloseButton: true,
        showLoaderOnConfirm: true,

        preConfirm: () => {
            /* validacion */
            let _url_store = "/tienda-producto";
            let nombre = document.querySelector("#nombre"),descripcion= document.querySelector("#descripcion"), existencias = document.querySelector("#existencias"), precio = document.querySelector("#precio"), categoria_id = document.querySelector("#categoria_id");
           

            let imagen_url = $("#imagen_url")[0].files[0];

            if (nombre.value == "") {
                Swal.showValidationMessage("El nombre es requerido");
                return false;
            }
            if(precio.value == ""){
                Swal.showValidationMessage("El precio es requerido")
                return false;
            }
            if(document.getElementById('imagen_url').files.length==0){
                Swal.showValidationMessage('Es requerido una imagen');
                return false;
            }
            if(categoria_id.value == ""){
                Swal.showValidationMessage("La categoria es requerido");
                return false;
            }


            /*  formData */
            let formData = new FormData();
            formData.append('nombre', nombre.value);
            formData.append('descripcion',descripcion.value);
            formData.append('existencias',existencias.value);
            formData.append('categoria_id',categoria_id.value);
            formData.append('precio', precio.value);
            formData.append('imagen_url',imagen_url)
            formData.append('tienda_id',tienda_id);
           

            return fetch(_url_store, {
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
            tabla_productos.ajax.reload();
        }
    });
};

/* editar telefono  */
const edit_producto = (id) => {
    const _url_edit = `/tienda-producto/${id}/edit`;

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
                title: "Editar producto",
                html: `
                <div class="">
                <div class="md:w-full mt-1">
                <label for="is_active">¿Activar?</label>
                <input class="rounded-md y-2" type="checkbox" value="1" id="is_active" name="is_active" ${data.is_active? 'checked' :''}>
                </div>
                <div class="md:w-full">
                <!-- nombre -->
                <label for="nombre">Nombre de producto</label>
                <input class="rounded-md shadow-sm mt-1 w-full" type="text" 
                  id="nombre" name="nombre" value="${data.nombre}" placeholder="Ejem. sombrero">
                </div>
                <div class="md:w-full">
                <!-- descripcion -->
                <label for="descripcion">Descripción</label>
                <textarea class="rounded-md shadow-sm mt-1 w-full" type="text" 
                  id="descripcion" name="descripcion"  placeholder="Describe el producto o servicio">${data.descripcion}</textarea>
                </div>
                <div class="md:w-full">
                <!-- categoria -->
                <label for="categoria_id">Categoria</label>
                <select class="rounded-md shadow-sm mt-1 w-full" type="text" 
                  id="categoria_id" name="categoria_id">
                  <option selected disabled>Seleccionar Categoria</option>
                </select>
                </div>
                <div class="md:w-full">
                <!-- existencia -->
                <label for="existencia">Existecia</label>
                <input class="rounded-md shadow-sm mt-1 w-full" type="number"  step="1" min="0" pattern="[0-9]{10}"
                oninput="this.value = this.value.replace(/[^0-9.]/g, ''); "
                  id="existencias" name="existencias" value="${data.existencias}" placeholder="Este campo puede estar vacio">
                </div>
                <div class="md:w-full">
                <!-- precio -->
                <label for="precio">Precio</label>
                <input class="rounded-md shadow-sm mt-1 w-full" type="number"  step="0.01" min="0"
                  id="precio" name="precio" value="${data.precio}" placeholder="Escribe el precio">
                </div>
                </div>
                <div class="md:w-full">
                <!-- precio -->
                <label for="precio">Imagen</label>
                <input class="rounded-md shadow-sm mt-1 w-full" type="file" accept="image/*"  
                  id="imagen_url" name="imagen_url" value="" placeholder="Escribe el precio">
                </div>
                </div>
            `,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar",
                showCloseButton: true,
                showLoaderOnConfirm: true,
                didOpen: function () {
                    console.log('cargar select de categorias en productos')
                    
        
                        const categorias  = async ()=>{
                           const response =  await fetch(`/api/tienda/${tienda_id}/categorias/all`)
                           const categoriasData = await response.json();
                           // console.log(categoriasData);
                            return categoriasData.map(function(categoria){
                                console.log(categoria);
                                $("#categoria_id").append(
                                    `<option value="${categoria.id}" ${categoria.id == data.categoria_id ? 'selected': ""} >${categoria.nombre}</option>`
                                )
                            })
                        }
                        categorias()
                     
                },

                preConfirm: () => {
                    /* validacion */
                    let _url_update = `/tienda-producto/${id}`;

                    let nombre = document.querySelector("#nombre"),descripcion= document.querySelector("#descripcion"), existencias = document.querySelector("#existencias"), precio = document.querySelector("#precio"), categoria_id = document.querySelector("#categoria_id"), is_active = document.querySelector("#is_active");

                    let imagen_url = $("#imagen_url")[0].files[0];
        
                    if (nombre.value == "") {
                        Swal.showValidationMessage("El nombre es requerido");
                        return false;
                    }
                    if(precio.value == ""){
                        Swal.showValidationMessage("El precio es requerido")
                        return false;
                    }
                 /*    if(document.getElementById('imagen_url').files.length==0){
                        Swal.showValidationMessage('Es requerido una imagen');
                        return false;
                    } */
                    if(categoria_id.value == ""){
                        Swal.showValidationMessage("La categoria es requerido");
                        return false;
                    }
        
        
                    /*  formData */
                    let formData = new FormData();
                    formData.append('_method','PUT');
                    formData.append('nombre', nombre.value);
                    formData.append('descripcion',descripcion.value);
                    formData.append('existencias',existencias.value);
                    formData.append('categoria_id',categoria_id.value);
                    formData.append('precio', precio.value);
                    formData.append('imagen_url',imagen_url)
                    formData.append('tienda_id',tienda_id);
                    formData.append('is_active', is_active.value);

                    return fetch(_url_update, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                          
                        },
                        body:formData,
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
                    tabla_productos.ajax.reload();
                }
            });
        });
};

const eliminar_producto = (id) => {
    const _url_delete = `/tienda-producto/${id}`;
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
            tabla_productos.ajax.reload();
        }
    });
};
