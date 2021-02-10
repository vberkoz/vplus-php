

$(document).ready(function () {
    $('.new-products').slick({
        infinite: false,
        speed: 300,
        slidesToShow: 8,
        slidesToScroll: 1,
        arrows: false,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    infinite: true
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
});

// Custom carousel nav
$('.carousel-prev').click(function () {
    $(this).parent().parent().parent().find('.new-products').slick('slickPrev');
});

$('.carousel-next').click(function (e) {
    e.preventDefault();
    $(this).parent().parent().parent().find('.new-products').slick('slickNext');
});
