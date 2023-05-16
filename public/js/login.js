(function ($) {
    "use strict";
    $(document).ready(function () {
        $(".btn-credential").on('click', function () {
            $("#loginForm")
                .find("input[name=email]")
                .val($(this).data("email"));
            $("#loginForm")
                .find("input[name=password]")
                .val($(this).data("password"));
        });

        $("#guest-log-out").on('click', function (event) {
            event.preventDefault();
            document.getElementById("logout-form").submit();
        });
    });
})(jQuery);
