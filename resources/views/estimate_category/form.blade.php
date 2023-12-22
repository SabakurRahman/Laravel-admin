<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>Estimate Category Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Category Name']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('slug', 'Slug') !!}
            {!! Form::text('slug', null, ['class'=>'form-control', 'placeholder'=>'Enter Slug']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('serial', 'Serial',['class'=>'label-style']) !!}
            {!! Form::number('serial', null, ['class'=>'form-control', 'placeholder'=>'Enter page serial']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('type', 'Type',['class'=>'label-style']) !!}
            {!! Form::select('type', \App\Models\EstimateCategory::TYPES_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Type']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('Status', 'Status',['class'=>'label-style']) !!}
            {!! Form::select('status', \App\Models\EstimateCategory::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('category_id', 'Parent Category') !!}
            {!! Form::select('category_id', $parentCategory, null, ['class' => 'form-select', 'placeholder' => 'Select Parent Category']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('description', 'Description',['class'=>'label-style']) !!}
            {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>'Enter Description']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
            {!! Form::file('photo', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
            <div class="photo-preview-area">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($EstimateCategory->photo) ? asset(\App\Models\EstimateCategory::PHOTO_UPLOAD_PATH.$EstimateCategory->photo)  : asset('uploads/canvas.webp')}}"
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
                    src="{{isset($EstimateCategory->banner) ? asset(\App\Models\EstimateCategory::BANNER_UPLOAD_PATH.$EstimateCategory->banner)  : asset('uploads/canvas.webp')}}"
                    alt="photo display area" class="photo photo-preview-area-photo"/>
            </div>
        </div>


    </div>
</fieldset>

<fieldset class="mt-4">
    <legend>Seo</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('meta_title', ' Seo Title') !!}
            {!! Form::text('meta_title',$EstimateCategory->seos->title ?? null, ['class'=>'form-control', 'placeholder'=>'Enter blog category title']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('meta_title_bn', 'Seo Title_bn') !!}
            {!! Form::text('meta_title_bn',$EstimateCategory->seos->title_bn ?? null, ['class'=>'form-control', 'placeholder'=>'Enter seo title bn']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_keywords', 'Keywords') !!}
            {!! Form::text('meta_keywords', $EstimateCategory->seos->keywords ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('meta_keywords_bn', 'Keywords bn') !!}
            {!! Form::text('meta_keywords_bn', $EstimateCategory->seos->keywords_bn ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords bn']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_description', 'Seo Description ') !!}
            {!! Form::text('meta_description', $EstimateCategory->seos->description ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description']) !!}
        </div> <div class="col-md-6">
            {!! Form::label('meta_description_bn', 'Seo Description bn ') !!}
            {!! Form::text('meta_description_bn', $EstimateCategory->seos->description_bn ??null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description bn ']) !!}
        </div>

        <div class="col-md-8">
            {!! Form::label('og_image', 'Og image',['class'=>'label-style']) !!}
            {!! Form::file('og_image', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Og image']) !!}
            <div class="photo-preview-area" style="width: 250px; height: 150px">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($EstimateCategory?->seos?->og_image) ? asset(\App\Models\Seo::Seo_PHOTO_UPLOAD_PATH . $EstimateCategory?->seos?->og_image)  : asset('uploads/canvas.webp')}}"
                    alt="photo display area" class="photo photo-preview-area-photo"/>
            </div>
        </div>
    </div>
</fieldset>
