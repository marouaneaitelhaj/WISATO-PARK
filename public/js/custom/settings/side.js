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
        { title: "side", name: "side", data: "side" },
        { title: "parkzone", name: "parkzone", data: "parkzone.name" },
        {
          title: "Status",
          name: "status",
          data: "is_active",
          render: function (data, type, row) {
            return data == 1 ? "Enable" : "Disable";
          },
        },
        {
          title: "Option",
          render: function (data, type, row) {
            var html = "";
            html +=
              '<i class="fa fa-edit" onclick="editside(' +
              row.id +
              ')" id="editSide" style="cursor:pointer;margin-right:10px;"></i>';
            html +=
              '<i class="fa fa-trash" onclick="deleteside(' +
              row.id +
              ')" id="deleteSide" style="cursor:pointer;"></i>';
            // shadow icon
            html +=
              '<i class="fa fa-sun" onclick="viewside(' +
              row.id +
              ')" id="viewSide" style="cursor:pointer;margin-left:10px;"></i>';
            return html;
          },
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
function deleteside(id) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    width: "350px",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Delete",
  }).then((result) => {
    if (result.isConfirmed) {
      axios.delete("side/" + id).then((response) => {
        if (response.data.success) {
          Swal.fire({
            icon: "success",
            title: "Successfully Deleted!",
            showConfirmButton: false,
            timer: 1500,
          });
          sideDatatable.ajax.reload();
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops! Something went wrong.",
            showConfirmButton: false,
            timer: 1500,
          });
        }
      });
    }
  });
}
function editside(id) {
  axios.get("side/" + id).then((response) => {
    var html = "";
    html +=
      '<table class="table table-striped"> <thead> <tr> <th>Name</th> <th>Active</th><tbody id="tableBody">';
    for (var i = 0; i < response.data.length; i++) {
      html +=
        "<tr><td>" +
        response.data[i].name +
        '</td><td><input type="checkbox" onchange="toogleactive(' +
        response.data[i].id +
        ')"  value="' +
        response.data[i].id +
        '" ';
      if (response.data[i].is_active == 1) {
        html += "checked";
      }
      html += "></td></tr>";
    }
    html += "</tbody></table>";
    Swal.fire({
      title: "Edit Side",
      html: html,
    });
  });
}
function toogleactive(id) {
  axios
    .post("toogleslotside", { id: id })
    .then((response) => {
      Swal.fire({
        icon: "success",
        title: response.data,
        showConfirmButton: false,
        timer: 1500,
      });
    })
    .catch((error) => {
      Swal.fire({
        icon: "error",
        title: error.response.data,
        showConfirmButton: false,
        timer: 1500,
      });
    });
}
function viewside(id) {
  axios.get("showSide/" + id).then((response) => {
    var html = "";
    html +=
      '<table class="table table-striped"> <thead> <tr> <th>Category</th> <th>Shadow</th><tbody id="tableBody">';
    for (var i = 0; i < response.data.side_slot_numbers.length; i++) {
            html += '<tr><td>' + response.data.side_slot_numbers[i].category.type + '</td><td>'+
            
            '</td></tr>';
    }
    html += "</tbody></table>";
    Swal.fire({
        title: "View Side",
        html: html,
    });
  });
}
