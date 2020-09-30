const selectSupportID = document.getElementById('support_id');
const divOrderID = document.getElementById('div_order_id');
const selectOrderID = document.getElementById('order_id');
const divParcelID = document.getElementById('div_parcel_id');
const selectParcelID = document.getElementById('parcel_id');

divOrderID.classList.add('invisible');
divParcelID.classList.add('invisible');

selectSupportID.addEventListener('change', event => {
    if (event.target.value === 'common') {
        divOrderID.classList.add('invisible');
        divParcelID.classList.add('invisible');
        selectOrderID.value = '';
        selectParcelID.value = '';
    }
    if (event.target.value === 'order') {
        divOrderID.classList.remove('invisible');
        divParcelID.classList.add('invisible');
        selectParcelID.value = '';
    }
    if (event.target.value === 'parcel') {
        divOrderID.classList.add('invisible');
        divParcelID.classList.remove('invisible');
        selectOrderID.value = '';
    }
});