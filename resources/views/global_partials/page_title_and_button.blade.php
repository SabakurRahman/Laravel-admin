<div class="row mb-2">
    <div class="col-md-6">
        <h5>{{$page_content['page_title'] ?? null}}</h5>
    </div>
    <div class="col-md-6">
        <a href="{{$page_content['module_route'] ?? null}}" class="float-end">
            @isset($page_content['button_type'])
                <button class="btn btn-sm btn-success">
                    @if($page_content['button_type'] == 'list')
                        <i style="color:white" class="ri-list-check"></i> List
                    @elseif($page_content['button_type'] == 'Role')
                        <i style="color:white" class="ri-add-line"></i> Add New Role
                    @else
                        <i style="color:white" class="ri-add-line"></i> Add
                    @endif
                </button>
            @endisset
        </a>
    </div>
</div>
