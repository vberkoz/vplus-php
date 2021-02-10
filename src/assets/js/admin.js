
// Restricts input for the set of matched elements to the given inputFilter function.
(function($) {
    $.fn.inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
            if (inputFilter(this.value)) {
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
}(jQuery));

$(document).ready(function () {

    /**
     * Allow digits only
     */
    $('.digits-only').inputFilter(function(value) {
        return /^[0-9]{0,4}([\.][0-9]{0,2})??$/.test(value);
    });

    let volumeElement = $('#admin_product_volume');
    let volumeMinElement = $('#admin_product_volume_min');
    let unit = $('#admin_product_unit').val();
    volumeElement.text("Об'єм, " + unit);

    volumeMinElement.text("Мінімальний об'єм, " + unit);

    $('#admin_product_unit').change(function (e) {
        unit = $(this).val();
        volumeElement.text("Об'єм, " + unit);
        volumeMinElement.text("Мінімальний об'єм, " + unit);
    });

    $('.input-discount-currency').keyup(function (e) {
        let currency = $(this).val();
        let userId = $(this).attr('data-user-id');
        let productId = $(this).attr('data-product-id');

        $.post('/admin/discount/currency', {
            userId: userId,
            productId: productId,
            currency: currency
        });
    });

    $('.input-discount-percent').keyup(function (e) {
        let percent = $(this).val();
        let userId = $(this).attr('data-user-id');
        let productId = $(this).attr('data-product-id');

        $.post('/admin/discount/percent', {
            userId: userId,
            productId: productId,
            percent: percent
        });
    });

    $('.restaurant').change(function() {
        let userId = $(this).attr('data-user-id')
        let role = $(this).prop("checked") ? 'restaurant' : 'client'
        $.post('/admin/user/restaurant', {
            userId: userId,
            role: role
        })
    })
});