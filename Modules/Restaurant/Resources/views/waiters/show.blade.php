@extends('restaurant::layouts.master', [
    'title' => $waiter->name,
    'crumbs' => [
        ['url' => route('waiters.index'), 'title' => __('restaurant::waiters.list'), 'icon' => 'fa fa-car'],
        ['title' => $waiter->name],
    ]
])

@push('content')
    <div class="box">
        <div class="box-header">
            <h3>{{ $waiter->name }}</h3>
        </div>
    </div>

    <div class="box">
        <form action="{{ route('waiters.destroy', $waiter->id) }}" method="POST">
            @csrf
            {{ method_field('DELETE') }}
            <div class="box-header">
                <table class="table table-borderd">
                    <tr>
                        <th>@lang('restaurant::global.name')</th>
                        <td>{{ $waiter->name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('restaurant::global.phone')</th>
                        <td>{{ $waiter->phone }}</td>
                    </tr>
                    <tr>
                        <th>@lang('restaurant::global.address')</th>
                        <td>{{ $waiter->address }}</td>
                    </tr>
                </table>
            </div>
            <div class="box-footer">
                @if(request()->delete)
                    @permission('waiters-delete')
                        <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> @lang('restaurant::global.delete')</button>
                    @endpermission
                @else
                    @permission('waiters-update')
                        <a href="{{ route('waiters.edit', $waiter->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('restaurant::global.edit')</a>
                    @endpermission
                @endif
            </div>
        </form>
    </div>
@endpush