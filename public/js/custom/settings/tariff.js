(function ($) {
    "use strict";
    let tariffDatatable = null;
    let $return;
    $(document).ready(function () {
        tariffDatatable = $("#tariffDatatable").DataTable({
            dom: '<"row"<"col-12 col-sm-6"l><"col-12 col-sm-6"f>><"row"<"col-12 col-sm-12"t><"col-12 col-sm-6"i><"col-12 col-sm-6"p>>',
            lengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "All"],
            ],
            buttons: [],
            columns: [
                {
                    title: "#SL",
                    data: "id",
                    class: "no-sort",
                    width: "50px",
                    // render: function (data, row, type, col) {
                    //     var pageInfo = tariffDatatable.page.info();
                    //     return col.row + 1 + pageInfo.start;
                    // },
                },
                { title: "Name", name: "name", data: "name" },
                { title: "Type", name: "category.type", data: "category.type" },
                { title: "Quartier", name: "Quartier", data: "quartier.quartier_name" },
                { title: "ParkZone", name: "parkzone", data: "parkzone.name" },
                { title: "Start Date", name: "start_date", data: "start_date" },
                { title: "End Date", name: "end_date", data: "end_date" },
                { title: "Per Hour", name: "amount", data: "amount" },
                { title: "Total Amount", name: "total_amount", data: "total_amount" },
                { title: "Shadow Amount", name: "shadow_amount", data: "shadow_amount" },
                { title: "Number of Hours", name: "number_hour", data: "number_hour" },

                


                {
                    title: "Status",
                    name: "status",
                    data: "status",
                    render: function (data, type, row) {
                        return data == 1 ? "Enable" : "Disable";
                    },
                },
                {
                    title: "Option",
                    data: "id",
                    class: "text-end width-5-per",
                    render: function (data, type, row, col) {
                        var editURL = route("tariff.edit", { tariff: data });
                        var delURL = route("tariff.destroy", { tariff: data });
                        $return = `<a href="`+editURL+`"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Tariff"></i></a> | 
                            <button class="btn btn-link p-0" onclick="deleteData('`+delURL+`', \'#tariffDatatable\')"><i class="fs-6 fa fa-trash text-danger" aria-hidden="true" title="Delete Category"></i></button>`
                        return $return;
                    },
                },
            ],

            ajax: {
                url: route("tariff.index"),
                dataSrc: "data",
            },

            language: {
                paginate: {
                    next: "&#8594;", // or '→'
                    previous: "&#8592;", // or '←'
                },
            },
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: [0, 2, 7,8],
                },
            ],
            responsive: true,
            autoWidth: false,
            serverSide: true,
            processing: true,
        });
    });
})(jQuery);
