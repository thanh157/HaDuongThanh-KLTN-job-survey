<!doctype html>
<html lang="en">

@include('admin.includes.head')

<body>
    <!--Main navbar-->
    @include('admin.includes.header')
    <!--/Main navbar-->
    
    <!-- Page content -->
    <div class="page-content">

        @include('admin.includes.sidebars')

        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Inner content -->
            <div class="content-inner">

                {{-- @include('admin.includes.toast') --}}

                @yield('content')

                <!-- Footer -->
                @include('admin.includes.footer')
                <!-- /footer -->
            </div>
            <!-- /inner content -->
        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->
    @include('admin.includes.script')
</body>

</html>