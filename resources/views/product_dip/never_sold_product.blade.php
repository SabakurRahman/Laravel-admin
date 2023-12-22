@extends('layouts.admin-template.main')
@section('title', 'Never Sold Product')
@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('modules.product.partials.search')
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('product.show', $product->id) }}">
                                                <div data-bs-toggle="tooltip" title="{{ $product->name }}"
                                                    class="d-flex align-items-center">
                                                    @if (isset($product->primaryPhoto->photo) &&
                                                            file_exists(public_path(\App\Models\ProductPhoto::PRODUCT_PHOTO_UPLOAD_PATH_THUMB . $product?->primaryPhoto?->photo)))
                                                        <img src="{{ asset(\App\Models\ProductPhoto::PRODUCT_PHOTO_UPLOAD_PATH_THUMB . $product?->primaryPhoto?->photo) }}"
                                                            alt="{{ $product?->primaryPhoto?->alt_text }}"
                                                            title="{{ $product?->primaryPhoto?->title }}"
                                                            class="product-thumb-in-table me-2" />
                                                    @endif
                                                    <p class="single-line-text cursor-pointer">{{ $product->name }}</p>
                                                </div>
                                            </a>
                                        </td>
                                        <td>{{ $product->created_at->toDayDateTimeString() }}</td>
                                        <td>
                                            <a href="{{ route('product.show', $product->id) }}">
                                                <button class="btn btn-sm btn-success">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                            </a>

                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    {{ $products->links() }} <div class="form-group mt-2">
                        <div class="row">
                            <div class="col-lg-11 text-left">
                                {{ $products->appends(['perPage' => $perPage])->links() }}
                            </div>
                            <div class="col-lg-1">
                                @include('partials.pagination', ['pagination' => $products])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function changePerPage() {
            var perPage = document.getElementById('perPage').value;
            window.location.href = "{{ route('product.never_sold') }}?perPage=" + perPage;
        }
    </script>
@endpush
