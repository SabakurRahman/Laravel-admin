@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}

    <fieldset>
        <legend>Basic Information</legend>
        <table class="table table-striped">
            <tr>
                <th scope="row">Id</th>
                <td>{{$faqPage->id}}</td>
            </tr>
            <tr>
                <th scope="row">name</th>
                <td>{{$faqPage->name}}</td>
            </tr>
            <tr>
                <th scope="row">slug</th>
                <td>{{$faqPage->slug}}</td>
            </tr>
            <tr>
                <th scope="row">serial</th>
                <td>{{$faqPage->serial}}</td>
            </tr>

            <tr>
                <th scope="row">Status</th>
                <td>{{ \App\Models\FaqPage::STATUS_LIST[$faqPage->status]}}</td>
            </tr>
            <tr>
                <th scope="row">Created at</th>
                <td>{{$faqPage->created_at->format('D, M j, Y g:i A')}} </td>
            </tr>
            <tr>
                <th scope="row">Updated at</th>
                <td>
                    {{ $faqPage->created_at != $faqPage->updated_at ? $faqPage->updated_at->format('D, M j, Y g:i A') : 'Not updated' }}
                </td>

            </tr>
        </table>
    </fieldset>
    @include('global_partials.activity_log', ['activity_logs'=> $faqPage?->activity_logs])
@endsection


