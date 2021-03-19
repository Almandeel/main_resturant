@extends('restaurant::layouts.master', [
    'title' => 'إعداد قائمة',
    'crumbs' => [
        ['url' => route('menus.index'), 'title' => 'قوائم الطعام', 'icon' => 'fa fa-list-alt'],
        ['title' => 'إعداد قائمة', 'icon' => 'fa fa-plus'],
    ]
])
@push('content')
    <form action="{{ route('menus.store') }}" method="POST">
        @csrf
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">إعداد قائمة الطعام</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="required"> @lang('restaurant::global.name') </label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="form-group">
                    <label for="name" class="required">المنتجات </label>
                    <select class="form-control" name="items[]" id="items" multiple>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">إعداد</button>
            </div>
        </div>
    </form>
@endpush
@include('partials._select2')

