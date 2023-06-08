var arr = [];
var html = "";

(function ($) {
  "use strict";

  let parkzoneDatatableEl = null;
  let $return;

  $(document).ready(function () {
    parkzoneDatatableEl = $("#parkzoneDatatable").DataTable({
      dom: '<"row"<"col-12 col-sm-6"l><"col-12 col-sm-6"f>><"row"<"col-12 col-sm-12"t><"col-12 col-sm-6"i><"col-12 col-sm-6"p>>',
      lengthMenu: [
        [10, 50, 100, 200, -1],
        [10, 50, 100, 200, "All"],
      ],
      buttons: [],
      columns: [
        {
          title: "id",
          data: "id",
          class: "no-sort",
          width: "50px",
        },
        { title: "Name", name: "name", data: "name" },
        { title: "Remarks", name: "remarks", data: "remarks" },
        { title: "Quartier", name: "Quartier", data: "quartier.quartier_name" },
        { title: "lat", name: "lat", data: "lat" },
        { title: "lng", name: "lng", data: "lng" },
        {
          title: "type",
          name: "type",
          data: "type",
          render: function (data, type, row) {
            if (data === "floor") {
              return (
                '<button class="btn btn-primary" onclick="createFloor(' +
                row.id +
                ')">Create Floor</button>'
              );
            } else if (data === "side") {
              return (
                '<button class="btn btn-primary" onclick="createSide(' +
                row.id +
                ')">Create Side</button>'
              );
            } else {
              return data;
            }
          },
        },
        {
          title: "Chef Zone",
          name: "chef_zone",
          render: function (data, type, row) {
            arr.push(row);
            return (
              '<div onclick="agentslist(' +
              row.id +
              ')" class="d-flex justify-content-center"><i style="cursor: pointer;" class="fa fa-users" aria-hidden="true"></i></div>'
            );
          },
        },
        {
          title: "Action",
          name: "action",
          render: function (data, type, row) {
            let deleteUrl = route('parkzones.destroy', { 'parkzone': row.id });
            return (
              '<div class="d-flex justify-content-around"><a class="link-success" href="/parkzones/' + row.id + '/edit"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> | <button class="btn btn-link p-0" onclick="deleteData(\'' + deleteUrl + '\', \'#parkzoneDatatableEl\')" > <i class="fa fa-trash-o" aria-hidden="true"></i></button></div>'
            )
          },
        }
      ],
      ajax: {
        url: route("parkzones.index"),
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

function agentslist(id) {
  html = "";
  var result = arr.find((obj) => {
    return obj.id === id;
  });
  result.agents.forEach((element) => {
    html +=
      '<div class=""><div class="card"><div class="card-body"><h5 class="card-title">' +
      element.name +
      '</h5><p class="card-text">' +
      element.email +
      "</p></div></div></div>";
  });
  Swal.fire({
    title: "Parkzone List",
    html: html,
    confirmButtonText: "Ok",
  });
}


function createFloor(parkzoneId) {
  Swal.fire({
    title: 'Create Floor',
    html: '<form id="floorForm">' +
      '<div class="form-group">' +
      '<label for="level" class="">Level:</label>' +
      '<hr>' +
      '<select class="form-select" id="level" name="level[]" data-placeholder="Choose anything" multiple>' +
      '<option value="5">Fifth Floor</option>' +
      '<option value="4">Fourth Floor</option>' +
      '<option value="3">Third Floor</option>' +
      '<option value="2">Second Floor</option>' +
      '<option value="1">First Floor</option>' +
      '<option value="0">Level 0</option>' +
      '<option value="-1">Basement</option>' +
      '<option value="-2">Underground</option>' +
      '<option value="-3">Underground 2</option>' +
      '</select>' +
      '</form>',

    showCancelButton: true,
    cancelButtonText: 'Cancel',
    confirmButtonText: 'Create',
    focusConfirm: false,
    preConfirm: () => {
      const levels = Array.from(Swal.getPopup().querySelectorAll('#level option:checked'), (option) => option.value);
      if (levels.length === 0) {
        Swal.showValidationMessage('Please select at least one level');
      }
      return { levels: levels };
    }
    
  }).then((result) => {
    if (!result.dismiss && result.value) {
      const levels = result.value.levels;
      const formData = new FormData();
      formData.append('parkzone_id', parkzoneId);
      levels.forEach((level) => {
        formData.append('level[]', level);
      });



      var csrfToken = $('meta[name="csrf-token"]').attr('content');


      $.ajax({
        url: route("parkzones.store"),

        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          Swal.fire({
            title: 'Floor Created',
            text: 'The floor has been created successfully.',
            icon: 'success',
            confirmButtonText: 'Ok'
          }).then(() => {
            // location.reload();
          });
        },
        error: function (xhr, status, error) {
          Swal.fire({
            title: 'Error',
            text: 'An error occurred while creating the floor.',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        }
      });
    }
  });
}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// marwaneaitelhaj /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
function createSide(parkzoneId) {
  Swal.fire({
    title: "Create Side",
    html:
      '<div class="form-group d-flex align-items-center justify-content-around">' +
      '<button type="button" class="btn btn-primary" onclick="openLeftSide(' +
      parkzoneId +
      ')">Left Side</button>' +
      '<button type="button" class="btn btn-primary" onclick="openRightSide(' +
      parkzoneId +
      ')">Right Side</button>' +
      "</div>",
    showConfirmButton: false,
  });
}
var cat = [];
function openLeftSide(parkzoneId) {
  var html = "";
  for (var i = 0; i < cat.length; i++) {
    html +=
      '<div class="m-1"> <input type="number"  class="form-control" placeholder="' + cat[i].type + '" name="' + cat[i].id + '"> </div>';
  }
  Swal.fire({
    title: "Create Left Side",
    html:
      '<div class="form-group">' +
      '<form id="createSideForm">' +
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
      const form = document.getElementById('createSideForm');
    const formData = new FormData(form);
    const formValues = Object.fromEntries(formData.entries());
    // must be json to send to the server
    // add parkzoneId to the form values
    formValues.parkzone_id = parkzoneId;
    formValues.side = 'left';
    const jsonFormValues = JSON.stringify(formValues);

    
    // Access the form values
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
      
    fetch("side", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken
      },
      body: jsonFormValues,
    })
    },
  }).then((result) => {
    if (result.value) {
      Swal.fire({
        title: "Floor Created",
        text: "The floor has been created successfully.",
        icon: "success",
        confirmButtonText: "Ok",
      }).then(() => {
        // Refresh the page or perform any other desired action
        location.reload();
      });
    }
  });
}
function readcat() {
  fetch("read/cat", {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(response.statusText);
      }
      return response.json();
    })
    .then((data) => {
      cat = data;
    })
    .catch((error) => {
      Swal.showValidationMessage("Error: " + error);
    });
}
readcat();
function openRightSide(parkzoneId) {
  var html = "";
  for (var i = 0; i < cat.length; i++) {
    html +=
      '<div class="m-1"> <input type="number"  class="form-control" placeholder="' + cat[i].type + '" name="'+ cat[i].id +'"> </div>';
  }
  Swal.fire({
    title: "Create Right Side",
    html:
      '<div class="form-group">' +
      '<meta name="csrf-token" content="{{ csrf_token() }}">'+
      '<form id="createSideForm">' +
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
    // if the user clicks the confirm button...
    preConfirm: () => {
      const form = document.getElementById('createSideForm');
    const formData = new FormData(form);
    const formValues = Object.fromEntries(formData.entries());
    // must be json to send to the server
    // add parkzoneId to the form values
    formValues.parkzone_id = parkzoneId;
    formValues.side = 'right';
    const jsonFormValues = JSON.stringify(formValues);

    
    // Access the form values
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
      
    fetch("side", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken
      },
      body: jsonFormValues,
    })
    },
  }).then((result) => {
    if (result.value) {
      Swal.fire({
        title: "Floor Created",
        text: "The floor has been created successfully.",
        icon: "success",
        confirmButtonText: "Ok",
      }).then(() => {
        // Refresh the page or perform any other desired action
        location.reload();
      });



      var csrfToken = $('meta[name="csrf-token"]').attr('content');


      $.ajax({
        url: route("parkzones.store"),

        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          Swal.fire({
            title: 'Floor Created',
            text: 'The floor has been created successfully.',
            icon: 'success',
            confirmButtonText: 'Ok'
          }).then(() => {
            // location.reload();
          });
        },
        error: function (xhr, status, error) {
          Swal.fire({
            title: 'Error',
            text: 'An error occurred while creating the floor.',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
        }
>>>>>>> fb173a53551d838a27259277777fb18f7d69f9a2
      });
    }
  });
}
