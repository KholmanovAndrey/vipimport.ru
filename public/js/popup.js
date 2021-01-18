const popup = document.querySelector('#popup');
const popup_open = document.querySelector('#popup-open');
const popup_close = document.querySelector('#popup-close');

popup_open.addEventListener('click', event => {
    popup.classList.remove('invisible');;
})

popup_close.addEventListener('click', event => {
    popup.classList.add('invisible');;
})