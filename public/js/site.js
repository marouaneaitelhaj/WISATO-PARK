var UtilityManager;
var deleteData;
(function ($) {
    "use strict";
    $(document).ready(function () {
        $(".dateTimePicker").datetimepicker({
            step: 5,
            datepicker: true,
            format: "Y-m-d H:i:s",
        });
        $("#logOut").on('click', function (event) {
            event.preventDefault();
            document.getElementById("logout-form").submit();
        });

        if ($(document).find('.flashMessage').length) {
            let type = $(document).find('.flashMessage #msgType').text();
            let msg = $(document).find('.flashMessage #msg').text();
            toastMixin.fire({
                animation: true,
                title: msg,
                icon : type
            });
        }    
    });

    UtilityManager = {
        PrintHtmlPage: function (width, height, htmlText) {
            if ($(".printIframe").length) $(".printIframe").remove();
            var iframeEl = $(
                '<iframe class="printIframe" style="display:none;"></iframe>'
            );
            $("body").append(iframeEl);
            var iframeW = iframeEl.contents().find("body");
            var iframeWindow =
                iframeEl[0].contentWindow || iframeEl[0].contentDocument;
            htmlText =
                '<div style="margin:0 auto;width:' +
                width +
                "px;height:" +
                height +
                'px;">' +
                htmlText +
                "</div>";
            iframeW.append(htmlText);
            iframeWindow.print();
        },
    };

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger me-2'
        },
        buttonsStyling: false
    })
    
    var toastMixin = Swal.mixin({
        toast: true,
        icon: 'success',
        title: 'General Title',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    
    deleteData = function (route, dataTableId) {
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this and all related data associated with this.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'No, cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                let title = 'Successfully deleted';
                axios.delete(route).then(function (resData) {
                    if (typeof resData.data.message != 'undefined') {
                        title = resData.data.message;
                    }

                    toastMixin.fire({
                        animation: true,
                        title: title
                    });

                    if (typeof dataTableId != 'undefined') {
                        $(dataTableId).DataTable().ajax.reload();
                    }
                    else {
                        window.setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                }).catch(function (failData) {
                    title = 'Something went wrong!';
                    if ((typeof failData.response.data.message != 'undefined') && failData.response.data.message.search('SQLSTATE\\[23000\\]') != -1) {
                        title = 'This item used in somewhere else.';
                    }
                    else if (typeof failData.response.data.error != 'undefined') {
                        title = failData.response.data.error;
                    }
    
                    toastMixin.fire({
                        title: title,
                        icon: 'error'
                    });
                }).finally(function () {
                    window.setTimeout(() => {
                        location.reload();
                    }, 1000);
                })
    
    
            }

        })
    }
})(jQuery);


