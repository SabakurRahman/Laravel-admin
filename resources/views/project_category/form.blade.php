<fieldset>
    <legend>Project Category Information</legend>
    <div class="row">   
        <div class="row">
            <div class="col-md-6">
                @csrf
                <div class="mb-3">
                    {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Page Name']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    {!! Form::label('slug', 'Slug', ['class' => 'form-label']) !!}
                    {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter Slug']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    {!! Form::label('serial', 'Serial', ['class' => 'form-label']) !!}
                    {!! Form::number('serial', null, ['class' => 'form-control', 'placeholder' => 'Enter page serial']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    {!! Form::label('Status', 'Status',['class' => 'form-label']) !!}
                    {!! Form::select('status', \App\Models\ProjectCategory::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            {{-- <div class="col-md-6">
                <div class="mb-3">
                    {!! Form::label('photo', 'Photo', ['class' => 'form-label']) !!}
                    {!! Form::file('photo', ['class' => 'form-control']) !!}
                </div>
            </div> --}}
            <div class="col-md-6">
                {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
                {!! Form::file('photo', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
                <div class="photo-preview-area">
                    <i class="ri-camera-line"></i>
                    <div class="overly"></div>
                    <img
                        src="{{isset($projectCategory->photo) ? asset(\App\Models\ProjectCategory::PHOTO_UPLOAD_PATH.$projectCategory->photo)  : asset('uploads/canvas.webp')}}"
                        alt="photo display area" class="photo photo-preview-area-photo"/>
                </div>
            </div>

            <div class="col-md-6">
                {!! Form::label('banner', 'Banner',['class'=>'label-style']) !!}
                {!! Form::file('banner', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
                <div class="photo-preview-area" style="width: 250px; height: 150px">
                    <i class="ri-camera-line"></i>
                    <div class="overly"></div>
                    <img
                        src="{{isset($projectCategory->banner) ? asset(\App\Models\ProjectCategory::BANNER__UPLOAD_PATH_THUMB.$projectCategory->banner)  : asset('uploads/canvas.webp')}}"
                        alt="photo display area" class="photo photo-preview-area-photo"/>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="mb-3">
                    {!! Form::label('banner', 'Banner', ['class' => 'form-label']) !!}
                    {!! Form::file('banner', ['class' => 'form-control']) !!}
                </div>
            </div> --}}
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    {!! Form::label('description', 'Description', ['class' => 'form-label']) !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'rows' => 4]) !!}
                </div>
            </div>
        </div>

        {{-- <div class="row">

            <div class="col-md-6">
                <div class="mb-3">
                    {!! FORM::label('address_type', 'Address Type') !!}
                    {!! FORM::select('address_type', \App\Models\Address::ADDRESS_TYPE_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Address Type']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    {!! FORM::label('is_default', 'Is Default') !!}
                    {!! FORM::select('is_default', \App\Models\Address::IS_DEFAULT_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Is Default']) !!}
                
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    {!! FORM::label('country_id', 'Country') !!}
                    {!! FORM::select('country_id', $allCountry->pluck('name', 'id') , null, ['class'=>'form-select', 'placeholder'=>'Select Country']) !!}
                
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    {!! FORM::label('division_id', 'Division') !!}
                    {!! FORM::select('division_id', $allDivision->pluck('name', 'id'), null, ['class'=>'form-select', 'placeholder'=>'Select Division']) !!}
                
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    {!! FORM::label('city_id', 'City') !!}
                    {!! FORM::select('city_id', $allCity->pluck('name', 'id') , null, ['class'=>'form-select', 'placeholder'=>'Select City']) !!}
                
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    {!! FORM::label('zone_id', 'Zone') !!}
                    {!! FORM::select('zone_id', $allZone->pluck('name', 'id') , null, ['class'=>'form-select', 'placeholder'=>'Select Zone']) !!}
                
                </div>

            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    {!! FORM::label('zip_code', 'Zip Code') !!}
                    {!! FORM::text('zip_code', null, ['class'=>'form-control', 'placeholder'=>'Enter Zip Code']) !!}
                
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    {!! FORM::label('landmark', 'Landmark') !!}
                    {!! FORM::text('landmark', null, ['class'=>'form-control', 'placeholder'=>'Enter Landmark']) !!}
                
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    {!! FORM::label('phone', 'Phone') !!}
                    {!! FORM::number('phone', null, ['class'=>'form-control', 'placeholder'=>'Enter Phone']) !!}
                
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    {!! FORM::label('street_address', 'street_address') !!}
                {!! Form::textarea('street_address', null, ['class' => 'form-control', 'placeholder' => 'Enter street_address', 'rows' => 4]) !!}
                
                </div>
            </div>

        </div> --}}
    </div>
</fieldset>
<fieldset class="mt-4">
    <legend>Seo</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('meta_title', ' Seo Title') !!}
            {!! Form::text('meta_title',$projectCategory->seos->title ?? null, ['class'=>'form-control', 'placeholder'=>'Enter blog category title']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('meta_title_bn', 'Seo Title_bn') !!}
            {!! Form::text('meta_title_bn',$projectCategory->seos->title_bn ?? null, ['class'=>'form-control', 'placeholder'=>'Enter seo title bn']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_keywords', 'Keywords') !!}
            {!! Form::text('meta_keywords', $projectCategory->seos->keywords ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('meta_keywords_bn', 'Keywords bn') !!}
            {!! Form::text('meta_keywords_bn', $projectCategory->seos->keywords_bn ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords bn']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_description', 'Seo Description ') !!}
            {!! Form::text('meta_description', $projectCategory->seos->description ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description']) !!}
        </div> <div class="col-md-6">
            {!! Form::label('meta_description_bn', 'Seo Description bn ') !!}
            {!! Form::text('meta_description_bn', $projectCategory->seos->description_bn ??null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description bn ']) !!}
        </div>

        <div class="col-md-8">
            {!! Form::label('og_image', 'Og image',['class'=>'label-style']) !!}
            {!! Form::file('og_image', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Og image']) !!}
            <div class="photo-preview-area" style="width: 250px; height: 150px">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($projectCategory?->seos?->og_image) ? asset(\App\Models\Seo::Seo_PHOTO_UPLOAD_PATH . $projectCategory?->seos?->og_image)  : asset('uploads/canvas.webp')}}"
                    alt="photo display area" class="photo photo-preview-area-photo"/>
            </div>
        </div>
    </div>
</fieldset>