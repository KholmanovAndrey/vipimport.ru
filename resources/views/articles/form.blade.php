@extends('layouts.app')

@section('title', 'Создание/Редактирование')

@section('sidebar')
    @parent

    <div class="sidebar col">
        <x-office/>
    </div>
@endsection

@section('content')
    <form class="col-lg-9"
          method="POST"
          action="@if (!$article->id){{ route('article.store') }}@else{{ route('article.update', $article) }}@endif">
        @csrf
        @if ($article->id) @method('PUT') @endif

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Наименование') }}</label>
            <div class="col-md-6">
                <input id="title"
                       type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       name="title"
                       value="{{ $article->title ?? old('title') }}"
                       required autofocus>
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Наименование на английском') }}</label>
            <div class="col-md-6">
                <input id="name"
                       type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       name="name"
                       value="{{ $article->name ?? old('name') }}"
                       required>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Категория') }}</label>
            <div class="col-md-6">
                <select name="category_id"
                        id="category_id"
                        class="form-control @error('category_id') is-invalid @enderror"
                        required>
                    @foreach ($categories as $cat)
                        <option {{ $cat->id === $article->category_id ? 'selected="selected"' : '' }} value="{{ $cat->id }}">
                            {{ $cat->title }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Описание') }}</label>
            <div class="col-md-6">
                <textarea name="text"
                          id="text"
                          class="form-control @error('text') is-invalid @enderror"
                          required
                          cols="30" rows="10">{!! $article->text ?? old('text') !!}</textarea>
                @error('text')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        {{--<div class="form-group row">--}}
            {{--<label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Картинка') }}</label>--}}
            {{--<div class="col-md-6">--}}
                {{--<input id="image"--}}
                       {{--type="text"--}}
                       {{--class="form-control @error('image') is-invalid @enderror"--}}
                       {{--name="image"--}}
                       {{--value="{{ $article->image ?? old('image') }}"--}}
                       {{--required>--}}
                {{--@error('image')--}}
                {{--<span class="invalid-feedback" role="alert">--}}
                    {{--<strong>{{ $message }}</strong>--}}
                {{--</span>--}}
                {{--@enderror--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Сохранить') }}
                </button>
            </div>
        </div>
    </form>
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
    </script>
    <script>
        CKEDITOR.replace('text', options);
    </script>
@endsection