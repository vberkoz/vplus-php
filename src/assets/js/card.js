

let cartCountElement = document.getElementById('cart_count');
let productsElement = $('#products');

const updateCart = (id, quantity) => {
    $.post(domain + 'cart/update', {
        id: id,
        quantity: quantity
    }, hydrateProducts);
}

const hydrateProducts = () => {
    $.get(domain + 'cart/index', r => {
        if (r) {
            r = JSON.parse(r);
            if (Object.keys(r).length) {
                cartCountElement.classList.remove('d-none');
                cartCountElement.textContent = Object.keys(r).length.toString();
            } else {
                cartCountElement.classList.add('d-none');
            }

            $("a[data-id]").each(function (i) {
                for (const p in r) {
                    if (parseInt($(this).attr("data-id")) === parseInt(p)) {
                        if (r[p] > 0) {
                            $(this).get(0).classList.add("d-none");
                            let inputGroup = $(this).get(0).nextSibling.nextSibling;
                            inputGroup.classList.remove("d-none");
                            let unit = $(this).attr("data-unit");
                            inputGroup.children[1].value = r[p] + ' ' + unit;
                        }
                    }
                }
            });
        }
    });
}

hydrateProducts();

// Show input group and add product to bag
productsElement.on("click", ".add-to-bag-first", (e) => {
    let element = e.target.closest(".add-to-bag-first");
    let id = $(element).attr("data-id");
    let volume = 1;
    let unit = $(element).attr("data-unit");
    unit = ' ' + unit;
    $(element).get(0).classList.add("d-none");
    $(element).get(0).nextSibling.nextSibling.classList.remove("d-none");
    $(element).get(0).nextSibling.nextSibling.children[1].value = volume + unit;

    updateCart(id, volume);
    return false;
});

// Add unit to bag
productsElement.on("click", ".add-to-bag-second", (e) => {
    let element = e.target.closest(".add-to-bag-second");
    let id = $(element).attr("data-id");
    let volumeMin = parseFloat($(element).attr("data-volume_min"));
    let volumePrev = $(element).get(0).parentElement.previousSibling.previousSibling.value;
    volumePrev = volumePrev.slice(0, -3);
    volumePrev = parseFloat(volumePrev);
    let volume = Math.round((volumePrev + volumeMin) * 10) / 10;
    let unit = $(element).attr("data-unit");
    unit = ' ' + unit;
    $(element).get(0).parentElement.previousSibling.previousSibling.value = volume + unit;

    updateCart(id, volume);
    return false;
});

// Remove product from bag
productsElement.on("click", ".remove-from-bag", (e) => {
    let element = e.target.closest(".remove-from-bag");
    let id = $(element).attr("data-id");
    let volumeMin = parseFloat($(element).attr("data-volume_min"));
    let volumePrev = $(element).get(0).parentElement.nextSibling.nextSibling.value;
    volumePrev = volumePrev.slice(0, -3);
    volumePrev = parseFloat(volumePrev);
    let volume = Math.round((volumePrev - volumeMin) * 10) / 10;
    let unit = $(element).attr("data-unit");
    unit = ' ' + unit;

    $(element).get(0).parentElement.nextSibling.nextSibling.value = volume + unit;

    if (volume < volumeMin) {
        $(element).get(0).parentElement.parentElement.classList.add("d-none");
        $(element).get(0).parentElement.parentElement.previousSibling.previousSibling.classList.remove("d-none");
    }

    updateCart(id, volume);
    return false;
});

// Change unit quantity
productsElement.on("change", ".input-int, .input-float", (e) => {
    let element = e.target.closest(".input-int, .input-float");
    let unit = $(element).attr("data-unit");
    unit = ' ' + unit;
    let volume = $(element).get(0).value;

    if (volume.includes(unit)) {
        volume = volume.slice(0, -3);
    }

    let id = parseInt($(element).attr("data-id"));
    let quantity = parseFloat(volume);
    $(element).get(0).value = quantity + unit;

    if (!quantity) {
        quantity = 0;
        $(element).get(0).parentElement.classList.add("d-none");
        $(element).get(0).parentElement.previousSibling.previousSibling.classList.remove("d-none");
    }

    volume = quantity;

    updateCart(id, volume);
    return false;
});
