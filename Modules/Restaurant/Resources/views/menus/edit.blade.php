@extends('restaurant::layouts.master', [
    'title' => "تعديل قائمة الطعام",
    'crumbs' => [
        ['url' => route('menus.index'), 'title' => 'قوائم الطعام', 'icon' => 'fa fa-list-alt'],
        ['url' => route('menus.show', $menu), 'title' => $menu->name],
        ['title' => __('restaurant::global.edit'), 'icon' => 'fa fa-edit'],
    ]
])

@push('content')
    <div class="box">
        <div class="box-header">
            <h3>@lang('restaurant::global.edit') - قائمة الطعام: {{ $menu->name }}</h3>
        </div>
        @include('partials._errors')
        <div class="box-body">
            <form action="{{ route('menus.update', $menu) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name" class="required">{{ __('restaurant::global.name') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ $menu->name }}" required>
                </div>

                <div class="form-group">
                    <label for="name" class="required">المنتجات </label>
                    <select class="form-control" name="items[]" id="items" multiple>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}" @if (in_array($item->id, $menu->items()->pluck('items.id')->toArray())) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">@lang('restaurant::global.save_changes')</button>
            </form>
        </div>
    </div>
@endpush
@include('partials._select2')