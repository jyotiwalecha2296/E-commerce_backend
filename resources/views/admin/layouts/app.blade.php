<!doctype html>
<html lang="en">
  @include('admin.layouts.common.header')
  <body>
    <!-- Begin page -->
    <div class="dashboard-container">
      @include('admin.layouts.common.navigation')        
      <div class="main">
        @include('admin.layouts.common.sidebar')
        <style>
          .invalid-feedback {
          display: block !important;
        </style>
        <div class="page-content-wrap">
          @include('admin.layouts.common.title')
          <div class="page-content"> 
            @yield('content')
          </div>
          @include('admin.layouts.common.footer')
        </div> 
      </div>       
    </div>    
    @include('admin.layouts.common.scripts')
  </body>
</html>