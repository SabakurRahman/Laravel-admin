@extends('frontend.layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card mt-3 p-3">
                <form method="POST" action="{{ route('faq-pages.store') }}" >
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" .>
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" class="form-control" .>
                        @error('slug')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>description</label>
                        <input type="text" name="description" class="form-control" .>
                        @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>serial</label>
                        <input type="text" name="serial" class="form-control" .>
                        @error('serial')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <select class="form-select" name="status" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <button type="submit" class="btn btn-dark mt-2">Submit</button>
                </form>
            </div>
        </div>

    </div>


@endsection
