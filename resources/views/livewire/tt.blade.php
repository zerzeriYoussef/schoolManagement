
@section('css')
    @livewireStyles
@endsection

@section('title')
    {{ trans('main_trans.Add_Parent') }}
@stop

@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
        {{ trans('main_trans.Add_Parent') }}
    @stop
    <!-- breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <!-- Including the Livewire Counter component -->
                <livewire:counter /> 
                <livewire:test /> 

                <!-- Example Counter Display -->
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection

@section('js')
    @livewireScripts
@endsection
