(function ($) {
    "use strict";
    let floorDatatableEl = null;
    let $return;
    $(document).ready(function () {
        floorDatatableEl = $("#floorDatatable").DataTable({
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
                    render: function (data, row, type, col) {
                        var pageInfo = floorDatatableEl.page.info();
                        return col.row + 1 + pageInfo.start;
                    },
                },
                { title: "Name", name: "name", data: "name" },
                { title: "Level", name: "level", data: "level" },
                { title: "Remarks", name: "remarks", data: "remarks" },
                {
                    title: "Status",
                    name: "status",
                    data: "status",
                    render: function (data, type, row) {
                        return data == 1 ? "Active" : "Inactive";
                    },
                },
                {
                    title: "Option",
                    data: "id",
                    class: "text-end width-5-per",
                    render: function (data, type, row, col) {
                        var editURL = route("floors.edit", { floor: data });
                        var delURL = route("floors.destroy", { floor: data });
                        var statusURL = route("floors.status_changes", {
                            floor: data,
                        });
                        if (row.status == 1) {
                            $return =
                                '<a href="' +
                                statusURL +
                                '"><i class="fa fa-window-close-o text-danger" aria-hidden="true" title="Deactivate"></i></a> | ';
                        } else {
                            $return =
                                '<a href="' +
                                statusURL +
                                '"><i class="fa fa-check text-info" aria-hidden="true" title="Active"></i></a> | ';
                        }
                        $return +=
                            '<a href="' +
                            editURL +
                            '"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Floor"></i></a>';

                        $return += '| <button class="btn btn-link p-0" onclick="deleteData(\'' + delURL +'\', \'#floorDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Floor"></i></button>';

                        return $return;
                    },
                },
            ],

            ajax: {
                url: route("floors.index"),
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
                    targets: [0, 3, 4, 5],
                },
            ],
            responsive: true,
            autoWidth: false,
            serverSide: true,
            processing: true,
        });
    });
})(jQuery);
