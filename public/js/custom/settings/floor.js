(function ($) {
  "use strict";
  let floorDatatableEl = null;
  let $return;
  $(document).ready(function () {
    floorDatatableEl = $("#floorDatatable").DataTable({
      // dom: '<"row"<"col-12 col-sm-6"l><"col-12 col-sm-6"f>><"row"<"col-12 col-sm-12"t><"col-12 col-sm-6"i><"col-12 col-sm-6"p>>',
      // lengthMenu: [
      //     [10, 50, 100, 200, -1],
      //     [10, 50, 100, 200, "All"],
      // ],
      buttons: [],
      columns: [
        {
          title: "id",
          data: "id",
          class: "no-sort",
          width: "50px",
          render: function (data, row, type, col) {
            var pageInfo = floorDatatableEl.page.info();
            return col.row + 1 + pageInfo.start;
          },
        },
        { title: "Name", name: "name", data: "name" },
        { title: "Remarks", name: "remarks", data: "remarks" },
      ],

      ajax: {
        url: route("floors.index"),
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
