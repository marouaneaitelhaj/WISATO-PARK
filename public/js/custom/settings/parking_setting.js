(function ($) {
  "use strict";
  var parkingSetupDatatableEl = null;
  let $return;
  $(document).ready(function () {
    parkingSetupDatatableEl = $("#parkingSlotDatatable").DataTable({
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
            var pageInfo = parkingSetupDatatableEl.page.info();
            return col.row + 1 + pageInfo.start;
          },
        },
        {
          title: "Categories",
          name: "category_id",
          data: "category",
          render: function (data, type, row) {
            var html = "<div class='d-flex justify-content-around'>";
            // for (var i = 0; i < row.category.length; i++) {
            if (row.category.type == "Electric Car") {
              html +=
                "<i class='fa fa-car text-success' aria-hidden='true'></i>";
            } else if (row.category.type == "Electric Bike") {
              html +=
                "<i class='fa fa-motorcycle text-success' aria-hidden='true'></i>";
            } else if (row.category.type == "Gasoline Car") {
              html +=
                "<i class='fa fa-car text-danger' aria-hidden='true'></i>";
            } else if (row.category.type == "Electric Truck") {
              html +=
                "<i class='fa fa-truck text-success' aria-hidden='true'></i>";
            } else if (row.category.type == "Electric Bus") {
              html +=
                "<i class='fa fa-bus text-success' aria-hidden='true'></i>";
            } else if (row.category.type == "Gasoline Bike") {
              html +=
                "<i class='fa fa-motorcycle text-danger' aria-hidden='true'></i>";
            } else if (row.category.type == "Gasoline Bus") {
              html +=
                "<i class='fa fa-bus text-danger' aria-hidden='true'></i>";
            } else if (row.category.type == "Gasoline Truck") {
              html +=
                "<i class='fa fa-truck text-danger' aria-hidden='true'></i>";
            }
            // }
            html += "</div>";
            return html;
          },
        },
        {
          title: "ParkZone",
          class: "no-sort",
          name: "parkzone_id",
          data: "parkzone.name",
        },
        { title: "Slot Name", name: "name", data: "name" },

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
            var editURL = route("parking_settings.edit", {
              parking_setting: data,
            });
            var delURL = route("parking_settings.destroy", {
              parking_setting: data,
            });
            var statusURL = route("parking_settings.status_changes", {
              parking_setting: data,
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
              '"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Parking Slot"></i></a>';

            $return +=
              '| <button class="btn btn-link p-0" onclick="deleteData(\'' +
              delURL +
              '\', \'#parkingSlotDatatable\')"><i class="fs-6 fa fa-trash text-danger" aria-hidden="true" title="Delete Parking Slot"></i></button>';

            return $return;
          },
        },
      ],

      ajax: {
        url: route("parking_settings.index"),
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
          orderable: true,
          targets: [0,1,2,3,4,5,6,7],
        },
      ],
      responsive: true,
      autoWidth: false,
      serverSide: true,
      processing: true,
    });
  });
})(jQuery);

function myFunction(jsonArray) {
  // Parse the JSON string to convert it back to an array
  document.getElementById("exampleModalLive").classList.toggle("d-none");
  var arr = JSON.parse(jsonArray);

  // Loop over the array
  for (var i = 0; i < arr.length; i++) {
    // Access each element of the array
    var element = arr[i];
    console.log(document.getElementById("exampleModalLive"));
    document.getElementById(
      "OperatorsList"
    ).innerHTML += `<li class="list-group-item">${element}</li>`;
  }
}

document.getElementById("close").addEventListener("click", function () {
  document.getElementById("exampleModalLive").classList.toggle("d-none");
  document.getElementById("OperatorsList").innerHTML = "";
});
