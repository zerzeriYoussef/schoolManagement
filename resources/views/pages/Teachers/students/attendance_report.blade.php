@extends('layouts.master')
@section('css')

@section('title')
    تقرير الحضور والغياب
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    تقارير الحضور والغياب
@stop
<!-- breadcrumb -->

@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post"  action="{{ route('attendance.search') }}" autocomplete="off">
                    @csrf
                    <h6 style="font-family: 'Cairo', sans-serif;color: blue">معلومات البحث</h6><br>
                    <div class="row align-items-center">
    <!-- Student Dropdown -->
    <div class="col-md-4">
        <div class="form-group">
            <label for="student">الطلاب</label>
            <select class="custom-select mr-sm-2" name="student_id">
                <option value="0">الكل</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Date Input Fields -->
    <div class="col-md-4">
        <div class="form-group">
            <label for="from">تاريخ البداية</label>
            <input type="date" class="form-control" placeholder="تاريخ البداية" required name="from">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="to">تاريخ النهاية</label>
            <input type="date" class="form-control" placeholder="تاريخ النهاية" required name="to">
        </div>
    </div>
</div>

                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">{{trans('Students_trans.submit')}}</button>
                </form>
                @isset($Students)
                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                           style="text-align: center">
                        <thead>
                        <tr>
                            <th class="alert-success">#</th>
                            <th class="alert-success">{{trans('Students_trans.name')}}</th>
                            <th class="alert-success">{{trans('Students_trans.Grade')}}</th>
                            <th class="alert-success">{{trans('Students_trans.section')}}</th>
                            <th class="alert-success">التاريخ</th>
                            <th class="alert-success">المادة</th>

                            <th class="alert-warning">الحالة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($Students as $student)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{$student->students->name}}</td>
                                <td>{{$student->grade->name}}</td>
                                <td>{{$student->section->Name_Section}}</td>
                                <td>{{$student->attendence_date}}</td>
                                <td>{{$student->matier->name}}</td>
                                <td>

                                    @if($student->attendence_status == 0)
                                        <span class="btn-danger">غياب</span>
                                    @else
                                        <span class="btn-success">حضور</span>
                                    @endif
                                </td>
                            </tr>
                        @include('pages.Students.Delete')
                        @endforeach
                    </table>
                </div>
                @endisset

            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')

@endsection 