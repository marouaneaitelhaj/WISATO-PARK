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
        { title: "lat", name: "lat", data: "lat" },
        { title: "lng", name: "lng", data: "lng" },
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
              '<div class="d-flex justify-content-around"><a class="link-success" href="/parkzones/'+row.id+'/edit"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> | <button class="btn btn-link p-0" onclick="deleteData(\''+deleteUrl+'\', \'#parkzoneDatatableEl\')" > <i class="fa fa-trash-o" aria-hidden="true"></i></button></div>'
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
    // icon: "success",
    confirmButtonText: "Ok",
  });
}