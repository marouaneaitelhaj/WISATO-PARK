// (function($) {
//     "use strict"; // Start of use strict
//     let teamDatatable = null;
//     let $return;
//     $(document).ready(function() {
//         teamDatatable = $("#teamDatatable").DataTable({
//             dom: '<"row"<"col-12 col-sm-6"l><"col-12 col-sm-6"f>><"row"<"col-12 col-sm-12"t><"col-12 col-sm-6"i><"col-12 col-sm-6"p>>',
//             lengthMenu: [
//                 [10, 50, 100, 200, -1],
//                 [10, 50, 100, 200, "All"],
//             ],
//             buttons: [],
//             columns: [{
//                     title: "#SL",
//                     data: "id",
//                     class: "no-sort",
//                     width: "50px",
//                     // render: function (data, row, type, col) {
//                     //     var pageInfo = teamDatatable.page.info();
//                     //     return col.row + 1 + pageInfo.start;
//                     // },
//                 },
//                 { title: "operator", name: "operator", data: "operator" },
//                 { title: "agent", name: "agent", data: "agent" },
//                 {
//                     title: "Status",
//                     name: "status",
//                     data: "status",
//                     render: function(data, type, row) {
//                         return data == 1 ? "Enable" : "Disable";
//                     },
//                 },
                
//                 {
//                     title: "Option",
//                     data: "id",
//                     class: "text-end width-5-per",
//                     render: function(data, type, row, col) {
//                         let deleteUrl = route('team.destroy', { 'team': data });
//                         $return = '<a href="' + route('team.edit', { 'team': data })+'"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Team"></i></a>';
//                         $return += '| <button class="btn btn-link p-0" onclick="deleteData(\''+deleteUrl+'\', \'#teamDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Team"></i></button>';
//                         return $return;
//                     },
//                 },
//             ],
//             ajax: {
//                 url: route("team.index"),
//                 dataSrc: "data",
//             },
//             language: {
//                 paginate: {
//                     next: "&#8594;", // or '→'
//                     previous: "&#8592;", // or '←'
//                 },
//             },
//             columnDefs: [{
//                     targets: "no-sort",
//                     orderable: false,
//                 },
//                 {
//                     targets: "no-search",
//                     searchable: false,
//                 },
//             ],
//         });
//     });
// })(jQuery); // End of use strict

