var NaPlite = {} || NaPlite;
NaPlite = (function () {
    var Listen = function () {
        $(".modalClose").on("click", function (e) {
            $(".modalbox").fadeOut();
        });

        $(".loginButton").on("click", function (e) {
            showModal('loginModal');
            showModal('loginModal');
        });

        $(".regButton").on("click", function (e) {
            showModal('regModal');
        });

        $(".forgotPassLink").on("click", function (e) {
            showModal('forgotPasswordModal');
        });
    };

    function showModal(id) {
        $(".modalbox").hide();
        $("#" + id).fadeIn();
    }

    function init() {
        Listen();
    }

    return {
        init: init
    };
})();

window.addEventListener("load", NaPlite.init);