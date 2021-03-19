@extends('layouts.dashboard.app')

@section('title')
    الباقات
@endsection

@section('content')
    @component('partials._breadcrumb')
        @slot('title', ['الباقات'])
            @slot('url', ['#'])
                @slot('icon', ['users'])
    @endcomponent
        <div class="box">
            <div class="box-header">

            </div>
            <div class="box-body">
                <form id="form_plan" action="{{ route('plans.update', $plan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="stores">الاسم</label>
                                    <input type="text" name="name" class="form-control" value="{{ $plan->name }}"
                                        placeholder="الاسم" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>القيمة</label>
                                    <input type="text" name="amount" value="{{ $plan->amount }}" class="form-control"
                                        placeholder="القيمة" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>المدة</label>
                                    <input type="text" value="{{ $plan->period }}" name="period" class="form-control"
                                        placeholder="المدة" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>ميزات اضافية </label>
                                    <div class="row">
                                        @foreach ($plans as $pla)
                                            @if (count($pla->subPlans->pluck('subplan_id')) == 0)
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="checkbox" value="{{ $pla->id }}" name="subplans[]"
                                                            {{ in_array($pla->id, $plan->subPlans->pluck('subplan_id')->toArray()) ? 'checked' : '' }}>
                                                        {{ $pla->name }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
@endsection
