{!! Form::open(['method'=>'get', 'class'=>'mb-4']) !!}
<div class="card">
    <div class="card-body">
        <div class="row align-items-end">
            <div class="col-md-3">
                {!! Form::label('Type') !!}
                {!! Form::select('type', \App\Models\UnitPrice::TYPE_LIST, isset($filters['type']) ? $filters['type'] : null, ['class'=>'form-control form-control-sm','placeholder'=>'Select Type']) !!}
            </div>
            {{-- <div class="col-md-3">
                {!! Form::label('max_size') !!}
                {!! Form::number('max_size', isset($filters['max_size']) ? $filters['max_size'] : null, ['class'=>'form-control form-control-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('min_size') !!}
                {!! Form::number('min_size', isset($filters['min_size']) ? $filters['min_size'] : null, ['class'=>'form-control form-control-sm']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('unit_price') !!}
                {!! Form::number('unit_price', isset($filters['unit_price']) ? $filters['unit_price'] : null, ['class'=>'form-control form-control-sm']) !!}
            </div> --}}
            <div class="col-md-3">
                {!! Form::label('Category') !!}
                {!! Form::select('estimate_category_id',$es_category,
                    isset($filters['estimate_category_id']) ? $filters['estimate_category_id'] : null,
                    ['class' => 'form-control form-control-sm','placeholder'=>'Select Category']
                ) !!}
            
            </div>
            <div class="col-md-3">
                {!! Form::label('Sub Category') !!}
                {!! Form::select('estimate_sub_category_id',$es_sub_category,
                    isset($filters['estimate_sub_category_id']) ? $filters['estimate_sub_category_id'] : null,
                    ['class' => 'form-control form-control-sm','placeholder'=>'Select Sub Category']
                ) !!}
            
            </div>
            {{-- <div class="col-md-3">
                {!! Form::label('Unit') !!}
                {!! Form::select('unit_id',$es_unit,
                    isset($filters['unit_id']) ? $filters['unit_id'] : null,
                    ['class' => 'form-control form-control-sm','placeholder'=>'Select Unit']
                ) !!}
            
            </div>
            <div class="col-md-3">
                {!! Form::label('Package') !!}
                {!! Form::select('package_id',$es_package,
                    isset($filters['package_id']) ? $filters['package_id'] : null,
                    ['class' => 'form-control form-control-sm','placeholder'=>'Select Package']
                ) !!}
            
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
