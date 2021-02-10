

const slider = c => {
    $(c).addClass('d-block');
    $(c).slick({
        infinite: false,
        speed: 300,
        slidesToShow: 6,
        slidesToScroll: 1,
        arrows: false,
        responsive: [
            {
                breakpoint: 320,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true
                }
            },
            {
                breakpoint: 375,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true
                }
            },
            {
                breakpoint: 1440,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    infinite: true
                }
            },
            {
                breakpoint: 1920,
                settings: {
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    infinite: true
                }
            },
            {
                breakpoint: 2560,
                settings: {
                    slidesToShow: 8,
                    slidesToScroll: 1,
                    infinite: true
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });

    // Custom carousel nav
    $(c + '-prev').click(function () {
        $(this).parent().parent().parent().find(c).slick('slickPrev');
    });

    $(c + '-next').click(function (e) {
        e.preventDefault();
        $(this).parent().parent().parent().find(c).slick('slickNext');
    });
}

slider('.fruit');
slider('.popular');
