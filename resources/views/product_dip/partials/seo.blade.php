<div class="tab-pane fade" id="seo" role="tabpanel">
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('title', 'Meta title') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Meta title']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('keywords', 'Meta keywords') !!}
            {!! Form::text('keywords', null, ['placeholder' => 'Meta keywords']) !!}
        </div>
        <div class="col-md-12 mt-3">
            {!! Form::label('seo_description', 'Meta description') !!}
            {!! Form::textarea('seo_description', null, ['class' => 'form-control', 'placeholder' => 'Meta description']) !!}
        </div>
        <div class="col-md-6 mt-3">
            {!! Form::label('og_image', 'OG Image') !!}
            {!! Form::file('og_image', ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6 mt-3">
            <img
                src=""
                style="display: none"
                class="img-thumbnail"
                id="photo_preview"
                alt="Profile Photo"
            />
        </div>
    </div>
</div>
@push('script')
    <script>
        $('#og_image').on('change', function (e) {
            let files = e.target.files
            let image = photo_preview(files, false)
            $('#photo_preview').attr('src', image).slideDown()
        })
        new TomSelect("#keywords", {
            persist: false,
            createOnBlur: true,
            create: true
        });
    </script>
@endpush
