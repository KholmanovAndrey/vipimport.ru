<!-- Modal -->
<form action="#" method="POST" id="addressFormModal">
    @csrf
    <div class="modal fade" id="address" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление адреса</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>* - поля обязательные для заполнения</p>
                    <input type="hidden" name="user_id" value="<?=\Illuminate\Support\Facades\Auth::user()->id?>">
                    <input id="lastname"
                           type="text"
                           class="form-control mb-2"
                           name="lastname"
                           placeholder="Фамилия*"
                           required autofocus>
                    <input id="firstname"
                           type="text"
                           class="form-control mb-2"
                           name="firstname"
                           placeholder="Имя*"
                           required>
                    <input id="othername"
                           type="text"
                           class="form-control mb-2"
                           name="othername"
                           placeholder="Отчество">
                    <select name="country_id"
                            id="country_id"
                            class="form-control mb-2"
                            required>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">
                                {{ $country->title }}
                            </option>
                        @endforeach
                    </select>
                    <input id="postal_code"
                           type="text"
                           class="form-control mb-2"
                           name="postal_code"
                           placeholder="Почтовый индекс*"
                           required>
                    <input id="region"
                           type="text"
                           class="form-control mb-2"
                           name="region"
                           placeholder="Регион*"
                           required>
                    <input id="city"
                           type="text"
                           class="form-control mb-2"
                           name="city"
                           placeholder="Город*"
                           required>
                    <input id="street"
                           type="text"
                           class="form-control mb-2"
                           name="street"
                           placeholder="Улица*"
                           required>
                    <input id="building"
                           type="text"
                           class="form-control mb-2"
                           name="building"
                           placeholder="Дом*"
                           required>
                    <input id="body"
                           type="text"
                           class="form-control mb-2"
                           name="body"
                           placeholder="Корпус">
                    <input id="apartment"
                           type="text"
                           class="form-control mb-2"
                           name="apartment"
                           placeholder="Квартира">
                    <input id="phone"
                           type="text"
                           class="form-control"
                           name="phone"
                           placeholder="Телефон*">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    window.apiToken = {!! json_encode(Auth::user()->api_token) !!}
    console.log(apiToken)
</script>
<script src="{{ asset('public/js/component.address.js') }}" defer></script>