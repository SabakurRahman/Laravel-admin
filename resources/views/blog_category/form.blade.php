<fieldset>
    <legend>Basic Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter blog category name']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('slug', 'Slug') !!}
            {!! Form::text('slug', null, ['class'=>'form-control', 'placeholder'=>'Enter slug']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('Status', 'Status') !!}
            {!! Form::select('status', \App\Models\BlogCategory::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select status']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('Type', 'type') !!}
            {!! Form::select('type', \App\Models\BlogCategory::TYPE_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select type']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
            {!! Form::file('photo', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
            <div class="photo-preview-area">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($blogCategory->photo) ? asset(\App\Models\BlogCategory::PHOTO_UPLOAD_PATH.$blogCategory->photo)  : asset('uploads/canvas.webp')}}"
                    alt="photo display area" class="photo photo-preview-area-photo"/>
            </div>
        </div>
        <div class="col-md-6">
            {!! Form::label('cover_photo', 'Cover Photo',['class'=>'label-style']) !!}
            {!! Form::file('cover_photo', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
            <div class="photo-preview-area" style="width: 250px; height: 150px">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($blogCategory->cover_photo) ? asset(\App\Models\BlogCategory::COVER_PHOTO_UPLOAD_PATH.$blogCategory->cover_photo)  : asset('uploads/canvas.webp')}}"
                    alt="photo display area" class="photo photo-preview-area-photo"/>
            </div>
        </div>
    </div>
</fieldset>
<fieldset class="mt-4">
    <legend>Seo</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('meta_title', ' Seo Title', ['class'=>'mt-0']) !!}
            {!! Form::text('meta_title',$blogCategory->seos->title ?? null, ['class'=>'form-control', 'placeholder'=>'Enter blog category title']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('meta_title_bn', 'Seo Title_bn', ['class'=>'mt-0']) !!}
            {!! Form::text('meta_title_bn',$blogCategory->seos->title_bn ?? null, ['class'=>'form-control', 'placeholder'=>'Enter seo title bn']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_keywords', 'Keywords') !!}
            {!! Form::text('meta_keywords',isset( $blogCategory) ?  $blogCategory?->seos?->keywords ?? null : null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('meta_keywords_bn', 'Keywords bn') !!}
            {!! Form::text('meta_keywords_bn',isset( $blogCategory) ?  $blogCategory?->seos?->keywords_bn ?? null : null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords bn']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_description', 'Seo Description ') !!}
            {!! Form::text('meta_description', $blogCategory->seos->description ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_description_bn', 'Seo Description bn ') !!}
            {!! Form::text('meta_description_bn', $blogCategory->seos->description_bn ??null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description bn ']) !!}
        </div>

        <div class="col-md-8">
            {!! Form::label('og_image', 'Og image',['class'=>'label-style']) !!}
            {!! Form::file('og_image', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Og image']) !!}
            <div class="photo-preview-area" style="width: 250px; height: 150px">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($blogCategory?->seos?->og_image) ? asset(\App\Models\Seo::Seo_PHOTO_UPLOAD_PATH . $blogCategory?->seos?->og_image)  : asset('uploads/canvas.webp')}}"
                    alt="photo display area" class="photo photo-preview-area-photo"/>
            </div>
        </div>
    </div>
</fieldset>

