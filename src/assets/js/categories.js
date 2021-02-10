

(() => {
    $.post(domain + 'categories/index', {lang}, r => {
        r = JSON.parse(r);
        r.push(r.splice(0, 1)[0]);
        let navCategories = '';
        r.map(i => {
            navCategories += `<a class="dropdown-item" href="/${lang}/category/${i.slug}.html">${i.title}</a>`;
        });
        document.getElementById('category_dd').innerHTML = navCategories;
    });
})();
