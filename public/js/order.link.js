/**
 * Created by Rusich on 20.09.2020.
 */

const divLinkVisible = document.querySelectorAll('.div-link-visible');
const btnLinkVisible = document.querySelectorAll('.btn-link-visible');

for (let i = 0; i < btnLinkVisible.length; i++) {
    divLinkVisible[i].classList.add('invisible');

    btnLinkVisible[i].addEventListener('change', event => {
        if (!event.target.checked) {
            divLinkVisible[i].classList.add('invisible');
        } else {
            divLinkVisible[i].classList.remove('invisible');
        }
    });
}