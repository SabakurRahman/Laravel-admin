@push('script')
    <script>


        let product_specification = JSON.parse($('#product_specification_data_container').attr('data-product-specification'))



        let sp_indexs = [0]


        const generateSpElement = (index, specification = undefined) => {
            return `<div class="row mt-3 align-items-end" id="specifications_single_row_${index}">
            <div class="col-md-11">
                <div class="row">
                <div class="col-md-6">
                    <label class="w-100 mb-0">
                        Specification Name
                        <input value="${specification != undefined ? specification.name : ''}" name="specification[${index}][name]" type="text" class="form-control">
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="w-100 mb-0">
                        Specification Value
                        <input value="${specification != undefined ? specification.value : ''}" name="specification[${index}][value]" type="text" class="form-control">
                    </label>
                </div>
            </div>
            </div>
            <div class="col-md-1">
              <button type="button" data-index="${index}" class="btn btn-outline-danger remove-specification">
                <i class="ri-delete-bin-line"></i>
              </button>
            </div>
        </div>`
        }

        const displaySpElement = (specification = undefined) => {
            let field_element = $('#specifications_fields')
            let specification_element_data = generateSpElement(sp_indexs[sp_indexs.length - 1], specification)
            field_element.append(specification_element_data)
        }

        $('#add_more_specifications_field').on('click', function () {
            sp_indexs.push(sp_indexs[sp_indexs.length - 1] + 1)
            displaySpElement()
        })

       // displaySpElement()

        $(document).on('click', '.remove-specification', function () {
            let id = $(this).attr('data-index')
            $(`#specifications_single_row_${id}`).remove()
            sp_indexs.splice(id, 1)
        })

        product_specification.map((specification, index)=>{
            sp_indexs.push(sp_indexs[sp_indexs.length - 1] + 1)
            displaySpElement(specification)
        })

    </script>
@endpush
