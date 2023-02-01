<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('exam.mark_sheet_report')</title>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        body{
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact;
        }
        table {
            border-collapse: collapse;
        }
        h1,h2,h3,h4,h5,h6{
            margin: 0;
            color: #00273d;
        }
        .invoice_wrapper{
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 20px;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
        .border_none{
            border: 0px solid transparent;
            border-top: 0px solid transparent !important;
        }
        .invoice_part_iner{
            background-color: #fff;
        }
        .invoice_part_iner h4{
            font-size: 30px;
            font-weight: 500;
            margin-bottom: 40px;
    
        }
        .invoice_part_iner h3{
            font-size:25px;
            font-weight: 500;
            margin-bottom: 5px;
    
        }
        .table_border thead{
            background-color: #F6F8FA;
        }
        .table td, .table th {
            padding: 5px 0;
            vertical-align: top;
            border-top: 0 solid transparent;
            color: #79838b;
        }
        .table td , .table th {
            padding: 5px 0;
            vertical-align: top;
            border-top: 0 solid transparent;
            color: #79838b;
        }
        .table_border tr{
            border-bottom: 1px solid #dee2e6  !important;
        }
        th p span, td p span{
            color: #212E40;
        }
        .table th {
            color: #00273d;
            font-weight: 300;
            border-bottom: 1px solid #dee2e6  !important;
            background-color: #fafafa;
        }
        p{
            font-size: 14px;
        }
        h5{
            font-size: 12px;
            font-weight: 500;
        }
        h6{
            font-size: 10px;
            font-weight: 300;
        }
        .mt_40{
            margin-top: 40px;
        }
        .table_style th, .table_style td{
            padding: 20px;
        }
        .invoice_info_table td{
            font-size: 10px;
            padding: 0px;
        }
        .invoice_info_table td h6{
            color: #6D6D6D;
            font-weight: 400;
            }

        .text_right{
            text-align: right;
        }
        .virtical_middle{
            vertical-align: middle !important;
        }
        .thumb_logo {
            max-width: 120px;
        }
        .thumb_logo img{
            width: 100%;
        }
        .line_grid{
            display: flex;
            grid-gap: 10px;
            font-weight: 500;
            font-weight: 600;
            color: #415094;
            font-size: 14px
        }
        .line_grid span{
            font-weight: 500;
        }
        .line_grid span{
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex: 150px 0 0;
        }
        .line_grid span:first-child{
            font-weight: 500;
            color: #828bb2;
            font-size: 14px;
        }
        p{
            margin: 0;
        }
        .font_18 {
            font-size: 18px;
        }
        .mb-0{
            margin-bottom: 0;
        }
        .mb_30{
            margin-bottom: 30px !important;
        }
        .border_table thead tr th {
            padding: 12px 10px;
        }
        .border_table tbody tr td {
            text-align: left !important;
            border: 0;
            color: #828bb2;
            padding: 8px 8px;
            font-weight: 400;
            font-size: 12px;
            padding: 11px 8px;
        
        }
        .logo_img{
            display: flex;
            align-items: center;
            background: url({{asset('public/backEnd/img/report-admit-bg.png')}}) no-repeat center;
            background-size: auto;
            background-size: cover;
            border-radius: 5px 5px 0px 0px;
            border: 0;
            padding: 20px;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .logo_img h3{
            font-size: 25px;
            margin-bottom: 5px;
            color: #fff;
        }
        .logo_img h5{
            font-size: 14px;
            margin-bottom: 0;
            color: #fff;
        }
        .company_info{
            margin-left: 20px;
        }

        .table_title{
            text-align: center;
        }
        .table_title h3{
            font-size: 24px;
            text-transform: uppercase;
            margin-top: 15px;
            font-weight: 500;
            display: inline-block;
            border-bottom: 2px solid #415094;
        }
        .gray_header_table{
            /* border: 1px solid #DDDDDD; */
        }
        
        .max-width-400{
            width: 400px;
        }
        .max-width-500{
            width: 500px;
        }

        .max-width-550{
            width: 550px;
        }
        .ml_auto{
            margin-left: auto;
            margin-right: 0;
        }
        .mr_auto{
            margin-left: 0;
            margin-right: auto;
        }
        .margin-auto{
          margin: auto;
        }

        .thumb.text-right {
            text-align: right;
        }
        .profile_thumb {
            flex-grow: 0;
            text-align: right;
        }
        .line_grid .student_name{
            font-weight: 500;
            font-size: 14px;
            color: #415094;
        }
        .line_grid span {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex: 110px 0 0;
        }
        .line_grid.line_grid2 span {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex: 100px 0 0;
        }
        .student_name_highlight{
            font-weight: 500;
            color: #415094;
            line-height: 1.5;
            font-size: 20px;
            text-transform: uppercase;

        }
        .report_table th {
            border: 1px solid #dee2e6;
            color: #415094;
            font-weight: 500;
            text-transform: uppercase;
            vertical-align: middle;
            font-size: 12px;
        }
        .report_table th, .report_table td{
            background: transparent !important;
        }

        .gray_header_table thead th{
            text-transform: uppercase;
            font-size: 12px;
            color: #415094;
            font-weight: 500;
            text-align: left;
            border-bottom: 1px solid #a2a8c5;
            padding: 5px 0px;
            background: transparent !important ;
            border-bottom: 1px solid rgba(67, 89, 187, 0.15) !important;
            padding-left: 0px !important;
        }
        .gray_header_table {
            border: 0;
        }
        .gray_header_table tbody td, .gray_header_table tbody th {
            border-bottom: 1px solid rgba(67, 89, 187, 0.15) !important;
        }
        .max-width-400{
            width: 400px;
        }
        .max-width-500{
            width: 500px;
        }
        .ml_auto{
            margin-left: auto;
            margin-right: 0;
        }
        .mr_auto{
            margin-left: 0;
            margin-right: auto;
        }
        .margin-auto{
          margin: auto;
        }

        .thumb.text-right {
            text-align: right;
        }
        .tableInfo_header{
            background: url({{asset('public/backEnd/')}}/img/report-admit-bg.png) no-repeat center;
            background-size: cover;
            border-radius: 5px 5px 0px 0px;
            border: 0;
            padding: 30px 30px;
        }
        .tableInfo_header td{
            padding: 30px 40px;
        }
        .company_info{
            margin-left: 100px;
        }
        .company_info p{
            font-size: 14px;
            color: #fff;
            font-weight: 400;
            margin-bottom: 10px;
        }
        .company_info h3{
            font-size: 18px;
            color: #fff;
            font-weight: 500;
            margin-bottom: 15px;
        }
        .meritTableBody{
            padding: 30px;
            background: -webkit-linear-gradient(
            90deg
            , #d8e6ff 0%, #ecd0f4 100%);
                background: -moz-linear-gradient(90deg, #d8e6ff 0%, #ecd0f4 100%);
                background: -o-linear-gradient(90deg, #d8e6ff 0%, #ecd0f4 100%);
                background: linear-gradient(
            90deg
            , #d8e6ff 0%, #ecd0f4 100%);
        }

        .meritTableBodyCustomReport{
            padding: 30px;
        }
        .subject_title{
            font-size: 18px;
            font-weight: 600;
            font-weight: 500;
            color: #415094;
            line-height: 1.5;
        }
        .subjectList{
            display: grid;
            grid-template-columns: repeat(2,1fr);
            grid-column-gap: 40px;
            grid-row-gap: 9px;
            margin: 0;
            padding: 0;

        }
        .subjectList li{
            list-style: none;
            color: #828bb2;
            font-size: 14px;
            font-weight: 400
        }
        .table_title{
            font-weight: 500;
            color: #415094;
            line-height: 1.5;   
            font-size: 18px;
            text-align: left
        }
        .gradeTable_minimal.border_table tbody tr td {
            text-align: left !important;
            border: 0;
            color: #828bb2;
            padding: 8px 8px;
            font-weight: 400;
            font-size: 12px;
            padding: 3px 8px;
        }

        .profile_thumb img {
            border-radius: 5px;
        }
        .gray_header_table thead tr:first-child th {
            border: 0 !important;
        }
        .gray_header_table thead tr:last-child th {
            border-bottom: 1px solid rgba(67, 89, 187, 0.15) !important;
        }

        .profile_100{
            width: 100px;
            height: 100px;
            background-size: cover;
            background-position: center center;
            border-radius: 5px;
            background-repeat: no-repeat;
            margin-left: auto;
        }

        .custom_result_print{
            background-image: none;
        }
        .custom_result_print h3, .custom_result_print h5{
            color: black;
        }

    </style>
</head>
<script>
    var is_chrome = function () { return Boolean(window.chrome); }
    if(is_chrome) 
    {
       window.print();
    // setTimeout(function(){window.close();}, 10000); 
    //give them 10 seconds to print, then close
    }
    else
    {
       window.print();
    }
</script>
<body onLoad="loadHandler();">
    <div class="invoice_wrapper">
        <!-- invoice print part here -->
        <div class="invoice_print mb-0">
            <div class="container">
                <div class="invoice_part_iner">
                    <table class="table border_bottom mb-0" >
                        <thead>
                            <td style="padding: 0">
                                <div class="{{(resultPrintStatus('header'))? "logo_img": "logo_img custom_result_print"}}">
                                    <div class="thumb_logo">
                                        <img  src="{{asset('/')}}{{generalSetting()->logo }}" alt="{{generalSetting()->school_name}}">
                                    </div>
                                    <div class="company_info">
                                        <h3>{{isset(generalSetting()->school_name)?generalSetting()->school_name:'Infix School Management ERP'}} </h3>
                                        <h5>{{isset(generalSetting()->address)?generalSetting()->address:'Infix School Address'}}</h5>
                                        <h5>
                                            @lang('common.email'): {{isset(generalSetting()->email)?generalSetting()->email:'admin@infixedu.com'}} 
                                            @lang('common.phone'): {{isset(generalSetting()->phone)?generalSetting()->phone:'+8801841412141'}}
                                        </h5>
                                    </div>

                                    @if(resultPrintStatus('image'))
                                        <div class="profile_thumb profile_100" style="background-image: url({{ file_exists(@$studentDetails->studentDetail->student_photo) ? asset($studentDetails->studentDetail->student_photo) : asset('public/uploads/staff/demo/staff.jpg') }})"></div>
                                    @endif
                                </div>
                            </td>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- invoice print part end -->

        <div class="{{(resultPrintStatus('body'))? "meritTableBody": "meritTableBodyCustomReport"}}">
            <!-- middle content  -->
            <div class="student_name_highlight">
                {{$student_detail->studentDetail->full_name}}
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                           <!-- single table  -->
                           <table class="mb_30 max-width-550 mr_auto">
                               <tbody>
                                   <tr>
                                        <td>
                                            <p class="line_grid">
                                                <span>
                                                    <span>@lang('common.class')</span>
                                                    <span>:</span>
                                                </span>
                                                <span class="student_name bold_text">
                                                    {{$student_detail->class->class_name}}
                                                </span>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="line_grid line_grid2">
                                                <span>
                                                    <span>@lang('student.roll_no')</span>
                                                    <span>:</span>
                                                </span>
                                                <span class="student_name bold_text">
                                                    {{$student_detail->roll_no}}
                                                </span>
                                            </p>
                                        </td>
                                   </tr>
                                   <tr>
                                        
                                        <td>
                                            <p class="line_grid" >
                                                <span>
                                                    <span>@lang('common.section')</span>
                                                    <span>:</span>
                                                </span>
                                                {{$student_detail->section->section_name}}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="line_grid line_grid2" >
                                                <span>
                                                    <span>@lang('exam.exam')</span>
                                                    <span>:</span>
                                                </span>
                                                {{$exam_details->title}}
                                            </p>
                                        </td>
                                   </tr>
                                   <tr>
                                        
                                        <td>
                                            <p class="line_grid" >
                                                <span>
                                                    <span>@lang('student.admission_no')</span>
                                                    <span>:</span>
                                                </span>
                                                <span class="student_name bold_text">
                                                    {{$student_detail->studentDetail->admission_no}}
                                                </span>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="line_grid line_grid2" >
                                                <span>
                                                    <span>@lang('common.date_of_birth')</span>
                                                    <span>:</span>
                                                </span>
                                                {{$student_detail->studentDetail->date_of_birth != ""? dateConvert($student_detail->studentDetail->date_of_birth):''}}
                                            </p>
                                        </td>
                                   </tr>
                               </tbody>
                           </table>
                           <!--/ single table  -->
                        </td>
                        <td>
                            <!-- single table  -->
                            @if(@$grades)
                            <table class="table border_table gray_header_table mb_30 max-width-400 ml_auto gradeTable_minimal" >
                                <thead>
                                    <tr>
                                        <th>@lang('exam.starting')</th>
                                        <th>@lang('reports.ending')</th>
                                        @if (@generalSetting()->result_type != 'mark')
                                            <th>@lang('exam.gpa')</th>
                                            <th>@lang('exam.grade')</th>
                                        @endif       
                                        <th>@lang('homework.evalution')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($grades as $grade_d)
                                  <tr>
                                     <td>{{$grade_d->percent_from}}</td>
                                     <td>{{$grade_d->percent_upto}}</td>
                                     @if (@generalSetting()->result_type != 'mark')
                                        <td>{{$grade_d->gpa}}</td>
                                        <td>{{$grade_d->grade_name}}</td>
                                     @endif
                                     <td>{{$grade_d->description}}</td>
                                  </tr>
                                 @endforeach
                                </tbody>
                            </table>
                            @endif
                            <!--/ single table  -->
                        </td>
                    </tr>
                </tbody>
            </table>



            <table class="table border_table gray_header_table mb-0" >
                <thead>
                <tr>
                    <th >@lang('exam.subject_name')</th>
                    <th colspan="5">{{$exam_details->title}}</th>
                </tr>
                <tr>
                    <th></th>
                    <th>@lang('exam.total_mark')</th>
                    <th>@lang('exam.highest_marks')</th>
                    <th>@lang('exam.obtained_marks')</th>
                    @if (@generalSetting()->result_type != 'mark')
                        <th>@lang('reports.letter_grade')</th>
                    @endif
                    <th>@lang('reports.remarks')</th>
                    @if (@generalSetting()->result_type == 'mark')
                        <th>@lang('homework.evaluation')</th>
                        <th>@lang('exam.pass_fail')</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @php
                    $main_subject_total_gpa=0;
                    $Optional_subject_count=$subjects->count();
                    $sum_gpa= 0;  
                    $resultCount=1; 
                    $subject_count=1; 
                    $tota_grade_point=0; 
                    $this_student_failed=0; 
                    $count=1;
                    $temp_grade=[];
                    $total_mark=0;
                    $student_full_mark=0;
                    function differences($array1, $array2){
                        return array_merge(array_diff($array1,$array2),array_diff($array2,$array1));
                    }
                @endphp
                @foreach($mark_sheet as $key=>$data)
                @php
                    $temp_grade[]=$data->total_gpa_grade;
                    $student_full_mark+=@$data->total_marks;
                @endphp
                <tr>
                    <td colspan="1">{{$data->subject->subject_name}}</td>
                    <td>
                        @if (@generalSetting()->result_type == 'mark')
                            {{subject100PercentMark()}}
                        @else
                            {{@subjectFullMark($exam_details->id, $data->subject->id, $class_id, $section_id)}}
                        @endif
                    </td>
                    <td>
                        @if (@generalSetting()->result_type == 'mark')
                            {{subjectPercentageMark(@subjectHighestMark($exam_type_id, $data->subject->id, $class_id, $section_id), @subjectFullMark($exam_details->id, $data->subject->id, $class_id, $section_id))}}
                        @else
                            {{@subjectHighestMark($exam_type_id, $data->subject->id, $class_id, $section_id)}}
                        @endif
                    </td>
                    <td>
                        @if (@generalSetting()->result_type == 'mark')
                            {{subjectPercentageMark(@$data->total_marks, @subjectFullMark($exam_details->id, $data->subject->id, $class_id, $section_id))}}
                        @else
                            {{@$data->total_marks}}
                        @endif
                        
                        @php
                            if(@generalSetting()->result_type == 'mark'){
                                $total_mark+=subjectPercentageMark(@$data->total_marks, @subjectFullMark($exam_details->id, $data->subject->id, $class_id, $section_id));
                            }else{
                                $total_mark+=@$data->total_marks;
                            }
                        @endphp
                    </td>
                    @if (@generalSetting()->result_type != 'mark')
                        <td>
                            {{@$data->total_gpa_grade}}
                            @php
                            $result = markGpa(@subjectPercentageMark(@$data->total_marks , @subjectFullMark($exam_details->id, $data->subject->id, $class_id, $section_id)));
                            $main_subject_total_gpa += $result->gpa;
                            $total_mark+=@$data->total_marks;
                            @endphp
                        </td>
                    @endif
                    @if (@generalSetting()->result_type == 'mark')
                        <td>
                            @php
                                $totalMark = subjectPercentageMark(@$data->total_marks, @subjectFullMark($exam_details->id, $data->subject->id, $class_id, $section_id));
                                $passMark = $data->subject->pass_mark;
                            @endphp
                            @if ($passMark <= $totalMark)
                                @lang('exam.pass')
                            @else
                                @lang('exam.fail')
                            @endif
                        </td>
                        <td>
                            @php
                                $evaluation= markGpa(subjectPercentageMark(@$data->total_marks, @subjectFullMark($exam_details->id, $data->subject->id, $class_id, $section_id)));
                            @endphp
                            {{@$evaluation->description}}
                        </td>
                    @endif
                    <td>
                        {{@$data->teacher_remarks}}
                    </td>
                </tr>
                @endforeach
                @php
                    $remainSubjects = differences($is_result_available->pluck('subject_id')->toArray(), $subjects->pluck('subject_id')->toArray());
                @endphp
                @if(count($remainSubjects) > 0)
                    @foreach($remainSubjects as $reaminSubject)
                        @php
                            $subject = App\SmSubject::find($reaminSubject);
                        @endphp
                        <tr>
                            <td colspan="1">{{$subject->subject_name}}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>@lang('exam.mark_not_stored')</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            <table class="table border_table gray_header_table mb_30 max-width-400 ml_auto margin-auto report_table" >
                <tbody>
                    <tr>
                        <td>@lang('exam.attendance')</td>
                        <td>{{@$student_attendance}} @lang('exam.of') {{@$total_class_days}}</td>
                        <td>@lang('exam.total_mark')</td>
                        <td>{{@$total_mark}}</td>
                    </tr>
                    <tr>
                        <td>@lang('exam.average_mark')</td>
                        <td>
                            @php
                                $average_mark=$total_mark/$Optional_subject_count;
                            @endphp
                        {{number_format(@$average_mark, 2, '.', '')}}
                        
                        </td>
                        @if(@generalSetting()->result_type != 'mark')
                            <td>@lang('exam.gpa')</td>
                            <td>
                                @php
                                    $total_gpa=$main_subject_total_gpa/$Optional_subject_count;
                                @endphp
                                {{number_format(@$total_gpa, 2, '.', '')}}
                            </td>
                        @endif
                    </tr>
                    @if(@generalSetting()->result_type != 'mark')
                        <tr>
                            <td>@lang('exam.grade')</td>
                            <td>
                                @php
                                    if(in_array($failgpaname->grade_name,$temp_grade)){
                                        echo $failgpaname->grade_name;
                                    }else{
                                        $grade_details= App\SmResultStore::remarks($total_gpa);
                                    }
                                @endphp
                                {{@$grade_details->grade_name}}
                            </td>
                            <td>@lang('homework.evaluation')</td>
                            <td>
                                @php
                                    if(in_array($failgpaname->grade_name,$temp_grade)){
                                        echo $failgpaname->description;
                                    }else{
                                        $grade= App\SmResultStore::remarks($total_gpa);
                                    }
                                @endphp
                                {{@$grade->description}}
                            </td>
                        </tr>
                        <tr>
                            <td class="nowrap"></td>
                            <td class="nowrap">
                              @lang('exam.position')
                            </td>
                            <td class="nowrap">{{getStudentMeritPosition($class_id, $section_id, $exam_details->id, $student_detail->id)}}</td>
                            <td class="nowrap"></td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if(isset($exam_content))
            <table style="width:100%" class="border-0">
                    <tbody>
                    <tr> 
                        <td class="border-0">
                        <p class="result-date" style="    text-align: left;
                        float: left;
                        display: inline-block;
                        margin-top: 50px;
                        padding-left: 0;
                        font-weight: 400;
                        color: #828bb2;
                        font-size: 12px;">
                            @lang('exam.date_of_publication_of_result') : 
                            <strong>
                                {{dateConvert(@$exam_content->publish_date)}}
                            </strong>
                        </p>
                        </td>
                        <td class="border-0"> 
                        <div class="text-right d-flex flex-column justify-content-end">
                            <div class="thumb text-right">
                            @if (@$exam_content->file)
                                <img src="{{asset(@$exam_content->file)}}" width="100px">
                            @endif
                            </div>
                                <p style="text-align:right; float:right; display:inline-block; font-size: 12px; margin-top:5px; color: #828bb2;">
                                ({{@$exam_content->title}})
                                </p> 
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            @endif
        </div>
    </div>
</body>
</html>