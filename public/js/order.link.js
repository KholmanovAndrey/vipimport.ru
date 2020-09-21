const btnLinkVisible = document.querySelectorAll('.btn-link-visible');
const divLinkVisible = document.querySelectorAll('.div-link-visible');

for (let i = 0; i < btnLinkVisible.length; i++) {
    let input = divLinkVisible[i].querySelector('input[type=url]');
    divLinkVisible[i].classList.add('invisible');

    if (input.value) {
        btnLinkVisible[i].checked = true;
        divLinkVisible[i].classList.remove('invisible');
    }

    btnLinkVisible[i].addEventListener('change', event => {
        if (!event.target.checked) {
            divLinkVisible[i].classList.add('invisible');
        } else {
            divLinkVisible[i].classList.remove('invisible');
            //input.value = '';
        }
    });
}