<fieldset>
    <legend>Basic Information</legend>
<div class="row">
    <div class="col-md-6">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', $user->name, ['class'=>'form-control', 'placeholder'=>'Enter Name']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', $user->email, ['class'=>'form-control', 'placeholder'=>'Enter Email']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('phone', 'Phone') !!}
        <div class="input-group">
            {!! Form::tel('phone',  $user->phone, ['class' => 'form-control', 'placeholder' => 'Enter Phone Number']) !!}
        </div>
    </div>


    <div class="col-md-6">
        {!! Form::label('date_of_birth', 'Date of Birth') !!}
        {!! Form::input('date', 'date_of_birth', null, ['class' => 'form-control', 'placeholder' => 'Select Date of Birth']) !!}
    </div>

    <div class="col-md-6">
        {!! Form::label('national_id_card_no', 'National Id') !!}
        {!! Form::text('national_id_card_no', null, ['class'=>'form-control', 'placeholder'=>'Enter National Id Number']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('emergency_contact_no', 'Emergency Contact') !!}
        {!! Form::text('emergency_contact_no',  null, ['class'=>'form-control', 'placeholder'=>'Enter Emergency Contact Number']) !!}
    </div>

    <div class="col-md-6">
        {!! Form::label('profile_photo', 'Profile Photo',['class'=>'label-style']) !!}
        {!! Form::file('profile_photo', ['class'=>'form-control form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
        <div class="photo-preview-area" style="width: 250px; height: 150px">
            <i class="ri-camera-line"></i>
            <div class="overly"></div>
            <img
                src="{{isset($userProfile->profile_photo) ? asset(\App\Models\UserProfile::PHOTO_UPLOAD_PATH.$userProfile->profile_photo)  : asset('uploads/canvas.webp')}}"
                alt="photo display area" class="photo photo-preview-area-photo"/>
        </div>
    </div>
    <div class="col-md-6">
        {!! Form::label('national_id_photo', 'National Id Photo',['class'=>'label-style']) !!}
        {!! Form::file('national_id_photo', ['class'=>'form-control form-control d-none photo-input', 'placeholder'=>'Enter Profile Photo']) !!}
        <div class="photo-preview-area" style="width: 250px; height: 150px">
            <i class="ri-camera-line"></i>
            <div class="overly"></div>
            <img
                src="{{isset($userProfile->national_id_photo) ? asset(\App\Models\UserProfile::NATIONAL_ID_PHOTO_UPLOAD_PATH.$userProfile->national_id_photo)  : asset('uploads/canvas.webp')}}"
                alt="photo display area" class="photo photo-preview-area-photo"/>
        </div>
    </div>
</div>
</fieldset>
