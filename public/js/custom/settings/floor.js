(function ($) {
    "use strict";

    let floorDataTable = null;
    let $return;
    $(document).ready(function () {
        floorDataTable = $("#floorDataTable").DataTable({
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
                { title: "parkzone", name: "parkzone", data: "parkzone.name" },
                { title: "Level", name: "level", data: "level" },
                { title: "shadow", name: "shadow", data: "shadow" },
                { title: "active", name: "status", data: "status" },
                { 
                    title: "showfloorslots",
                    data: null,
                    render: function (data, type, row) {
                        return (
                            '<button class="btn btn-primary" onclick="showfloorslots(\'' +
                            row.id +
                            "')\">Show Floor Slots</button>"
                        );
                    }
                },
                {
                    title: "Actions",
                    data: null,
                    render: function (data, type, row) {
                        return (
                            '<button class="btn btn-primary" onclick="createSlots(\'' +
                            row.id +
                            "')\">Create Slots</button>"
                        );
                    }
                }
            ],
            ajax: {
                url: route("floor.index"),
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
                    targets: [0, 2],
                },
            ],
            responsive: true,
            autoWidth: false,
            serverSide: true,
            processing: true,
        });
    });
})(jQuery);

var cat = [];

function createSlots(parkzoneId) {
    var html = "";
    for (var i = 0; i < cat.length; i++) {
        var category = cat[i];

        html +=
            '<div class="m-1"> <input type="number" class="form-control" placeholder="' + category.type + '" name="categorie_id_' + category.id + '"> </div>';
    }

    Swal.fire({
        title: "Create Floor",
        html:
            '<div class="form-group">' +
            '<form id="createFloorForm">' +
            '<label for="category_id" class="text-md-right">Category<span class="tcr text-danger">*</span></label>' +
            '<div class="d-flex flex-wrap justify-content-center">' +
            html +
            "</div>" +
            "<form />" +
            "</div>",
        showCancelButton: true,
        cancelButtonText: "Cancel",
        confirmButtonText: "Create",
        focusConfirm: false,
        preConfirm: () => {
            const form = document.getElementById('createFloorForm');
            const formData = new FormData(form);

            // Construct the data object
            const data = {
                floor_id: parkzoneId,
                categories: [],
                name: '',
            };

            // Iterate over form data entries
            for (const [name, value] of formData.entries()) {
                if (name.startsWith('categorie_id_')) {
                    const categoryId = name.split('categorie_id_')[1];
                    const slotCount = parseInt(value) || 0; // Parse the input value as an integer
                    for (let j = 0; j < slotCount; j++) {
                        data.categories.push({
                            category_id: categoryId,
                            floor_id: parkzoneId,
                        });
                    }
                } else {
                    data[name] = value;
                }
            }

            // Send the request to the server
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
            fetch("floorslots", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify(data),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .then(responseData => {
                    Swal.fire({
                        title: "Slot Created",
                        text: responseData.message,
                        icon: "success",
                        confirmButtonText: "Ok",
                    }).then(() => {
                        // Refresh the page or perform any other desired action
                        location.reload();
                    });
                })
                .catch(error => {
                    Swal.fire({
                        title: "Error",
                        text: "Failed to create slot: " + error.message,
                        icon: "error",
                        confirmButtonText: "Ok",
                    });
                });
        },
    });
}



function readcat() {
    fetch("read/cat", {
        method: "GET",
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText);
            }
            return response.json();
        })
        .then(data => {
            cat = data;
        })
        .catch(error => {
            Swal.fire({
                title: "Error",
                text: "Failed to retrieve categories: " + error.message,
                icon: "error",
                confirmButtonText: "Ok",
            });
        });
}

readcat();
