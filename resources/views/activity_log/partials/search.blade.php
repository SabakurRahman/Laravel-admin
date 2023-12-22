{!! Form::open(['method'=>'get', 'class'=>'mb-4']) !!}
<div class="card">
    <div class="card-body">
        <div class="row align-items-end">
            <div class="col-md-3">
                {!! Form::label('from_date', 'Select From Date') !!}
                {!! Form::date('from_date', null, ['class'=>'form-control form-control-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('to_date', 'Select To Date') !!}
                {!! Form::date('to_date', null, ['class'=>'form-control form-control-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('user_id', 'Admin') !!}
                {!! Form::select('user_id', $admins, isset($filters['user_id']) ? $filters['user_id'] : null, ['class'=>'form-control form-control-sm', 'placeholder'=>'Select Admin']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('method') !!}
                {!! Form::select('method',
                        [
                            'get' => 'GET',
                            'post' => 'POST',
                            'put' => 'PUT',
                            'patch' => 'PATCH',
                            'delete' => 'DELETE',
                        ],
                         isset($filters['method']) ? $filters['method'] : null, ['class'=>'form-control form-control-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('route') !!}
                {!! Form::select('route', $routes ,isset($filters['route']) ? $filters['route'] : null, ['class'=>'form-control form-control-sm', 'placeholder' =>'Select route']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('ip') !!}
                {!! Form::select('ip', $ips ,isset($filters['ip']) ? $filters['ip'] : null, ['class'=>'form-control form-control-sm', 'placeholder' =>'Select IP']) !!}
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
                {!! Form::select('sort_direction', ['asc' => 'ASC', 'desc'=>'DESC'], isset($filters['sort_direction']) ? $filters['sort_direction'] : 20, ['class'=>'form-select form-select-sm', 'placeholder' =>'Select Direction']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('Per page') !!}
                {!! Form::select('per_page', [10 => 10, 20=>20, 50=>50, 100=>100], isset($filters['per_page']) ? $filters['per_page'] : 20, ['class'=>'form-select form-select-sm']) !!}
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
                            <button class="btn btn-sm btn-success" type="submit"><i class="ri-search-line"></i> Search
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
