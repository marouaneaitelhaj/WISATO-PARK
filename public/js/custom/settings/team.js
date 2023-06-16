(function ($) {
    "use strict";

    let teamDataTable = null;
    let $return;
    $(document).ready(function () {
        teamDataTable = $("#teamDataTable").DataTable({
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
                { title: "operator", name: "operator", data: "operator_user.name" },
                { title: "agent", name: "agent", data: "agent_user.name" },
                {
                    title: "status",
                    name: "status",
                    data: "status",
                },
                {
                    title: "remark",
                    name: "remark",
                    data: "remark",
                },
                {
                    title: "id_camera",
                    name: "id_camera",
                    data: "operator_user.id_camera",
                },
                {
                    title: "serial_number",
                    name: "serial_number",
                    data: "operator_user.serial_number",
                }
            ],

            ajax: {
                url: route("team.index"),
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
                    searchable: true,
                    orderable: false,
                    targets: [0, 3, 4],
                },
            ],
            responsive: true,
            autoWidth: false,
            serverSide: true,
            processing: true,
        });
    });

})(jQuery);