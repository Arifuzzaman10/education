@extends('backEnd.master')
@section('title')
@lang('library.book_list')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-50 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('library.book_list')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('library.library')</a>
                <a href="#">@lang('library.book_list')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
    <div class="row mt-50">
        <div class="col-lg-12">
           <div class="row">
               <div class="col-lg-12">
                    <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                        <thead> 
                           
                            <tr>
                                <th>@lang('common.sl')</th>
                                <th>@lang('library.book_title')</th>
                                <th>@lang('library.book_no')</th>
                                <th>@lang('library.isbn_no')</th>
                                <th>@lang('student.category')</th>
                                {{-- <th>@lang('library.subject')</th> --}}
                                <th>@lang('library.publisher_name')</th>
                                <th>@lang('library.author_name')</th>
                                <th>@lang('library.quantity')</th>
                                <th>@lang('library.price')</th>
                                <th>@lang('common.action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php $count=1; @endphp
                            @foreach($books as $value)
                            <tr>
                                <td class="text-center">{{$count++}}</td>
                                <td class="text-center">{{$value->book_title}} </td>
                                <td class="text-center">{{$value->book_number}}</td>
                                <td class="text-center">{{$value->isbn_no}}</td>
                                <td class="text-center">
                                @if(!empty($value->book_category_id))
                                    {{(@$value->book_category_id != "")? $value->category_name:'' }}
                                @endif
                                </td>
                                {{-- <td class="text-center">
                                @if(!empty($value->subject_id))
                                    {{(@$value->subject_id != "")? $value->subject_name:'' }} 
                                @endif
                                </td> --}}
                                <td class="text-center">{{$value->publisher_name}}</td>
                                <td class="text-center">{{$value->author_name}}</td>
                                <td class="text-center">{{$value->quantity}}</td>
                               <td class="text-center">{{$value->book_price}}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                            @lang('common.select')
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                           @if(userPermission(302))
                                            <a class="dropdown-item" href="{{route('edit-book',$value->id)}}">@lang('common.edit')</a>
                                        @endif
                                        @if(userPermission(303))
                                            <a class="deleteUrl dropdown-item" data-modal-size="modal-md" title="{{ __('library.delete_book') }}" href="{{route('delete-book-view',$value->id   )}}">@lang('common.delete')</a>
                                        @endif
                                       </div>
                                   </div>
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
