<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar start-->
        <div class="side-menu-fixed">
<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ url('/teacher/dashboard') }}">
                <div class="pull-left"><i class="ti-home"></i><span
                        class="right-nav-text">{{trans('main_trans.Dashboard')}}</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <!-- menu title -->
        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">{{trans('main_trans.Programname')}} </li>
 <!-- الاقسام-->
 <li>
            <a href="{{route('sections')}}"><i class="fas fa-chalkboard"></i><span
                    class="right-nav-text">{{ trans('teachers_trans.section') }} </span></a>
        </li>
        
        <!-- الطلاب-->
        <li>
        <a target="_blank" href="{{route('student.index')}}"><i class="fas fa-user-graduate"></i><span
        class="right-nav-text">{{ trans('teachers_trans.Students') }} </span></a>
        </li>


        <!-- الامتحانات-->
        
  <!-- sections-->
  <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#sections-menu">
                <div class="pull-left"><i class="fas fa-chalkboard"></i><span
                        class="right-nav-text">{{ trans('teachers_trans.Reports') }} </span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="sections-menu" class="collapse" data-parent="#sidebarnav">
            <li><a href="{{route('attendance.report')}}">{{ trans('teachers_trans.Attendance Report') }}  </a></li>                <li><a href="#">{{ trans('teachers_trans.Exam Report') }}  </a></li>
            </ul>

        </li>
        <!-- الملف الشخصي-->
        <li>
            <a href="{{route('profile.show')}}"><i class="fas fa-id-card-alt"></i><span
                    class="right-nav-text">{{ trans('teachers_trans.Profile') }}  </span></a>
        </li>

    </ul>
    </div></div>