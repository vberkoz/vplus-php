

let saveReview = () => {
    let review = {
        product_id: $("#product_id").val(),
        name: $("#reviewer_name").val(),
        email: $("#reviewer_email").val(),
        text: $("#reviewer_text").val()
    }

    $.post(domain + 'review/store', {review}, r => {
        let reviews = '';
        r = JSON.parse(r);
        r.map(i => {
            reviews += `<p><strong>${i.name}</strong><br>${i.text}</p>`
        });
        $('#reviews').html(reviews);
    });
}
