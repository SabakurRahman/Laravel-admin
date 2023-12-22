@push('script')
    <script>
        let category_data = JSON.parse($('#category_data').attr('data-category'))
        let sub_category_data = JSON.parse($('#sub_category_data').attr('data-sub-category'))
        $('#type').on('change', function () {
            handleTypeInput($(this).val())
        })
        const handleTypeInput = (type) => {
            let selected_category = category_data.filter((category, index) => (
                category.type == type
            ))
            $('#estimate_sub_category_id').empty()
            let category_element = $('#estimate_category_id')
            category_element.empty()
            category_element.append(`<option>Select category</option>`)
            selected_category.map((category, index) => {
                category_element.append(`<option value="${category.id}">${category.name}</option>`)
            })
            handleDisplayPackageArea()
        }
        $('#estimate_category_id').on('change', function () {
            let category_id = $(this).val()
            handleCategoryInput(category_id)
        })
        const handleCategoryInput = (category_id) => {
            let selected_sub_category = sub_category_data.filter((sub_category, index) => (
                sub_category.category_id == category_id
            ))
            let sub_category_element = $('#estimate_sub_category_id')
            sub_category_element.empty()
            sub_category_element.append(`<option>Select Sub Category</option>`)
            selected_sub_category.map((sub_category, index) => {
                sub_category_element.append(`<option value="${sub_category.id}">${sub_category.name}</option>`)
            })
            handleDisplayPackageArea()
        }
        $('#estimate_sub_category_id').on('change', function () {
            handleDisplayPackageArea()
        })
        const handleDisplayPackageArea = () => {
            let type_id = $('#type').val()
            let estimated_category_id = $('#estimate_category_id').val()
            let estimated_sub_category_id = $('#estimate_sub_category_id').val()
            console.log(type_id, estimated_category_id, estimated_sub_category_id)
            if (!isNaN(type_id) && !isNaN(estimated_category_id) && !isNaN(estimated_sub_category_id)) {
                $('#package_display_area').slideDown()
            } else {
                $('#package_display_area').slideUp()
            }
        }
        if ('{{$errors->any()}}' || '{{isset($unit_price)}}') {
            if ('{{old('type')}}' || '{{isset($unit_price->type)}}') {
                let old_type = '{{old('type')}}'
                let new_type = '{{$unit_price->type ?? null}}'
                let type = old_type != '' ? old_type : new_type
                handleTypeInput(type)
                if ('{{old('estimate_category_id')}}' || '{{isset($unit_price->estimate_category_id)}}') {
                    let old_estimate_category_id = '{{old('estimate_category_id')}}'
                    let new_estimate_category_id = '{{$unit_price->estimate_category_id ?? null}}'
                    let estimate_category_id = old_estimate_category_id != '' ? old_estimate_category_id : new_estimate_category_id
                    $('#estimate_category_id').val(estimate_category_id)
                    handleCategoryInput(estimate_category_id)
                    if ('{{old('estimate_sub_category_id')}}' || '{{isset($unit_price->estimate_sub_category_id)}}') {
                        let old_estimate_sub_category_id = '{{old('estimate_sub_category_id')}}'
                        let new_estimate_sub_category_id = '{{$unit_price->estimate_sub_category_id ?? null}}'
                        let estimate_sub_category_id = old_estimate_sub_category_id != '' ? old_estimate_sub_category_id : new_estimate_sub_category_id
                        $('#estimate_sub_category_id').val(estimate_sub_category_id)
                        handleDisplayPackageArea()
                    }
                }
            }
        }
    </script>
@endpush
