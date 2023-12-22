@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}

    <fieldset>
        <legend>Basic Information</legend>
        <table class="table table-striped">
            <tr>
                <th scope="row">Id</th>
                <td>{{$faq->id}}</td>
            </tr>
            <tr>
                <th scope="row">Question</th>
                <td>{{$faq->question_title}}</td>
            </tr>
            <tr>
                <th scope="row">Answer</th>
                <td>{{strip_tags($faq->description)}}</td>
            </tr>
            <tr>
                <th scope="row">Status</th>
                <td>{{ \App\Models\Faq::STATUS_LIST[$faq->status]}}</td>
            </tr>
            <tr>
                <th scope="row">Faq Page Name</th>
                <td>{{ $faq->faq_page->name }}</td>
            </tr>
            <tr>
                <th scope="row">Created at</th>
                <td>{{$faq->created_at->format('j M, Y    D ,g:i A')}} </td>
            </tr>
            {{-- <tr>
                <th scope="row">Updated at</th>
                <td>
                    {{ $faq->created_at != $faq->updated_at ? $faq->updated_at->format('D, M j, Y g:i A') : 'Not updated' }}
                </td>

            </tr> --}}
        </table>
    </fieldset>
    @include('global_partials.activity_log', ['activity_logs'=> $faq?->activity_logs])
@endsection


