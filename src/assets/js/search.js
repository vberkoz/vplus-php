

const search = e => {
    fetchSearchData(e.value);
}

const fetchSearchData = term => {
    $.post(domain + 'search', {term, lang}, r => {
        r = JSON.parse(r);
        let seachItems = '';
        r.map(i => {
            seachItems += `<a class="dropdown-item" href="${i.link}">${i.title}</a>`;
        });
        document.getElementById('search_dd').innerHTML = seachItems;
    });
}

fetchSearchData('');
