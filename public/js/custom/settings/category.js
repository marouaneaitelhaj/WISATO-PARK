(function ($) {
    "use strict";

    let categoryDatatable = null;
    let $return;
    $(document).ready(function () {
        categoryDatatable = $("#categoryDatatable").DataTable({
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
                    //     var pageInfo = categoryDatatable.page.info();
                    //     return col.row + 1 + pageInfo.start;
                    // },
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
                    render: function (data, type, row, col) {
                        let deleteUrl = route('category.destroy', { 'category': data });
                        $return = '<a href="' + route('category.edit', { 'category': data })+'"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Category"></i></a>';
                        $return += '| <button class="btn btn-link p-0" onclick="deleteData(\''+deleteUrl+'\', \'#categoryDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Category"></i></button>';
                        return $return;
                    },
                },
            ],

            ajax: {
                url: route("category.index"),
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
