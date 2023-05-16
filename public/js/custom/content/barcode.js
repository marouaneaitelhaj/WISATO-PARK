(function ($) {
    "use strict";
    function printSlip() {
        UtilityManager.PrintHtmlPage(272, 303, $("#printDiv").html());
    }
    $(document).ready(function () {
        printSlip();
        $("#parking_list").focus();
        $("#print_slip").on('click', function () {
            printSlip();
        });
    });
})(jQuery);
