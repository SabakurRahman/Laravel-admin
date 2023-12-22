{!! Form::open(['method'=>'get']) !!}
<div class="card">
    <div class="card-body">
        <div class="row align-items-end">
            <div class="col-md-3">
                {!! Form::label('From Date') !!}
                {!! Form::date('start_date', $filters['start_date'] ?? null, ['class'=>'form-control form-control-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('To Date') !!}
                {!! Form::date('end_date', $filters['end_date'] ?? null, ['class'=>'form-control form-control-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('OS') !!}
                <select name="os" class="form-select form-select-sm">
                    <option value="">Select OS</option>
                    @foreach($oses as $os)
                        <option
                            {{ isset($filters['os']) ? ($filters['os'] == $os->os ? 'selected': null): null}} value="{{$os->os}}">{{$os->os}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                {!! Form::label('browser') !!}
                <select name="browser" class="form-select form-select-sm">
                    <option value="">Select Browser</option>
                    @foreach($browsers as $browser)
                        <option
                            {{ isset($filters['browser']) ? ($filters['browser'] == $browser->browser ?'selected': null) :null }} value="{{$browser->browser}}">{{$browser->browser}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                {!! Form::label('device_type') !!}
                <select name="device_type" class="form-select form-select-sm">
                    <option value="">Select Device Type</option>
                    @foreach($device_types as $device_type)
                        <option
                            {{ isset($filters['device_type'])  ? ($filters['device_type'] == $device_type->device_type ? 'selected': null) : null }} value="{{$device_type->device_type}}">{{$device_type->device_type}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                {!! Form::label('device') !!}
                <select name="device" class="form-select form-select-sm">
                    <option value="">Select Device</option>
                    @foreach($devices as $device)
                        <option
                            {{ isset($filters['device'])  ? ($filters['device'] == $device->device ? 'selected': null) : null }} value="{{$device->device}}">{{$device->device}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                {!! Form::label('IP') !!}
                {!! Form::text('ip', isset($filters['ip']) ? $filters['ip'] : null, ['class'=>'form-control form-control-sm']) !!}
            </div>
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
