let token = document.head.querySelector("[name~=csrf-token][content]").content;
const select = document.getElementById('address_id').options;
console.log(select);

document.addEventListener('DOMContentLoaded', () => {

    const ajaxSend = async (formData) => {
        const fetchResp = await fetch('/api/address', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token,
                "Authorization": "Bearer " + apiToken
            },
            body: JSON.stringify(formData)
        });
        if (!fetchResp.ok) {
            throw new Error(`Ошибка по адресу ${url}, статус ошибки ${fetchResp.status}`);
        }
        return await fetchResp.text();
    };

    const form = document.getElementById('addressFormModal');
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = {
            _token: form.querySelector('input[name=_token]').value,
            user_id: form.querySelector('input[name=user_id]').value,
            lastname: form.querySelector('input[name=lastname]').value,
            firstname: form.querySelector('input[name=firstname]').value,
            othername: form.querySelector('input[name=othername]').value,
            country_id: form.querySelector('select[name=country_id]').value,
            postal_code: form.querySelector('input[name=postal_code]').value,
            region: form.querySelector('input[name=region]').value,
            city: form.querySelector('input[name=city]').value,
            street: form.querySelector('input[name=street]').value,
            building: form.querySelector('input[name=building]').value,
            body: form.querySelector('input[name=body]').value,
            apartment: form.querySelector('input[name=apartment]').value,
            phone: form.querySelector('input[name=phone]').value
        };

        ajaxSend(formData)
            .then((response) => {
                response = JSON.parse(response);
                select[select.length] = new Option(
                    response.data.city + ', ' + response.data.street + ', ' + response.data.building,
                    response.data.id,
                    true);
                select[select.length-1].selected = true;
                $('#address').modal('hide');
                console.log(response);
                form.reset(); // очищаем поля формы
            })
            .catch((err) => console.error(JSON.parse(err)))
    });

});