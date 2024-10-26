@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    اضافة فاتورة جديدة
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
اضافة فاتورة جديدة {{$student->name}}
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

                        <form class=" row mb-30" action="{{ route('Fees_Invoices.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="repeater">
                                    <div data-repeater-list="List_Fees">
                                        <div data-repeater-item>
                                            <div class="row">

                                                <div class="col">
                                                    <label for="Name" class="mr-sm-2">اسم الطالب</label>
                                                    <select class="fancyselect" name="student_id" required>
                                                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                                                    </select>
                                                </div>

                                                <div class="col">
                                                    <label for="Name_en" class="mr-sm-2">نوع الرسوم</label>
                                                    <div class="box">
                                                        <select class="fancyselect" name="fee_id" required>
                                                            <option value="">-- اختار من القائمة --</option>
                                                            @foreach($fees as $fee)
                                                                <option value="{{ $fee->id }}">{{ $fee->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col">
                                                    <label for="amount" class="mr-sm-2">المبلغ</label>
                                                    <div class="box">
                                                        <select class="fancyselect" name="amount" required>
                                                        <option value="">-- اختار من القائمة --</option>
                                                        @foreach($fees as $fee)
                                                                <option value="{{ $fee->amount }}">{{ $fee->amount }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    </div>


                                                <div class="col">
                                                    <label for="description" class="mr-sm-2">البيان</label>
                                                    <div class="box">
                                                        <input type="text" class="form-control" name="description" required>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <label for="Name_en" class="mr-sm-2">{{ trans('My_Classes_trans.Processes') }}:</label>
                                                    <input class="btn btn-danger btn-block" data-repeater-delete type="button" value="{{ trans('My_Classes_trans.delete_row') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-20">
                                        <div class="col-12">
                                            <input class="button" data-repeater-create type="button" value="{{ trans('My_Classes_trans.add_row') }}"/>
                                        </div>
                                    </div><br>
                                    <input type="hidden" name="Grade_id" value="{{$student->Grade_id}}">
                                    <input type="hidden" name="Classroom_id" value="{{$student->Classroom_id}}">

                                    <button type="submit" class="btn btn-primary">تاكيد البيانات</button>
                                </div>
                            </div>
                        </form>

                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
<script>
$(document).ready(function () {
  $('select[name="fee_id"]').on('change', function () {
    var fee_id = $(this).val();
    if (fee_id) {
      console.log('Fetching amount for fee ID: ' + fee_id);
      $.ajax({
        url: "{{ url('Get_Amount') }}/" + fee_id,
        type: "GET",
        dataType: "json",
        success: function (data) {
          console.log('Server response:', data);

          // Clear previous options
          $('select[name="amount"]').empty();

          if (data) {
            // Append the amount as an option
            $('select[name="amount"]').append('<option value="' + data + '">' + data + '</option>');

            // Set the selected option to the fetched amount
            $('select[name="amount"]').val(data);
          } else {
            $('select[name="amount"]').append('<option value="">لا توجد بيانات</option>');
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error('AJAX Error:', textStatus, errorThrown);
          alert('Error fetching the fee amount. Please try again.');
        }
      });
    } else {
      console.log('No fee ID selected');
      $('select[name="amount"]').empty();
      $('select[name="amount"]').append('<option value="">-- اختار من القائمة --</option>');
      $('select[name="amount"]').append('<option value="' + data + '">' + data + '</option>');

    }
  });
});
</script>


@endsection