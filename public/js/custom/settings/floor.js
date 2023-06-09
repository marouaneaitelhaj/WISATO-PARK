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
function showfloorslots(floorId) {
    fetch("floorslots/" + floorId, {
        method: "GET",
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                let rows = "";
                data.forEach(slot => {
                    rows += `
                        <tr>
                            <td>${slot.name}</td>
                            <td>${slot.shadow}</td>
                            <td>${slot.status}</td>
                            <td>
                                <button class="btn btn-primary" onclick="updateSlot('${slot.id}')">Update</button>
                            </td>
                        </tr>
                    `;
                });

                const table = `
                <input class="form-control mr-sm-2 mb-3" type="search" id="searchInput" placeholder="Search by name" aria-label="Search">

                    <div style="max-height: 300px; overflow-y: scroll;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Shadow</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                ${rows}
                            </tbody>
                        </table>
                    </div>
                `;

                Swal.fire({
                    title: "<span class='text-primary'>Floor Slots</span>",
                    html: table,
                    icon: "info",
                    confirmButtonText: "Close",
                    customClass: {
                        title: "cool-title",
                        content: "cool-content",
                        confirmButton: "btn btn-primary"
                    }
                });

                const searchInput = document.getElementById("searchInput");
                const tableBody = document.getElementById("tableBody");

                searchInput.addEventListener("input", () => {
                    const searchTerm = searchInput.value.toLowerCase();

                    // Filter the table rows based on the search query
                    Array.from(tableBody.children).forEach(row => {
                        const name = row.children[0].textContent.toLowerCase();

                        if (name.includes(searchTerm)) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    });
                });
            } else {
                Swal.fire({
                    title: "<span class='text-primary'>Floor Slots</span>",
                    text: "No floor slots available for the selected floor.",
                    icon: "info",
                    confirmButtonText: "Close",
                    customClass: {
                        title: "cool-title",
                        content: "cool-content",
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: "<span class='text-danger'>Error</span>",
                html: `Failed to retrieve floor slots: <span class='text-danger'>${error.message}</span>`,
                icon: "error",
                confirmButtonText: "Ok",
                customClass: {
                    title: "cool-title",
                    content: "cool-content",
                    confirmButton: "btn btn-danger"
                }
            });
        });
}

function updateSlot(slotId) {
    const form = `
        <form>
            <div class="d-flex justify-content-between">
                <div class="form-group d-flex flex-column align-items-start">
                    <label for="shadow mb-2">Shadow:</label>
                    <div class="btn-group btn-group-toggle mt-3" data-toggle="buttons">
                        <label for="shadow1" class="btn btn-custom active" style="background-color: #3498db; color: #fff; border-color: #3498db; box-shadow: none;">
                            <input type="radio" name="shadow" id="shadow1" value="1" autocomplete="off" checked> Yes
                        </label>
                        <label for="shadow2" class="btn btn-custom" style="background-color: #3498db; color: #fff; border-color: #3498db; box-shadow: none;">
                            <input type="radio" name="shadow" id="shadow2" value="0" autocomplete="off"> No
                        </label>
                    </div>
                </div>
            
                <div class="form-group d-flex flex-column align-items-start">
                    <label for="status">Active:</label>
                    <div class="btn-group btn-group-toggle mt-3" data-toggle="buttons">
                        <label for="status1" class="btn btn-custom active" style="background-color: #3498db; color: #fff; border-color: #3498db; box-shadow: none;">
                            <input type="radio" name="status" id="status1" value="1" autocomplete="off" checked> Yes
                        </label>
                        <label for="status2" class="btn btn-custom" style="background-color: #3498db; color: #fff; border-color: #3498db; box-shadow: none;">
                            <input type="radio" name="status" id="status2" value="0" autocomplete="off"> No
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" onclick="submitUpdate(${slotId}, event)">Update</button>
        </form>
    `;

    Swal.fire({
        title: "<span class='text-primary'>Update Slot</span>",
        html: form,
        showCancelButton: false,
        showConfirmButton: false,
        customClass: {
            title: "cool-title",
            content: "cool-content"
        }
    });
}

function submitUpdate(slotId, event) {
    event.preventDefault(); // Prevent page refresh

    const shadowValue = document.querySelector('input[name="shadow"]:checked').value;
    const statusValue = document.querySelector('input[name="status"]:checked').value;

    const data = {
        shadow: shadowValue,
        status: statusValue
    };
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

   
       

    fetch(`/floorslots/${slotId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText);
            }
            return response.json();
        })
        .then(result => {
            Swal.fire({
                title: "<span class='text-success'>Success</span>",
                html: "Slot updated successfully.",
                icon: "success",
                confirmButtonText: "Ok",
                customClass: {
                    title: "cool-title",
                    content: "cool-content",
                    confirmButton: "btn btn-success"
                }
            });
        })
        .catch(error => {
            Swal.fire({
                title: "<span class='text-danger'>Error</span>",
                html: `Failed to update slot: <span class='text-danger'>${error.message}</span>`,
                icon: "error",
                confirmButtonText: "Ok",
                customClass: {
                    title: "cool-title",
                    content: "cool-content",
                    confirmButton: "btn btn-danger"
                }
            });
        });
}
