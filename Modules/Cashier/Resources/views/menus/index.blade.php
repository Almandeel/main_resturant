@extends('cashier::layouts.master', [
    'title' => 'القوائم',
    'crumbs' => [
        ['title' => 'القوائم', 'icon' => 'icon-menu'],
    ]
])
@push('content')
    <div class="nav-tabs-custom" style="cursor: move;">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right ui-sortable-handle">
            @foreach ($menus as $menu)
                <li class="{{ $loop->index == 0 ? 'active' : '' }}"><a href="#menu-{{ $loop->index }}" data-toggle="tab" aria-expanded="true">{{ $menu->name }}</a></li>
            @endforeach
            <li class="pull-left header"><i class="icon-menu"></i> <span>القوائم</span></li>
        </ul>
        <div class="tab-content no-padding">
            @foreach ($menus as $menu)
                <div class="tab-pane {{ $loop->index == 0 ? 'active' : '' }}" id="menu-{{ $loop->index }}" style="position: relative; height: 500px; overflow-y: auto;">
                    <table class="table table-striped">
                        <thead>
                            <th>#</th>
                            <th><i class="fa fa-image"></i></th>
                            <th>المنتج</th>
                            <th>السعر</th>
                            <th>الحالة</th>
                            <th>الخيارات</th>
                        </thead>
                        <tbody>
                            @foreach ($menu->items as $item)
                                @foreach ($item->itemUnits as $unit)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td class="text-center">
                                            <span class="image-preview image-preview-inline" style="background-image: url({{ $item->image_url }});"></span>
                                        </td>
                                        <td>{{ $unit->name }}</td>
                                        <td>{{ number_format($unit->price, 2) }}</td>
                                        <td>{{ $unit->displayStatus() }}</td>
                                        <td>
                                            @permission('items-update')
                                            <form action="{{ route('items.units.update', $unit->item_id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="unit_id" value="{{ $unit->unit->id }}">
                                                @if ($unit->isAvailable())
                                                    <input type="hidden" name="status" value="{{ $unit::STATUS_UNAVAILABLE }}">
                                                    <button type="submit" class="btn btn-warning"
                                                        data-toggle="confirm" data-title="تحذير" data-text="سوف لن يظهر هذا العنصر في نافذة البيع استمرار"
                                                    >
                                                        <i class="fa fa-ban"></i>
                                                        <span>غير متوفر</span>
                                                    </button>
                                                @else
                                                    <input type="hidden" name="status" value="{{ $unit::STATUS_AVAILABLE }}">
                                                    <button type="submit" class="btn btn-success"
                                                        data-toggle="confirm" data-title="تأكيد" data-text="سوف يظهر هذا العنصر في نافذة البيع استمرار" data-icon="question"
                                                    >
                                                        <i class="fa fa-check"></i>
                                                        <span>متوفر</span>
                                                    </button>
                                                @endif
                                            </form>
                                            @endpermission
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
@endpush
