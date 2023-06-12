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
            } else if (data === "standard") {
              return (
                '<button class="btn btn-primary" onclick="createstandard(' +
                row.id +
                ')">Manage standard</button>'
              );
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
            let deleteUrl = route("parkzones.destroy", { parkzone: row.id });
            return (
              '<div class="d-flex justify-content-around"><a class="link-success" href="/parkzones/' +
              row.id +
              '/edit"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> | <button class="btn btn-link p-0" onclick="deleteData(\'' +
              deleteUrl +
              '\', \'#parkzoneDatatableEl\')" > <i class="fa fa-trash-o" aria-hidden="true"></i></button></div>'
            );
          },
        },
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

//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// majidisimo /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////

function createFloor(parkzoneId) {
  Swal.fire({
    title: "Create Floor",
    html:
      '<form id="floorForm">' +
      '<div class="form-group">' +
      '<label for="level" class="">Level:</label>' +
      "<hr>" +
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
      "</select>" +
      "</div>" +
      '<div class="form-group">' +
      '<label for="shadow" class="">Shadow:</label>' +
      "<hr>" +
      '<select class="form-select" id="shadow" name="shadow">' +
      '<option value="yes">No Shadow</option>' +
      '<option value="no">Shadow</option>' +
      "</select>" +
      "</div>" +
      '<div class="form-group">' +
      '<label for="status" class="">Status:</label>' +
      "<hr>" +
      '<select class="form-select" id="status" name="status">' +
      '<option value="yes">Inactive</option>' +
      '<option value="no">Active</option>' +
      "</select>" +
      "</div>" +
      "</form>",

    showCancelButton: true,
    cancelButtonText: "Cancel",
    confirmButtonText: "Create",
    focusConfirm: false,
    preConfirm: () => {
      const levels = Array.from(
        Swal.getPopup().querySelectorAll("#level option:checked"),
        (option) => option.value
      );
      if (levels.length === 0) {
        Swal.showValidationMessage("Please select at least one level");
      }
      return {
        levels: levels,
        shadow: Swal.getPopup().querySelector("#shadow").value,
        status: Swal.getPopup().querySelector("#status").value,
      };
    },
  }).then((result) => {
    if (!result.dismiss && result.value) {
      const levels = result.value.levels;
      const shadow = result.value.shadow;
      const status = result.value.status;

      const formData = new FormData();
      formData.append("parkzone_id", parkzoneId);
      levels.forEach((level) => {
        formData.append("level[]", level);
        formData.append("shadow[]", shadow);
        formData.append("status[]", status);
      });

      var csrfToken = $('meta[name="csrf-token"]').attr("content");

      $.ajax({
        url: route("parkzones.store"),
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": csrfToken,
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          Swal.fire({
            title: "Floor Created",
            text: "The floor has been created successfully.",
            icon: "success",
            confirmButtonText: "Ok",
          }).then(() => {
            // location.reload();
          });
        },
        error: function (xhr, status, error) {
          Swal.fire({
            title: "Error",
            text: "An error occurred while creating the floor.",
            icon: "error",
            confirmButtonText: "Ok",
          });
        },
      });
    }
  });
}

//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// marwaneaitelhaj /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
function createSide(parkzoneId) {
  var left = false;
  var right = false;
  check_if_side_is_activ(parkzoneId, "left");
  check_if_side_is_activ(parkzoneId, "right");
  Swal.fire({
    title: "Create Side",
    html:
      '<meta name="csrf-token" content="{{ csrf_token() }}">' +
      '<div class="form-group d-flex flex-column align-items-center justify-content-around">' +
      '<div class="  align-items-center form-group d-flex">' +
      "<div>" +
      '<button type="button" class="btn btn-primary" onclick="openLeftSide(' +
      parkzoneId +
      ')">Left Side</button>' +
      "</div>" +
      '<div class=" form-switch">' +
      '<input type="checkbox" id="leftactive" disabled onchange="leftactive(' +
      parkzoneId +
      ')" class="form-check-input" checked data-toggle="toggle">' +
      "</div>" +
      "</div>" +
      '<div class="form-group   align-items-center d-flex ">' +
      "<div>" +
      '<button type="button" class="btn btn-primary" onclick="openRightSide(' +
      parkzoneId +
      ')">Right Side</button>' +
      "</div>" +
      '<div class=" form-switch">' +
      '<input class="form-check-input"  onchange="rightactive(' +
      parkzoneId +
      ')"  id="rightactive"  disabled type="checkbox" checked data-toggle="toggle">' +
      "</div>" +
      "</div>" +
      "</div>",
    showConfirmButton: false,
  });
}
function createstandard(parkzoneId) {
  var html = "";
  for (var i = 0; i < cat.length; i++) {
    html +=
      '<div class="m-1"> <input type="number"  class="form-control" placeholder="' +
      cat[i].type +
      '" name="' +
      cat[i].id +
      '"> </div>';
  }
  Swal.fire({
    title: "Manage standard parkzone",
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
      const form = document.getElementById("createSideForm");
      const formData = new FormData(form);
      const formValues = Object.fromEntries(formData.entries());
      // must be json to send to the server
      formValues.parkzone_id = parkzoneId;
      const jsonFormValues = JSON.stringify(formValues);

      // Access the form values
      const csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]'
      ).content;

      // fetch("side", {
      //   method: "POST",
      //   headers: {
      //     "Content-Type": "application/json",
      //     "X-CSRF-TOKEN": csrfToken,
      //   },
      //   body: jsonFormValues,
      // });
      axios
        .post("parking-settings", jsonFormValues, {
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
          },
        })
        .then(function (response) {
          console.log(response);
          Swal.fire({
            title: "Side Created",
            text: "The side has been created successfully.",
            icon: "success",
            confirmButtonText: "Ok",
          });
        })
        .catch(function (error) {
          console.log(error);
          Swal.fire({
            title: "Error",
            text: "An error occurred while creating the side.",
            icon: "error",
            confirmButtonText: "Ok",
          });
        });
    },
  });
}
var cat = [];
function openLeftSide(parkzoneId) {
  var html = "";
  for (var i = 0; i < cat.length; i++) {
    html +=
      '<div class="m-1"> <input type="number"  class="form-control" placeholder="' +
      cat[i].type +
      '" name="' +
      cat[i].id +
      '"> </div>';
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
      const form = document.getElementById("createSideForm");
      const formData = new FormData(form);
      const formValues = Object.fromEntries(formData.entries());
      // must be json to send to the server
      formValues.parkzone_id = parkzoneId;
      formValues.side = "left";
      const jsonFormValues = JSON.stringify(formValues);

      // Access the form values
      const csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]'
      ).content;

      // fetch("side", {
      //   method: "POST",
      //   headers: {
      //     "Content-Type": "application/json",
      //     "X-CSRF-TOKEN": csrfToken,
      //   },
      //   body: jsonFormValues,
      // });
      axios
        .post("side", jsonFormValues, {
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
          },
        })
        .then(function (response) {
          console.log(response);
          Swal.fire({
            title: "Side Created",
            text: "The side has been created successfully.",
            icon: "success",
            confirmButtonText: "Ok",
          });
        })
        .catch(function (error) {
          console.log(error);
          Swal.fire({
            title: "Error",
            text: "An error occurred while creating the side.",
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
      '<div class="m-1"> <input type="number"  class="form-control" placeholder="' +
      cat[i].type +
      '" name="' +
      cat[i].id +
      '"> </div>';
  }
  Swal.fire({
    title: "Create Right Side",
    html:
      '<div class="form-group">' +
      '<meta name="csrf-token" content="{{ csrf_token() }}">' +
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
      const form = document.getElementById("createSideForm");
      const formData = new FormData(form);
      const formValues = Object.fromEntries(formData.entries());
      // must be json to send to the server
      // add parkzoneId to the form values
      formValues.parkzone_id = parkzoneId;
      formValues.side = "right";
      const jsonFormValues = JSON.stringify(formValues);

      // Access the form values
      const csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]'
      ).content;
      axios
        .post("side", jsonFormValues, {
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
          },
        })
        .then(function (response) {
          console.log(response);
          Swal.fire({
            title: "Side Created",
            text: "The side has been created successfully.",
            icon: "success",
            confirmButtonText: "Ok",
          });
        })
        .catch(function (error) {
          console.log(error);
          Swal.fire({
            title: "Error",
            text: "An error occurred while creating the side.",
            icon: "error",
            confirmButtonText: "Ok",
          });
        });
    },
  });
}
function leftactive(parkzoneId) {
  const csrfToken = document.head.querySelector(
    'meta[name="csrf-token"]'
  ).content;
  var data = {
    parkzoneId: parkzoneId,
    side: "left",
  };
  var jsondata = JSON.stringify(data);
  fetch("toogleactive", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": csrfToken,
    },
    body: jsondata,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Side not found");
      }
      return response.json();
    })
    .then((data) => {
      Swal.fire({
        title: data,
        icon: "success",
        confirmButtonText: "Ok",
      });
    })
    .catch((error) => {
      Swal.fire({
        title: error,
        icon: "error",
        confirmButtonText: "Ok",
      });
    });
}
function rightactive(parkzoneId) {
  const csrfToken = document.head.querySelector(
    'meta[name="csrf-token"]'
  ).content;
  var data = {
    parkzoneId: parkzoneId,
    side: "right",
  };
  var jsondata = JSON.stringify(data);
  fetch("toogleactive", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": csrfToken,
    },
    body: jsondata,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Side not found");
      }
      return response.json();
    })
    .then((data) => {
      Swal.fire({
        title: data,
        icon: "success",
        confirmButtonText: "Ok",
      });
    })
    .catch((error) => {
      Swal.fire({
        title: error,
        icon: "error",
        confirmButtonText: "Ok",
      });
    });
}
function check_if_side_is_activ(parkzone_id, side) {
  const csrfToken = document.head.querySelector(
    'meta[name="csrf-token"]'
  ).content;
  var data = {
    parkzoneId: parkzone_id,
    side: side,
  };
  var jsondata = JSON.stringify(data);
  fetch("check_if_side_is_activ", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": csrfToken,
    },
    body: jsondata,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Side not found");
      }
      return response.json();
    })
    .then((data) => {
      if (data == "active") {
        document.getElementById(side + "active").checked = true;
        // delete disabled attribute
        document.getElementById(side + "active").removeAttribute("disabled");
      } else if (data == "notactive") {
        document.getElementById(side + "active").checked = false;
        // delete disabled attribute
        document.getElementById(side + "active").removeAttribute("disabled");
      }
    })
    .catch((error) => {
      document.getElementById(side + "active").classList.add("d-none");
    });
}
