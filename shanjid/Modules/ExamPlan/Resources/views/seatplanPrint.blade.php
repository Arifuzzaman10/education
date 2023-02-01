<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('examplan::exp.seat_plan')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: #828BB2;
            font-weight: 400;
            margin: 0;
            padding: 0;
            line-height: 1.63;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #415094;
            margin: 0;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .justify-content-center {
            justify-content: center;
        }

        .flex-fill {
            flex: 1 1 auto;
        }

        .flex-column {
            flex-direction: column;
        }



        .theme_text {
            color: #415094;
        }

        .sep_name {
            flex: 110px 0 0;
        }

        .student_grid_box {
            grid-gap: 15px;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .f_w_400 {
            font-weight: 400;
        }

        .f_w_500 {
            font-weight: 500;
        }

        .text-center {
            text-align: center;
        }

        .m-0 {
            margin: 0;
        }

        .single_seat {
            border: 1px solid #828BB2;
        }

        .single_seat_right {
            flex: 130px 0 0;
            max-width: 130px;
        }

        .seat_head h3 {
            font-size: 14px;
            color: #415094;

        }

        .seat_head .exam_name {
            font-size: 14px;
            color: #415094;
            background: #DFF2FF;
            padding: 5px 0;
            margin: 5px 0 25px 0;
        }

        .student_name {
            font-size: 16px;
            margin: 0;
            font-weight: 500;
            margin-bottom: 0;
        }

        .student_group {
            font-size: 14px;
            font-weight: 400;
            color: #828BB2;
            line-height: 1;
            margin: 0;
        }
        h1, h2, h3, h4, h5, h6 {
        color: #828BB2;
        margin: 0;
        }

        .student_img img {
            width: 100%;
        }

        .seat_wrapper {
            width: 210mm;
            margin: auto;
            padding: 20px 0;
        }

        .single_seat {
            padding: 5px;
        }

        .student_info {
            border: 1px solid #828BB2;
            margin-top: 10px;
        }

        .student_info span {
            font-size: 14px;
            font-weight: 500;
            color: #828BB2;
            text-align: center;
        }

        .student_info span:not(:last-child) {
            border-bottom: 1px solid #828BB2;
        }

        .seat_wrapper {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 20px;
        }
        .student_img {
    max-width: 80px;
    margin: auto;
}
    </style>
</head>

<body>
    <div class="seat_wrapper">
    @foreach($seat_plans as $seat_plan)
        <div class="single_seat d-flex">
            <div class="single_seat_left flex-fill">
                <div class="seat_head">
                    @if($setting->school_name )
                        <h3 class="text-center">{{generalSetting()->school_name}}</h3>
                    @endif
                    <div class="exam_name text-center text-capitalize">
                        @if($setting->exam_name)
                            {{$seat_plan->examType->title}}
                        @endif
                        @if($setting->academic_year)
                            {{@$seat_plan->academicYear->year}}
                        @endif
                       
                    </div>
                    @if($setting->student_name)
                        <h4 class="student_name text-uppercase">{{@$seat_plan->studentRecord->studentDetail->full_name}}</h4>
                    @endif
                    @if(isset($seat_plan->studentRecord->studentDetail->category))
                        <h5 class="student_group">{{@$seat_plan->studentRecord->studentDetail->category->category_name}}</h5>
                    @endif
                </div>
            </div>
            <div class="single_seat_right">
                <div class="student_img">
                    @if($setting->student_photo)
                        @if($seat_plan->studentRecord->studentDetail->student_photo)
                        <img src="{{asset(@$seat_plan->studentRecord->studentDetail->student_photo)}}" alt="{{@$seat_plan->studentRecord->studentDetail->full_name}}">
                        @else 
                        <img src="{{asset('Modules/ExamPlan/Public/images/profile.jpg')}}" alt="{{@$seat_plan->studentRecord->studentDetail->full_name}}">
                        
                        @endif
                    @endif
                </div>
                <div class="student_info d-flex flex-column">
                    @if($setting->class_section)
                        <span>{{@$seat_plan->studentRecord->class->class_name}}({{@$seat_plan->studentRecord->section->section_name}})</span>
                    @endif
                    @if($setting->roll_no)
                        <span>@lang('student.roll_number') : {{@$seat_plan->studentRecord->studentDetail->roll_no}}</span>
                    @endif
                    @if($setting->admission_no)
                        <span>@lang('student.admission_no') : {{@$seat_plan->studentRecord->studentDetail->admission_no}}</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    </div>
</body>

</html>