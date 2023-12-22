{!! Form::open(['method'=>'get', 'class'=>'mb-4']) !!}
<div class="card">
    <div class="card-body">
        <div class="row align-items-end">
            <div class="col-md-3">
                {!! Form::label('name') !!}
                {!! Form::text('name', isset($filters['name']) ? $filters['name'] : null, ['class'=>'form-control form-control-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('email') !!}
                {!! Form::text('email', isset($filters['email']) ? $filters['email'] : null, ['class'=>'form-control form-control-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('phone') !!}
                {!! Form::text('phone', isset($filters['phone']) ? $filters['phone'] : null, ['class'=>'form-control form-control-sm']) !!}
            </div>
            {{-- <div class="col-md-3">
                {!! Form::label('status') !!}
                {!! Form::select('status', \App\Models\EstimationLead::STATUS_LIST, isset($filters['status']) ? $filters['status'] : null, ['class'=>'form-control form-control-sm','placeholder'=>'select status']) !!}
            </div> --}}
            <div class="col-md-3">
                {!! Form::label('Per page') !!}
                {!! Form::select('per_page', [10 => 10, 20=>20, 50=>50, 100=>100], isset($filters['per_page']) ? $filters['per_page'] : 20, ['class'=>'form-select form-select-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('Sort by') !!}
                <select name="sort_by" class="form-select form-select-sm">
                    <option value="">Select Column</option>
                    @foreach($columns as $column)
                        <option
                            {{ isset($filters['sort_by'])  ? ($filters['sort_by'] == $column ? 'selected': null) : null }} value="{{$column}}">{{ucwords(str_replace('_', ' ', $column))}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                {!! Form::label('Sort direction') !!}
                {!! Form::select('sort_direction', ['asc' => 'ASC', 'desc'=>'DESC'], isset($filters['sort_direction']) ? $filters['sort_direction'] : 20, ['class'=>'form-select form-select-sm']) !!}
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-grid">
                            <button id="reset_fields" class="btn btn-sm btn-warning" type="reset"><i
                                    class="ri-refresh-line"></i> Reset
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-grid">
                            <button class="btn btn-sm btn-success" type="submit"><i class="ri-search-line"></i> Search </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
