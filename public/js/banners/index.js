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
            order:[[0,'desc']],
            language: lenguaje,
        })
        .columns.adjust()
        .responsive.recalc();
});
