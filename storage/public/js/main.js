/*price range*/

if ($.fn.slider) {
    $('#sl2').slider();
}

var RGBChange = function () {
    $('#RGB').css('background', 'rgb(' + r.getValue() + ',' + g.getValue() + ',' + b.getValue() + ')')
};

/*scroll to top*/

$(document).ready(function () {
    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: 'top', // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: 'linear', // Scroll to top easing (see http://easings.net/)
            animation: 'fade', // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });
});


$(document).ready(function () {
    $('#selSize').change(function() {
        var lang = $('#getLang').text();
        var idSize = $(this).val();
        if(idSize == "") {
            return false;
        }
        $.ajax({
            url: '/' + lang + '/get-product-price',
            method: 'get',
            data: {idSize: idSize},
            success: function(data, status, xhr) {
                // alert(data); return false;
                var arr = data.split('#');
                $('#getPrice').html('€ ' + arr[0]);
                if(arr[1] == 0) {
                    $('#availability').text('Out Of Stock');
                    $('#cartButton').hide();
                } else {
                    $('#availability').text('In Stock');
                    $('#cartButton').show();
                }
            },
            error: function(error, status, xhr, ) {
                alert('Error');
            }

        });
    });

    //add product to cart
    $(document).ready(function() {
        $('.ajaxGET').click(function(e) {
            e.preventDefault();
            var idSize = $('#selSize').val();
            if(idSize == "") {
                return false;
            }
            var url = $(this).find('.url').text();
            var _token = $("input[name = '_token']").val();

            $.ajax({
                method: "GET",
                url: url,
                data: {_token: _token},
                success: function(data, status, XHR) {
                    // alert(data.totalQuantity);
                    if(data.totalQuantity > 0) {
                        $('#totalQuantity').text(data.totalQuantity);
                    }
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        });
    });

    //add product to cart
    $(document).ready(function() {
        $('.ajaxPOST').click(function(e) {
            e.preventDefault();
            var lang = $('#getLang').text();
            var url = '/' + lang + '/products/addToCartAjaxPostTwo';
            var _token = $("input[name = '_token']").val();
            var selSize = $('#selSize').val();
            if(selSize == "") {
                return false;
            }
            
            $.ajax({
                method: "POST",
                url: url,
                data: {_token: _token, selSize: selSize},
                success: function(data, status, XHR) {
                    // alert(data.totalQuantity);
                    if(data.totalQuantity > 0) {
                        $('#totalQuantity').text(data.totalQuantity);
                    }
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        });
    });


    //update main image with alternate image on product (detail view) page
    $('.changeImage').click(function() {
        // alert('test');
        var image = $(this).attr('src');
        $('.mainImage').attr('src', image);
    });



    // Instantiate EasyZoom instances
    var $easyzoom = $('.easyzoom').easyZoom();

    // Setup thumbnails example
    var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

    $('.thumbnails').on('click', 'a', function(e) {
        var $this = $(this);

        e.preventDefault();

        // Use EasyZoom's `swap` method
        api1.swap($this.data('standard'), $this.attr('href'));
    });

    // Setup toggles example
    var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

    $('.toggle').on('click', function() {
        var $this = $(this);

        if ($this.data("active") === true) {
            $this.text("Switch on").data("active", false);
            api2.teardown();
        } else {
            $this.text("Switch off").data("active", true);
            api2._init();
        }
    });



});