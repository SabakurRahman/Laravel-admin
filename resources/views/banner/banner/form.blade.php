<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>Banner Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('title', 'Title',['class'=>'label-style']) !!}
            {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>'Enter title']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('serial', 'Order',['class'=>'label-style']) !!}
            {!! Form::text('serial', null, ['class'=>'form-control', 'placeholder'=>'Enter serial number']) !!}
        </div>


        <div class="col-md-6">
            {!! Form::label('Type', 'Type',['class'=>'label-style']) !!}
            {!! Form::select('type', \App\Models\Banner::TYPE_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select type']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('banner_size_id', 'Banner Size', ['class' => 'label-style']) !!}
            {!! Form::select('banner_size_id', $bannerSizeOptions, null, ['class' => 'form-select', 'placeholder' => 'Select Banner Size']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('Status', 'Status',['class'=>'label-style']) !!}
            {!! Form::select('status', \App\Models\Banner::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
            {!! Form::file('photo', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
            <div class="photo-preview-area">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($banner->photo) ? asset(\App\Models\Banner::PHOTO_UPLOAD_PATH.$banner->photo)  : asset('uploads/canvas.webp')}}"
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
            {!! Form::text('meta_title',$banner->seos->title ?? null, ['class'=>'form-control', 'placeholder'=>'Enter blog category title']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('meta_title_bn', 'Seo Title_bn', ['class'=>'mt-0']) !!}
            {!! Form::text('meta_title_bn',$banner->seos->title_bn ?? null, ['class'=>'form-control', 'placeholder'=>'Enter seo title bn']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_keywords', 'Keywords') !!}
            {!! Form::text('meta_keywords',isset( $banner) ?  $banner->seos->first()->keywords ?? null : null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('meta_keywords_bn', 'Keywords bn') !!}
            {!! Form::text('meta_keywords_bn',isset( $banner) ?  $banner->seos->first()->keywords_bn ?? null : null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords bn']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_description', 'Seo Description ') !!}
            {!! Form::text('meta_description', $banner->seos->description ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_description_bn', 'Seo Description bn ') !!}
            {!! Form::text('meta_description_bn', $banner->seos->description_bn ??null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description bn ']) !!}
        </div>

        <div class="col-md-8">
            {!! Form::label('og_image', 'Og image',['class'=>'label-style']) !!}
            {!! Form::file('og_image', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Og image']) !!}
            <div class="photo-preview-area" style="width: 250px; height: 150px">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($banner?->seos?->og_image) ? asset(\App\Models\Seo::Seo_PHOTO_UPLOAD_PATH . $banner?->seos?->og_image)  : asset('uploads/canvas.webp')}}"
                    alt="photo display area" class="photo photo-preview-area-photo"/>
            </div>
        </div>
    </div>
</fieldset>


