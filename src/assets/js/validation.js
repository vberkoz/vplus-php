

let state = {
    errors: [
        'name',
        'phone',
        'email',
        'secret',

        'name_reg',
        'secret_reg',
        'repeat_reg',
        'email_reg',

        'changeName',
        'changePhone',
        'oldSecret',
        'newSecret',
        'repeatSecret',
    ],
    name: '',
    phone: '',
    email: '',
    secret: '',

    name_reg: '',
    email_reg: '',
    secret_reg: '',
    repeat_reg: '',

    changeEmail: '',
    changeName: '',
    changePhone: '',
    changeAddress: '',
    oldSecret: '',
    newSecret: '',
    repeatSecret: '',

    address: 'Відсутня',
    message: 'Відсутнє'

};

const validate = e => {
    const field = store(e);
    switch (field) {
        case 'name': checkFieldLength(field, e.value, 2);break;
        case 'phone': checkFieldLength(field, e.value, 10, true);break;
        case 'email': validateEmail(field, e.value);break;
        case 'secret': checkFieldLength(field, e.value, 6);break;

        case 'name_reg': checkFieldLength(field, e.value, 2);break;
        case 'email_reg':
            if (validateEmail(field, e.value)) {
                email(field, e);
            } else {
                document.getElementById('exists').classList.add('d-none');
                document.getElementById('format').classList.remove('d-none');
            }
            break;
        case 'secret_reg': checkFieldLength(field, e.value, 6);break;
        case 'repeat_reg': repeat(field, e.value);break;

        case 'changeName': checkFieldLength(field, e.value, 2);break;
        case 'changePhone': checkFieldLength(field, e.value, 10, true);break;
    }
    const index = state.errors.indexOf(field);
    if (index > -1) {
        e.classList.add('is-invalid');
    } else {
        e.classList.remove('is-invalid');
    }
}

const repeat = (field, v) => {
    if (v === state.secret_reg) {
        const index = state.errors.indexOf(field);
        if (index > -1) state.errors.splice(index, 1);
        state[field] = v;
    } else {
        if (!state.errors.includes(field)) state.errors.push(field);
    }
}

const email = (field, e) => {
    $.post(domain + 'email', {email: e.value}, r => {
        r = parseInt(JSON.parse(r));
        if (!r) {
            const index = state.errors.indexOf(field);
            if (index > -1) state.errors.splice(index, 1);
            state[field] = e.value;
        } else {
            if (!state.errors.includes(field)) state.errors.push(field);
            document.getElementById('exists').classList.remove('d-none');
            document.getElementById('format').classList.add('d-none');
        }
        const index = state.errors.indexOf(field);
        if (index > -1) {
            e.classList.add('is-invalid');
        } else {
            e.classList.remove('is-invalid');
        }
    });
}

const validateEmail = (field, email) => {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (re.test(email)) {
        const index = state.errors.indexOf(field);
        if (index > -1) state.errors.splice(index, 1);
        state[field] = email;
        return true;
    } else {
        if (!state.errors.includes(field)) state.errors.push(field);
        return false;
    }
}

const checkFieldLength = (field, current, correct, max = false) => {
    let cond = false;
    max ? cond = current.length < correct || current.length > correct : cond = current.length < correct;
    if (cond) {
        if (!state.errors.includes(field)) state.errors.push(field);
    } else {
        const index = state.errors.indexOf(field);
        if (index > -1) state.errors.splice(index, 1);
        state[field] = current;
    }
}

const store = e => {
    const field = e.getAttribute('id');
    state[field] = e.value;
    return field;
}

const checkout = () => {
    cartCountElement.classList.add('d-none');
    validate(document.getElementById('name'));
    validate(document.getElementById('phone'));
    let name = !state.errors.find(e => e === 'name');
    let phone = !state.errors.find(e => e === 'phone');
    if (name && phone && state.name && state.phone) {
        document.getElementById('info_container')
            .innerHTML = `<div class="alert alert-success" role="alert">${lang === 'ua' ? 'Ваше замовлення успішно оформлене. Дякуємо за покупку!' : 'Your order has been successfully processed. Thanks for your purchase!'}</div>`;
        delete state.errors;
        $.post(domain + 'cart/checkout', {
            d: state,
            lang
        });
    }
}
