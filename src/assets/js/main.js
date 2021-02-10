

const domain = 'http://192.168.1.100:8080/api/v1/';
const domainFe = 'http://192.168.1.100:8080/';
// const domain = 'http://stage.kl.com.ua/api/v1/';
// const domainFe = 'http://stage.kl.com.ua/';
const lang = document.getElementsByTagName('html')[0].getAttribute('lang');

$(document).ready(function () {

    $.fn.inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
            let unit = $(this).attr("data-unit");
            unit = ' ' + unit;
            let volume = this.value;

            if (volume.includes(unit)) {
                volume = this.value.slice(0, -3);
            }

            if (this.selectionStart > this.value.length - 3) {
                this.setSelectionRange(this.value.length - 3, this.value.length - 3);
            }

            if (inputFilter(volume)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    };

    /**
     * Allow float only
     */
    $(".input-float, .bag-input-float").inputFilter(function(value) {
        return /^[0-9]{0,3}([\.][0-9]{0,1})??$/.test(value);
    });

    /**
     * Allow integer only
     */
    $(".input-int, .bag-input-int").inputFilter(function(value) {
        return /^[0-9]{0,2}?$/.test(value);
    });

    $('#remind').click(function () {
        let email = $('#inputEmail').val();
        if (validateEmail(email)) {
            $('#inputEmail').removeClass('is-invalid');
            $('#invalidEmail').remove();
            $.post('/forgot', {email: email}, function (response) {
                $('#remindSuccess').removeClass('d-none');
            });
        } else {
            $('#inputEmail').addClass('is-invalid');
            $('#inputEmail').after('<div class="invalid-feedback">Невірний формат електронної пошти</div>');
        }
    });

    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
});

/**
 * Slider
 */
let products = $('#featured_items').find('.product-card');
$('#featured_items').remove();

let slideIndex = 0;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    if (n > products.length - 1) slideIndex = 0;

    if (n < 0) {slideIndex = products.length - 1}

    let indices = [];
    for (let i = 0; i < products.length; i ++) indices.push(i);

    let visibleIndices = [];
    let currentElement = slideIndex;
    for (let i = 0; i < 4; i ++) {
        if (currentElement > products.length - 1) currentElement = 0;
        visibleIndices.push(indices[currentElement]);
        currentElement ++;
    }

    let visibleProducts = [];
    visibleIndices.map((item) => {
        visibleProducts.push(products[item]);
    });

    $('#slider').html(visibleProducts);
}
