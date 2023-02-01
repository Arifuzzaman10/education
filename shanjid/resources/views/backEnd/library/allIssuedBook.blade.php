@extends('backEnd.master')
@section('title')
@lang('library.issued_Book_List')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('library.issued_Book_List')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('library.library')</a>
                    <a href="#">@lang('library.issued_Book_List')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30 ">@lang('common.select_criteria')</h3>
                    </div>
                </div>
                <div class="col-lg-4 text-md-right text-left col-md-6 mb-30-lg">
                    <a href="{{route('addStaff')}}" class="primary-btn small fix-gr-bg">
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'search-issued-book', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        <div class="row">
                            <div class="col-lg-4">
                                <select class="niceSelect w-100 bb form-control" name="book_id" id="book_id">
                                    <option data-display="@lang('library.select_Book_Name')" value="">@lang('common.select') </option>
                                    @foreach($books as $key=>$value)
                                        <option value="{{$value->id}}" {{isset($book_id)? ($book_id == $value->id? 'selected':''):''}}>{{$value->book_title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4 mt-30-md">
                                <div class="input-effect">
                                    <input class="primary-input" type="text" name="book_number"
                                            value="{{isset($book_number)? $book_number:''}}">
                                    <label>@lang('library.search_By_Book_ID')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-30-md">
                                <select class="niceSelect w-100 bb form-control" name="subject_id" id="subject_id">
                                    <option data-display="@lang('common.select_subjects')"
                                            value="">@lang('common.select') </option>
                                    @foreach($subjects as $key=>$value)
                                        <option value="{{$value->id}}" {{isset($subject_id)? ($subject_id == $value->id? 'selected':''):''}}>
                                            {{$value->subject_name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg">
                                    <span class="ti-search pr-2"></span>
                                    @lang('common.search')
                                </button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('library.all_issued_book')</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>@lang('library.book_title')</th>
                                    <th>@lang('library.book_no')</th>
                                    <th>@lang('library.isbn_no')</th>
                                    <th>@lang('library.member_name')</th>
                                    <th>@lang('library.author')</th>
                                    {{-- <th>@lang('library.subject')</th> --}}
                                    <th>@lang('library.issue_date')</th>
                                    <th>@lang('library.return_date')</th>
                                    <th>@lang('common.status')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($issueBooks as $value)
                                    <tr>
                                        <td>{{$value->books->book_title}}</td>
                                        <td>{{$value->books->book_number}}</td>
                                        <td>{{$value->books->isbn_no}}</td>
                                        <td>{{$value->memberDetails}}</td>
                                        <td>{{@$value->books->author_name}}</td>
                                        {{-- <td>{{$value->subject_name}}</td> --}}
                                        <td  data-sort="{{strtotime($value->given_date)}}">{{ $value->given_date != ""? dateConvert($value->given_date):''}} </td>
                                        <td  data-sort="{{strtotime($value->due_date)}}">{{$value->due_date != ""? dateConvert($value->due_date):''}}</td>
                                        <td>
                                            @if($value->issue_status == 'I')
                                                <button class="primary-btn small bg-success text-white border-0">
                                                     @lang('library.issued')
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
