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
                {
                    title: "Image",
                    name: "image",
                    data: null,
                    render: function (data, type, row) {
                      if (data.image) {
                        return '<img src="/storage/' + data.image + '" alt="Image" width="50">';
                      } else {
                        return "No Image";
                      }
                    }
                  },
                { title: "parkzone", name: "parkzone", data: "parkzone.name" },
                { title: "Level", name: "level", data: "level" },
                { 
                    title: "shadow", 
                    name: "shadow", 
                    render: function(data, type, row) {
                        if (row.shadow == "yes") {
                            return '<svg xmlns="http://www.w3.org/2000/svg" class="px-3" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M144.7 98.7c-21 34.1-33.1 74.3-33.1 117.3c0 98 62.8 181.4 150.4 211.7c-12.4 2.8-25.3 4.3-38.6 4.3C126.6 432 48 353.3 48 256c0-68.9 39.4-128.4 96.8-157.3zm62.1-66C91.1 41.2 0 137.9 0 256C0 379.7 100 480 223.5 480c47.8 0 92-15 128.4-40.6c1.9-1.3 3.7-2.7 5.5-4c4.8-3.6 9.4-7.4 13.9-11.4c2.7-2.4 5.3-4.8 7.9-7.3c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-3.7 .6-7.4 1.2-11.1 1.6c-5 .5-10.1 .9-15.3 1c-1.2 0-2.5 0-3.7 0c-.1 0-.2 0-.3 0c-96.8-.2-175.2-78.9-175.2-176c0-54.8 24.9-103.7 64.1-136c1-.9 2.1-1.7 3.2-2.6c4-3.2 8.2-6.2 12.5-9c3.1-2 6.3-4 9.6-5.8c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-3.6-.3-7.1-.5-10.7-.6c-2.7-.1-5.5-.1-8.2-.1c-3.3 0-6.5 .1-9.8 .2c-2.3 .1-4.6 .2-6.9 .4z"/></svg>'
                        } else if (row.shadow == "no")  {
                            return '<svg xmlns="http://www.w3.org/2000/svg" class="px-3" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 160c-52.9 0-96 43.1-96 96s43.1 96 96 96 96-43.1 96-96-43.1-96-96-96zm246.4 80.5l-94.7-47.3 33.5-100.4c4.5-13.6-8.4-26.5-21.9-21.9l-100.4 33.5-47.4-94.8c-6.4-12.8-24.6-12.8-31 0l-47.3 94.7L92.7 70.8c-13.6-4.5-26.5 8.4-21.9 21.9l33.5 100.4-94.7 47.4c-12.8 6.4-12.8 24.6 0 31l94.7 47.3-33.5 100.5c-4.5 13.6 8.4 26.5 21.9 21.9l100.4-33.5 47.3 94.7c6.4 12.8 24.6 12.8 31 0l47.3-94.7 100.4 33.5c13.6 4.5 26.5-8.4 21.9-21.9l-33.5-100.4 94.7-47.3c13-6.5 13-24.7.2-31.1zm-155.9 106c-49.9 49.9-131.1 49.9-181 0-49.9-49.9-49.9-131.1 0-181 49.9-49.9 131.1-49.9 181 0 49.9 49.9 49.9 131.1 0 181z"/></svg>'
                        }
                    }
                },
 
                { 
                    title: "active", 
                    name: "status" ,
                    render: function(data, type, row) {
                        if (row.status == "yes") {
                            return '<svg xmlns="http://www.w3.org/2000/svg" class="px-3" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"/></svg>'
                        } else if (row.status == "no") {
                            return '<svg xmlns="http://www.w3.org/2000/svg" class="px-3" height="1em" viewBox="0 0 352 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"/></svg>'
                        }
                    }
                },
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
                    next: "&#8594;", 
                    previous: "&#8592;", 
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
                    // Set the icon based on the value of the `shadow` property
                    let icon = "";
                    if (slot.shadow == 1) {
                        icon = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M144.7 98.7c-21 34.1-33.1 74.3-33.1 117.3c0 98 62.8 181.4 150.4 211.7c-12.4 2.8-25.3 4.3-38.6 4.3C126.6 432 48 353.3 48 256c0-68.9 39.4-128.4 96.8-157.3zm62.1-66C91.1 41.2 0 137.9 0 256C0 379.7 100 480 223.5 480c47.8 0 92-15 128.4-40.6c1.9-1.3 3.7-2.7 5.5-4c4.8-3.6 9.4-7.4 13.9-11.4c2.7-2.4 5.3-4.8 7.9-7.3c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-3.7 .6-7.4 1.2-11.1 1.6c-5 .5-10.1 .9-15.3 1c-1.2 0-2.5 0-3.7 0c-.1 0-.2 0-.3 0c-96.8-.2-175.2-78.9-175.2-176c0-54.8 24.9-103.7 64.1-136c1-.9 2.1-1.7 3.2-2.6c4-3.2 8.2-6.2 12.5-9c3.1-2 6.3-4 9.6-5.8c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-3.6-.3-7.1-.5-10.7-.6c-2.7-.1-5.5-.1-8.2-.1c-3.3 0-6.5 .1-9.8 .2c-2.3 .1-4.6 .2-6.9 .4z"/></svg>';
                    } else if (slot.shadow == 0) {
                        icon = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 160c-52.9 0-96 43.1-96 96s43.1 96 96 96 96-43.1 96-96-43.1-96-96-96zm246.4 80.5l-94.7-47.3 33.5-100.4c4.5-13.6-8.4-26.5-21.9-21.9l-100.4 33.5-47.4-94.8c-6.4-12.8-24.6-12.8-31 0l-47.3 94.7L92.7 70.8c-13.6-4.5-26.5 8.4-21.9 21.9l33.5 100.4-94.7 47.4c-12.8 6.4-12.8 24.6 0 31l94.7 47.3-33.5 100.5c-4.5 13.6 8.4 26.5 21.9 21.9l100.4-33.5 47.3 94.7c6.4 12.8 24.6 12.8 31 0l47.3-94.7 100.4 33.5c13.6 4.5 26.5-8.4 21.9-21.9l-33.5-100.4 94.7-47.3c13-6.5 13-24.7.2-31.1zm-155.9 106c-49.9 49.9-131.1 49.9-181 0-49.9-49.9-49.9-131.1 0-181 49.9-49.9 131.1-49.9 181 0 49.9 49.9 49.9 131.1 0 181z"/></svg>';
                    }
                    let status = "";
                    if (slot.status == 1) {
                        status = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"/></svg>';
                    } else if (slot.status == 0) {
                        status = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 352 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"/></svg>';
                    }

                    rows += `
                        <tr>
                            <td>${slot.name}</td>
                            <td>${icon}</td>
                            <td>${status}</td>
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
                                    <th>Active</th>
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
