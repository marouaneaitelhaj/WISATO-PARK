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
          render : function(data, type, row){
            var arr = row.agents.map((item) => item.name);
            var jsonString = JSON.stringify(arr);
            var encodedString = encodeURIComponent(jsonString);
            return '<div onclick="myFunction(decodeURIComponent(\'' + encodedString + '\'))" class="d-flex justify-content-center"><i class="fa fa-users" aria-hidden="true"></i></div>';
          }
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

function myFunction(jsonArray) {
  // Parse the JSON string to convert it back to an array
  document.getElementById("exampleModalLive").classList.toggle("d-none")
  var arr = JSON.parse(jsonArray);

  // Loop over the array
  for (var i = 0; i < arr.length; i++) {
    // Access each element of the array
    var element = arr[i];
    console.log(document.getElementById("exampleModalLive"));
    document.getElementById("OperatorsList").innerHTML += `<li class="list-group-item">${element}</li>`;
  }
}

document.getElementById("close").addEventListener("click", function () {
  document.getElementById("exampleModalLive").classList.toggle("d-none")
  document.getElementById("OperatorsList").innerHTML = ""
});
