@push('script')
    <script>
        let editor_config = {
            path_absolute : "/",
            selector: '#description,#description_bn',
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            file_picker_callback : function(callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                let cmsURL = editor_config.path_absolute + 'file-manager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };

        tinymce.init(editor_config);


        // tinyMCE.init({
        //     selector: '#description,#description_bn',
        //     height: 300,
        //     menubar: false,
        //     plugins: [
        //         'advlist autolink lists link image charmap print preview anchor textcolor',
        //         'searchreplace visualblocks code fullscreen',
        //         'insertdatetime media table paste code help wordcount'
        //     ],
        //     toolbar: 'undo redo | formatselect | bold italic backcolor | \
        //                         alignleft aligncenter alignright alignjustify | \
        //                         bullist numlist outdent indent | removeformat | help',
        //     // content_css: '//www.tiny.cloud/css/codepen.min.css'
        // });

        img.onchange = evt => {
            const [file] = img.files
            if (file) {
                prview.style.visibility = "visible";
                prview.src = photo_preview(evt.target.files);
            }
        }

        img2.onchange = evt => {
            const [file] = img2.files
            if (file) {
                prview2.style.visibility = "visible";
                prview2.src = photo_preview(evt.target.files);
            }
        }

        img3.onchange = evt => {
            const [file] = img3.files
            if (file) {
                prview3.style.visibility = "visible";
                prview3.src = photo_preview(evt.target.files);
            }
        }
        $('#categories_select').select2({
            placeholder: 'Select Category',
        })



        const triggerTabList = document.querySelectorAll('#myTab button')
        triggerTabList.forEach(triggerEl => {
            const tabTrigger = new bootstrap.Tab(triggerEl)

            triggerEl.addEventListener('click', event => {
                event.preventDefault()
                tabTrigger.show()
            })
        })
        const triggerEl = document.querySelector('#myTab button[data-bs-target="#profile"]')
        bootstrap.Tab.getInstance(triggerEl).show() // Select tab by name

        const triggerFirstTabEl = document.querySelector('#myTab li:first-child button')
        bootstrap.Tab.getInstance(triggerFirstTabEl).show() // Select first tab
    </script>
@endpush
