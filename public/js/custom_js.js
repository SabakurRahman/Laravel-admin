const formatSlug = (str) => {
    return str
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '')
}
const resetFilters = () => {
    let url = new URL(window.location.href)
    url.search = '';
    window.location.href = url.toString()
}
const photo_preview = (files, is_allow_multiple = false) => {
    if (is_allow_multiple) {
        let photos = []
        for (let i = 0; i < files.length; i++) {
            photos[i] = URL.createObjectURL(files[i])
        }
        return photos
    } else {
        return URL.createObjectURL(files[0])
    }
}

$('.delete-button').on('click', function () {
    Swal.fire({
        title: 'Are you sure?',
        text: "Data will be deleted permanently!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $(this).parent('form').submit()
        }
    })
})

$('.photo-preview-area').on('click', function () {
    $(this).siblings('input[type="file"]').trigger('click')
})

$('.photo-input').on('change', function (e) {
    let photo = photo_preview(e.target.files)
    $(this).siblings('.photo-preview-area').children('.photo-preview-area-photo').attr('src', photo)
})

$('#name,#title').on('input', function () {
    let name = $(this).val()
    $('#slug').val(formatSlug(name))
    $('#meta_title').val(name)
    $('#meta_keywords').val(name.replaceAll(' ', ', '))
})
$('#reset_fields').on('click', function () {
    resetFilters()
})

tinymce.init({
    selector: 'textarea.tinymce',
    height: 500,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});
