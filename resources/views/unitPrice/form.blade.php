<style>
    .label-style {
        margin-top: 20px;
    }
</style>
<fieldset>
    <legend>Unit Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('type', 'Type', ['class' => 'form-label']) !!}
            {!! Form::select('type', \App\Models\UnitPrice::TYPE_LIST , null, ['class'=>'form-select '.( $errors->has('type') ? 'is-invalid':null), 'placeholder'=>'Select Type']) !!}
            @error('type')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-md-6">
            {!! Form::label('estimate_category_id', 'Category', ['class' => 'form-label']) !!}
            {!! Form::select('estimate_category_id', $estimate_categories  , null, ['class' => 'form-control','placeholder'=>'select category']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('sub_category_id', 'Sub Category', ['class' => 'form-label']) !!}
            {!! Form::select('estimate_sub_category_id', $estimate_sub_categories, null, ['class' => 'form-control','placeholder'=>'select Sub category']) !!}
        </div>
        {{-- <div class="col-md-6">
            {!! Form::label('estimate_category_id', 'Category', ['class' => 'form-label']) !!}
            {!! Form::select('estimate_category_id', $estimate_categories , null, ['class' => 'form-control','placeholder'=>'select category']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('sub_category_id', 'Sub Category', ['class' => 'form-label']) !!}
            {!! Form::select('estimate_sub_category_id', $estimate__sub_categories, null, ['class' => 'form-control','placeholder'=>'select Sub category']) !!}
        </div> --}}
    </div>
</fieldset>

@foreach ($estimatePackages as $package)
    <fieldset class="mt-4">
        <legend>{{ $package->name }} Package</legend>
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('unit_id', 'Unit', ['class' => 'form-label']) !!}
                {!! Form::select('package['.$package->id.'][unit_id]', $units, null, ['class' => 'form-control', 'placeholder' => 'Select Unit']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('price', 'Per unit Price', ['class' => 'form-label']) !!}
                {!! Form::text('package['.$package->id.'][price]', null, ['class' => 'form-control', 'placeholder' => 'Price']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('max_size', 'Max Size', ['class' => 'form-label']) !!}
                {!! Form::text('package['.$package->id.'][max_size]', null, ['class' => 'form-control', 'placeholder' => 'Max Size']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('min_size', 'Min Size', ['class' => 'form-label']) !!}
                {!! Form::text('package['.$package->id.'][min_size]', null, ['class' => 'form-control', 'placeholder' => 'Min Size']) !!}
            </div>
        </div>
        @endforeach
</div>

@include('unitPrice.partials.script')




