(function ($) {
    "use strict";
    function printSlip() {
        UtilityManager.PrintHtmlPage(272, 303, $("#printDiv").html());
    }
    $(document).ready(function () {
        
        $("#print_slip").on('click', function () {
            printSlip();
        });

        if (paidAmount > 0) {
            printSlip();
            $("#parking_list").focus();
        }

        $("#recive_amt").on('input', function (key) {
            let pay = parseFloat($("#recive_amt").val());
            let amt = parseFloat($("#payble_amt").text());
            $("#return_amt").val((pay - amt).toFixed(2));
            if (pay < amt) {
                $("#paid_amt").val(pay);
                $("#return_amt").prop("readonly", true);
            } else {
                $("#paid_amt").val(Math.abs(pay - amt - pay));
                $("#return_amt").prop("readonly", false);
            }
        });

        $("#return_amt").on('keyup', function (key) {
            let pay = parseFloat($("#recive_amt").val());
            let amt = parseFloat($("#payble_amt").val());
            let r_amt = parseFloat($("#return_amt").val());            
            if (r_amt < 0) {
                $("#return_amt").prop("readonly", true);
                $("#paid_amt").val(pay);
            } else {
                $("#return_amt").prop("readonly", false);
                $("#paid_amt").val(pay - r_amt);
            }
        });

        $("#recive_amt").focus();
    });
})(jQuery);
