var NaPlite = {} || NaPlite;
NaPlite = (function () {
    var $messageModal = $('#messageModal');

    var Public = {
        getBoxLoader: function () {
            return $('<div class="box-uploader">\n' +
                         '<div class="box-uploader-bg"></div>\n' +
                         '<img src="/img/spin.gif">\n' +
                         '<div class="box-uploader-progress"></div>' +
                     '</div>');
        },
        pluralize: function (iNumber, aEndings) {
            var sEnding, i;
            iNumber = iNumber % 100;
            if (iNumber>=11 && iNumber<=19) {
                sEnding=aEndings[2];
            }
            else {
                i = iNumber % 10;
                switch (i)
                {
                    case (1): sEnding = aEndings[0]; break;
                    case (2):
                    case (3):
                    case (4): sEnding = aEndings[1]; break;
                    default: sEnding = aEndings[2];
                }
            }
            return sEnding;
        },
        messageModal: function (title, text) {
            $(".modalbox").hide();
            $messageModal.find('H1').html(title).end().find('[data-for=text]').html(text).end().show();
        },
        scrollTo: function ($el) {
            $('html, body').animate({
                scrollTop: $el.offset().top
            }, 800);
        }
    };

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

        $('[data-link=readSeoText]').on('click', function (e) {
            var $seoBlock = $('#categorySeoText');
            if ($seoBlock.hasClass('mini')) {
                $seoBlock.removeClass('mini', 1000);
                $(this).html('<i class="fa fa-refresh"></i>Скрыть');
            } else {
                $seoBlock.addClass('mini', 1000);
                $(this).html('<i class="fa fa-refresh"></i>Читать далее');
            }
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
        init: init,
        public: Public
    };
})();

window.addEventListener("load", NaPlite.init);