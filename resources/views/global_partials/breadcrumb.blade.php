<style>
    .breadcrumb .breadcrumb-item a {
        text-decoration: none;
    }

    .breadcrumb .breadcrumb-item a h4 {
        text-decoration: none !important;
    }

    .page-title-box .breadcrumb .breadcrumb-item a h4 {
        text-decoration: none !important;
    }
</style>
@isset($page_content)
    <div class="row page-title-box align-items-center">
        <div class="col-md-4">
            <a href="{{route('front.index')}}"><h4 class="mb-0">{{__('Dashboard')}}</h4></a>
        </div>
        <div class="col-md-4">
            <h5 class="page-title">{{$page_content['page_title'] ?? null}}</h5>
        </div>
        <div class="col-md-4">
            <div class="d-flex justify-content-end align-items-center">
                <div class="page-title-right me-4">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{$page_content['module_route'] ?? '#' }} ">{{$page_content['module_name'] ?? null}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{$page_content['sub_module_name'] ?? null}}</li>
                    </ol>
                </div>
                <a href="{{$page_content['module_route'] ?? null}}" class="float-end">
                    @isset($page_content['button_type'])
                        <button class="btn btn-sm btn-outline-theme">
                            @if($page_content['button_type'] == 'list')
                                <i class="ri-list-check"></i> List
                            @elseif($page_content['button_type'] == 'Role')
                                <i class="ri-add-line"></i> Add New Role
                            @else
                                <i class="ri-add-line"></i> Add
                            @endif
                        </button>
                    @endisset
                </a>
            </div>
        </div>
    </div>
@endisset

