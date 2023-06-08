(function ($) {
    "use strict";

    let sideDatatable = null;
    let $return;
    $(document).ready(function () {
        sideDatatable = $("#sideDatatable").DataTable({
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
                },
                { title: "Type", name: "type", data: "type" },
                { title: "Description", name: "description", data: "description" },
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
                },
            ],

            ajax: {
                url: route("side.index"),
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
                    targets: [0,3, 4],
                },
            ],
            responsive: true,
            autoWidth: false,
            serverSide: true,
            processing: true,
        });
    });
    
})(jQuery);
