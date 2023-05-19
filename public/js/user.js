(function ($) {
    "use strict";
    var userDataTable = null;
    $(document).ready(function () {
        userDataTable = $("#userDataTable").DataTable({
            dom: '<"ptb20"><"row"<"col-md-4 col-12"l><"#userDataTableSearch.col-md-4 col-12"><"col-md-4 col-12"f>>t<"row"<"col-md-6 col-12"i><"col-md-6 col-12"p>>',
            scrollX: true,
            initComplete: function () {
                $("#userDataTableSearch").append(
                    '<div class="dataTableBtnWrap flL">' +
                        '<select class="form-control" id="userDataTableFilterStatus">' +
                        '<option value="">All User</option>' +
                        '<option value="1">Active</option>' +
                        '<option value="0">Deactive</option>' +
                        "</select>" +
                        "</div>"
                );
            },
            processing: true,
            serverSide: true,
            columns: [
                {
                    data: "id",
                    name: "sl",
                    class: "no-sort",
                    title: "#SL",
                    render: function (data, type, row, ind) {
                        var pageInfo = userDataTable.page.info();
                        return ind.row + 1 + pageInfo.start;
                    },
                },
                {
                    data: "name",
                    name: "name",
                    title: "Name",
                    render: function (data, type, row, index) {
                        return data;
                    },
                },
                {
                    data: "email",
                    name: "email",
                    title: "Email",
                    render: function (data, type, row, index) {
                        return data;
                    },
                },
                {
                    data: "Phone",
                    name: "Phone",
                    title: "Phone Number",
                    render: function (data, type, row, index) {
                        return data;
                    },
                },
                {
                    data: "roles",
                    name: "roles",
                    title: "Roles",
                    render: function (data, type, row, index) {
                        var roleHTML = "";
                        for (let role of data) {
                            roleHTML += role.name.toUpperCase() + "<br>";
                        }

                        return roleHTML;
                    },
                },
                {
                    data: "status",
                    title: "Status",
                    render: function (data, type, row) {
                        return data == 1 ? "Active" : "Deactive";
                    },
                },
                {
                    data: "id",
                    name: "id",
                    class: "text-end",
                    title: "Action",
                    render: function (data, type, row, index) {
                        var statusText;

                        if (row.status) {
                            statusText = "Deactivate the user";
                        } else {
                            statusText = "Activate the user";
                        }

                        return (
                            '<a href="' +
                            route("user.status", { user: data }) +
                            '" title="' +
                            statusText +
                            '">Change Status</a> | ' +
                            '<a href="' +
                            route("user.edit", { user: data }) +
                            '">Edit</a>'
                        );
                    },
                },
            ],
            ajax: {
                url: route("userListJson"),
                dataSrc: "data",
                data: function (d) {
                    d.status = $("#userDataTableFilterStatus").val();
                },
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

    $(document).on("change", "#userDataTableFilterStatus", function () {
        userDataTable.draw();
    });
})(jQuery);
