@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    {{ trans('My_Classes_trans.title_page') }}
@stop
@endsection

@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{ trans('My_Classes_trans.title_page') }}
@stop
<!-- breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="row">
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ Session::get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (Session::has('delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ Session::get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="col-xl-12 mb-30">
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

                <button type="button" class="button x-small" data-toggle="modal" data-target="#addClassModal">
                    {{ trans('My_Classes_trans.add_class') }}
                </button>

                <button type="button" class="button x-small" id="btn_delete_all">
                    {{ trans('My_Classes_trans.delete_checkbox') }}
                </button>
                <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover table-sm table-bordered p-0" data-page-length="50" style="text-align: center">
                            <thead>
                                <tr>
                                <th><input name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
                                <th>#</th>
                                <th>{{ trans('My_Classes_trans.Name_class') }}</th>
                                <th>{{ trans('My_Classes_trans.Name_Grade') }}</th>
                                <th>{{ trans('My_Classes_trans.Processes') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($My_Classes as $My_Class)
                                <tr>
                                    <?php $i++; ?>
                                    <td><input type="checkbox" value="{{ $My_Class->id }}" class="box1"></td>
                                    <td>{{ $i }}</td>
                                    <td>{{$My_Class->Name_Class }}
                                    </td>
                                    
                                    <td>{{ $My_Class->Grades->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#edit{{ $My_Class->id }}"
                                            title="{{ trans('Grades_trans.Edit') }}"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $My_Class->id }}"
                                            title="{{ trans('Grades_trans.Delete') }}"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="edit{{ $My_Class->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                                    {{ trans('My_Classes_trans.edit_class') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Edit Form -->
                                                <form action="{{ route('Classrooms.update', 'test') }}" method="post">
                                                    {{ method_field('patch') }}
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="Name" class="mr-sm-2">{{ trans('My_Classes_trans.Name_class') }}:</label>
                                                            <input id="Name" type="text" name="Name" class="form-control"
                                                                value="{{ $My_Class->getTranslation('Name_Class', 'ar') }}" required>
                                                            <input id="id" type="hidden" name="id" class="form-control" value="{{ $My_Class->id }}">
                                                        </div>
                                                        <div class="col">
                                                            <label for="Name_en" class="mr-sm-2">{{ trans('My_Classes_trans.Name_class_en') }}:</label>
                                                            <input type="text" class="form-control" value="{{ $My_Class->getTranslation('Name_Class', 'en') }}" name="Name_en" required>
                                                        </div>
                                                    </div><br>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlTextarea1">{{ trans('My_Classes_trans.Name_Grade') }}:</label>
                                                        <select class="form-control form-control-lg" id="exampleFormControlSelect1" name="Grade_id">
                                                            <option value="{{ $My_Class->Grades->id }}">
                                                                {{ $My_Class->Grades->name }}
                                                            </option>
                                                            @foreach ($Grades as $Grade)
                                                                <option value="{{ $Grade->id }}">{{ $Grade->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <br><br>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                                        <button type="submit" class="btn btn-success">{{ trans('Grades_trans.submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="delete{{ $My_Class->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                                    {{ trans('My_Classes_trans.delete_class') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('Classrooms.destroy', 'test') }}" method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf
                                                    {{ trans('My_Classes_trans.Warning_Grade') }}
                                                    <input id="id" type="hidden" name="id" class="form-control" value="{{ $My_Class->id }}">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                                        <button type="submit" class="btn btn-danger">{{ trans('My_Classes_trans.submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addClassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        {{ trans('My_Classes_trans.add_class') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row mb-30" action="{{ route('Classrooms.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="repeater">
                                <div data-repeater-list="List_Classes">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="col">
                                                <label for="Name" class="mr-sm-2">{{ trans('My_Classes_trans.Name_class') }}:</label>
                                                <input class="form-control" type="text" name="Name" required />
                                            </div>

                                            <div class="col">
                                                <label for="Name_class_en" class="mr-sm-2">{{ trans('My_Classes_trans.Name_class_en') }}:</label>
                                                <input class="form-control" type="text" name="Name_class_en" required />
                                            </div>

                                            <div class="col">
                                                <label for="Name_class_en" class="mr-sm-2">{{ trans('My_Classes_trans.Name_Grade') }}:</label>
                                                <div class="box">
                                                    <select class="fancyselect" name="Grade_id">
                                                        @foreach ($Grades as $Grade)
                                                            <option value="{{ $Grade->id }}">{{ $Grade->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <label for="Name_class_en" class="mr-sm-2">{{ trans('My_Classes_trans.Processes') }}:</label>
                                                <input class="btn btn-danger btn-block" data-repeater-delete type="button" value="{{ trans('My_Classes_trans.delete_row') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-12">
                                        <input class="button" data-repeater-create type="button" value="{{ trans('My_Classes_trans.add_row') }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                            <button type="submit" class="btn btn-success">{{ trans('Grades_trans.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete All Modal -->
    <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">{{ trans('My_Classes_trans.delete_class') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_all') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        {{ trans('My_Classes_trans.Warning_Grade') }}
                        <input type="text" id="delete_all_id" name="delete_all_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('My_Classes_trans.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- row closed -->
@endsection

@section('js')
    @toastr_js
    @toastr_render

    <script>
      $(document).ready(function() {
            // Delete All Button Click Event
            $("#btn_delete_all").click(function() {
                var selected = [];
                $("#datatable input[type=checkbox]:checked").each(function() {
                    selected.push(this.value);
                });

                if (selected.length > 0) {
                    $('#delete_all').modal('show');
                    $('#delete_all_id').val(selected.join(','));
                } else {
                    alert('makch 3aml select');
                }
            });
        });

        function CheckAll(className, elem) {
            var elements = document.getElementsByClassName(className);
            var l = elements.length;

            if (elem.checked) {
                for (var i = 0; i < l; i++) {
                    elements[i].checked = true;
                }
            } else {
                for (var i = 0; i < l; i++) {
                    elements[i].checked = false;
                }
            }
        }
    </script>
@endsection
<?php /*@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    {{ trans('My_Classes_trans.title_page') }}
@stop
@endsection

@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{ trans('My_Classes_trans.title_page') }}
@stop
<!-- breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="row">
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ Session::get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (Session::has('delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ Session::get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="col-xl-12 mb-30">
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

                <button type="button" class="button x-small" data-toggle="modal" data-target="#addClassModal">
                    {{ trans('My_Classes_trans.add_class') }}
                </button>

                <button type="button" class="button x-small" id="btn_delete_all">
                    {{ trans('My_Classes_trans.delete_checkbox') }}
                </button>
                <br><br>

                <div class="table-responsive">
                    <table id="datatable" class="table table-hover table-sm table-bordered p-0" data-page-length="50" style="text-align: center">
                        <thead>
                            <tr>
                                <th><input name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
                                <th>#</th>
                                <th>{{ trans('My_Classes_trans.Name_class') }}</th>
                                <th>{{ trans('My_Classes_trans.Name_Grade') }}</th>
                                <th>{{ trans('My_Classes_trans.Processes') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($My_Classes as $My_Class)
                                <tr>
                                    <?php $i++; ?>
                                    <td><input type="checkbox" value="{{ $My_Class->id }}" class="box1"></td>
                                    <td>{{ $i }}</td>
                                    <td>{{ $My_Class->Name_Class }}</td>
                                    <td>{{ $My_Class->Grades->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#edit{{ $My_Class->id }}"
                                            title="{{ trans('Grades_trans.Edit') }}"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $My_Class->id }}"
                                            title="{{ trans('Grades_trans.Delete') }}"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="edit{{ $My_Class->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                                    {{ trans('My_Classes_trans.edit_class') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Edit Form -->
                                                <form action="{{ route('Classrooms.update', 'test') }}" method="post">
                                                    {{ method_field('patch') }}
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="Name" class="mr-sm-2">{{ trans('My_Classes_trans.Name_class') }}:</label>
                                                            <input id="Name" type="text" name="Name" class="form-control"
                                                                value="{{ $My_Class->getTranslation('Name_Class', 'ar') }}" required>
                                                            <input id="id" type="hidden" name="id" class="form-control" value="{{ $My_Class->id }}">
                                                        </div>
                                                        <div class="col">
                                                            <label for="Name_en" class="mr-sm-2">{{ trans('My_Classes_trans.Name_class_en') }}:</label>
                                                            <input type="text" class="form-control" value="{{ $My_Class->getTranslation('Name_Class', 'en') }}" name="Name_en" required>
                                                        </div>
                                                    </div><br>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlTextarea1">{{ trans('My_Classes_trans.Name_Grade') }}:</label>
                                                        <select class="form-control form-control-lg" id="exampleFormControlSelect1" name="Grade_id">
                                                            <option value="{{ $My_Class->Grades->id }}">
                                                                {{ $My_Class->Grades->name }}
                                                            </option>
                                                            @foreach ($Grades as $Grade)
                                                                <option value="{{ $Grade->id }}">{{ $Grade->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <br><br>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                                        <button type="submit" class="btn btn-success">{{ trans('Grades_trans.submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="delete{{ $My_Class->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                                    {{ trans('My_Classes_trans.delete_class') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('Classrooms.destroy', 'test') }}" method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf
                                                    {{ trans('My_Classes_trans.Warning_Grade') }}
                                                    <input id="id" type="hidden" name="id" class="form-control" value="{{ $My_Class->id }}">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                                        <button type="submit" class="btn btn-danger">{{ trans('My_Classes_trans.submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addClassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        {{ trans('My_Classes_trans.add_class') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row mb-30" action="{{ route('Classrooms.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="repeater">
                                <div data-repeater-list="List_Classes">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="col">
                                                <label for="Name" class="mr-sm-2">{{ trans('My_Classes_trans.Name_class') }}:</label>
                                                <input class="form-control" type="text" name="Name" required />
                                            </div>

                                            <div class="col">
                                                <label for="Name_class_en" class="mr-sm-2">{{ trans('My_Classes_trans.Name_class_en') }}:</label>
                                                <input class="form-control" type="text" name="Name_class_en" required />
                                            </div>

                                            <div class="col">
                                                <label for="Name_class_en" class="mr-sm-2">{{ trans('My_Classes_trans.Name_Grade') }}:</label>
                                                <div class="box">
                                                    <select class="fancyselect" name="Grade_id">
                                                        @foreach ($Grades as $Grade)
                                                            <option value="{{ $Grade->id }}">{{ $Grade->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <label for="Name_class_en" class="mr-sm-2">{{ trans('My_Classes_trans.Processes') }}:</label>
                                                <input class="btn btn-danger btn-block" data-repeater-delete type="button" value="{{ trans('My_Classes_trans.delete_row') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-12">
                                        <input class="button" data-repeater-create type="button" value="{{ trans('My_Classes_trans.add_row') }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                            <button type="submit" class="btn btn-success">{{ trans('Grades_trans.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete All Modal -->
    <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">{{ trans('My_Classes_trans.delete_class') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_all') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        {{ trans('My_Classes_trans.Warning_Grade') }}
                        <input type="hidden" id="delete_all_id" name="delete_all_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('My_Classes_trans.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- row closed -->
@endsection

@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            // Delete All Button Click Event
            $("#btn_delete_all").click(function() {
                var selected = [];
                $("#datatable input[type=checkbox]:checked").each(function() {
                    selected.push(this.value);
                });

                if (selected.length > 0) {
                    $('#delete_all').modal('show');
                    $('#delete_all_id').val(selected.join(','));
                } else {
                    alert('{{ trans('My_Classes_trans.no_checkbox_selected') }}');
                }
            });
        });

        function CheckAll(className, elem) {
            var elements = document.getElementsByClassName(className);
            var l = elements.length;

            if (elem.checked) {
                for (var i = 0; i < l; i++) {
                    elements[i].checked = true;
                }
            } else {
                for (var i = 0; i < l; i++) {
                    elements[i].checked = false;
                }
            }
        }
    </script>
@endsection
*/?>.