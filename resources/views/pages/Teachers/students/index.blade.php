@extends('layouts.master')

@section('css')
    @toastr_css
@endsection

@section('title')
    قائمة الحضور والغياب للطلاب
@endsection

@section('page-header')
    @section('PageTitle')
        قائمة الحضور والغياب للطلاب
    @stop
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h5 style="font-family: 'Cairo', sans-serif; color: red">تاريخ اليوم: {{ date('Y-m-d') }}</h5>
    <div class="row">
        <div class="col-xl-12 mb-30" style="height: 400px;">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach($matiers as $index => $matier)
                            <li class="nav-item">
                                <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="matier-tab-{{ $matier->id }}" data-toggle="tab"
                                   href="#tab-{{ $matier->id }}" role="tab" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                    {{ $matier->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                   
                        <div class="tab-content" id="myTabContent">
                            @foreach($matiers as $index => $matier)
                                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="tab-{{ $matier->id }}">
                                <form method="post" action="{{ route('attendance') }}" autocomplete="off">
                                @csrf
                                    <table id="datatable" class="table table-hover table-sm table-bordered p-0" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ trans('Students_trans.name') }}</th>
                                                <th>{{ trans('Students_trans.email') }}</th>
                                                <th>{{ trans('Students_trans.gender') }}</th>
                                                <th>{{ trans('Students_trans.Grade') }}</th>
                                                <th>{{ trans('Students_trans.classrooms') }}</th>
                                                <th>{{ trans('Students_trans.section') }}</th>
                                                <th>الحضور والغياب</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $student)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $student->name }}</td>
                                                    <td>{{ $student->email }}</td>
                                                    <td>{{ $student->gender->Name }}</td>
                                                    <td>{{ $student->grade->name }}</td>
                                                    <td>{{ $student->classroom->Name_Class }}</td>
                                                    <td>{{ $student->section->Name_Section }}</td>
                                                    <td>
                                                        @php
                                                            $attendance = $student->attendance()
                                                                ->where('attendence_date', date('Y-m-d'))
                                                                ->where('matier_id', $matier->id)
                                                                ->first();
                                                        @endphp

                                                        @if($attendance)
                                                            <label>
                                                                <input name="attendences[{{ $student->id }}][status]" disabled {{ $attendance->attendence_status == 1 ? 'checked' : '' }} type="radio" value="presence">
                                                                <span class="text-success">حضور</span>
                                                            </label>
                                                            <label class="ml-4">
                                                                <input name="attendences[{{ $student->id }}][status]" disabled {{ $attendance->attendence_status == 0 ? 'checked' : '' }} type="radio" value="absent">
                                                                <span class="text-danger">غياب</span>
                                                            </label>
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                    data-toggle="modal"
                                    data-target="#edit_attendance{{ $student->id }}_{{ $matier->id }}"                                     title="حذف"><i
                                    class="fa fa-edit"></i></button>
                            @include('pages.Teachers.students.edit_attendance')

                                                        @else
                                                            <label>
                                                                <input name="attendences[{{ $student->id }}][status]" type="radio" value="presence">
                                                                <span class="text-success">حضور</span>
                                                            </label>
                                                            <label class="ml-4">
                                                                <input name="attendences[{{ $student->id }}][status]" type="radio" value="absent">
                                                                <span class="text-danger">غياب</span>
                                                            </label>
                                                            <input type="hidden" name="attendences[{{ $student->id }}][matier_id]" value="{{ $matier->id }}">
                                                            <input type="hidden" name="student_id[]" value="{{ $student->id }}">
                                                            <input type="hidden" name="grade_id" value="{{ $student->Grade_id }}">
                                                            <input type="hidden" name="classroom_id" value="{{ $student->Classroom_id }}">
                                                            <input type="hidden" name="section_id" value="{{ $student->section_id }}">
                                                            <input type="hidden" name="teacher_id" value="{{ auth()->user()->id }}">
                                                            <input type="hidden" name="matie" value="{{ $matier->id }}">

                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button class="btn btn-success mt-3" type="submit">{{ trans('Students_trans.submit') }}</button>
                    </form>
                                </div>
                            @endforeach
                        </div>
                        
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @toastr_js
    @toastr_render
@endsection
