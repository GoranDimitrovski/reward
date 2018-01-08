(function ($) {

    $(function () {

        function init() {
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $("meta[name='token']").attr('content')}});
            loadImages();
        }

        function loadImages() {
            var images = $('img.lazy-image');

            images.each(function () {
                var image = $(this);

                if (image.attr('data-src') != '') {

                    if (!image.hasClass('loaded')) {

                        urlExists(image.attr('data-src'), function (status) {

                            if (status !== 400 && status !== 503) {
                              image.attr('src', image.attr('data-src'));
                            } else {
                                image.attr('src', 'img/blank-avatar.png');
                            }

                            image.addClass('loaded');

                        }.bind(image));

                    }
                } else {
                    image.attr('src', 'img/blank-avatar.png');
                }
            });

        }

        function urlExists(url, cb) {
            $.ajax({
                url: url,
                dataType: 'text',
                type: 'GET',
                crossDomain: true,
                complete: function (xhr) {
                    if (typeof cb === 'function') {
                        cb.apply(this, [xhr.status]);
                    }
                }
            });
        }

        init();

    });

})(jQuery);
