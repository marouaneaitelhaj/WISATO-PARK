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
          data: "category",
          render: function (data, type, row) {
            var html = "<div class='d-flex justify-content-around'>";
            for (var i = 0; i < row.category.length; i++) {
              console.log(row.category[i].type);
              if (row.category[i].type == "Car") {
                html += "<i class='fa fa-car' aria-hidden='true'></i>";
              } else if (row.category[i].type == "Bike") {
                html += "<i class='fa fa-motorcycle' aria-hidden='true'></i>";
              } else if (row.category[i].type == "Cycle") {
                html += "<i class='fa fa-bicycle' aria-hidden='true'></i>";
              } else if (row.category[i].type == "Truck") {
                html += "<i class='fa fa-truck' aria-hidden='true'></i>";
              } else if (row.category[i].type == "Bus") {
                html += "<i class='fa fa-bus' aria-hidden='true'></i>";
              } else if (row.category[i].type == "Auto") {
                html += "<i class='fa fa-taxi' aria-hidden='true'></i>";
              } else {
                html += "<i class='fa fa-car' aria-hidden='true'></i>";
              }
            }
            html += "</div>";
            return html;
          },
        },
        {
          title: "ParkZone",
          class: "no-sort",
          name: "floor.name",
          data: "floor.name",
        },
        { title: "Slot Name", name: "slot_name", data: "slot_name" },
        { title: "Slot ID", name: "slotId", data: "slotId" },
        {
          title: "operator",
          // name: "operator",
          // data: "operator",
          render: function (data, type, row) {
            return (
              '<div class="d-flex justify-content-center"><i class="fa fa-users" aria-hidden="true"></i></div>'
            );
          },
        },
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
              '\', \'#parkingSlotDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Parking Slot"></i></button>';

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
          searchable: false,
          orderable: false,
          targets: [0, 1, 2, 5, 6],
        },
      ],
      responsive: true,
      autoWidth: false,
      serverSide: true,
      processing: true,
    });
  });
})(jQuery);
