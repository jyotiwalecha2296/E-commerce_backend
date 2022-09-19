<div class="sidebar">
  <ul class="nav" id="sideMenu">
    <li class="nav-item">
      <a href="{{ url('/dashboard') }}" class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }}">
        <i class="lni lni-home"></i>
        <span class="name">Dashboard</span>
        <span class="hover-name">Dashboard</span>
      </a>
    </li>


    <li class="nav-item">
      <a href="{{ url('/pages') }}" class="nav-link {{ Route::is('pages.*') || Route::is('pages.*')  ? 'active' : '' }}">
        <i class="lni lni-files"></i>
        <span class="name">Pages</span>
        <span class="hover-name">Pages</span>
      </a>
    </li>

     <!-- <li class="nav-item">
      <a href="{{ url('/watch-page') }}" class="nav-link {{ (request()->is('watch-page')) ? 'active' : '' }}">
        <i class="lni lni-files"></i>
        <span class="name">Watch Page</span>
        <span class="hover-name">Watch Page</span>
      </a>
    </li> -->

     <!-- General -->
     <li class="nav-item dropdown">
      <a href="#generalMenu" data-bs-toggle="collapse" class="nav-link has-arrow"  aria-expanded="{{ (request()->is('settings')) ? 'true' : '' }}{{(request()->is('menus')) ? 'true' : ''}} {{(request()->is('add-menu/*')) ? 'true' : ''}} {{(request()->is('edit-menu/*')) ? 'true' : ''}}{{ Route::is('videos.*') || Route::is('videos.*')  ? 'true' : '' }}">
       <i class="lni lni-cog"></i>
        <span class="name"> General</span>           
      </a>
      <ul class="collapse nav flex-column ms-0 w-100 {{ (request()->is('settings')) ? 'show' : '' }}{{(request()->is('menus')) ? 'show' : ''}} {{(request()->is('add-menu/*')) ? 'show' : ''}} {{(request()->is('edit-menu/*')) ? 'show' : ''}}{{ Route::is('videos.*') || Route::is('videos.*')  ? 'show' : '' }}" id="generalMenu" data-bs-parent="#sideMenu">
        
        <li class="">
          <a href="{{ url('/settings') }}" class="nav-link px-0 nav-link {{ (request()->is('settings')) ? 'active' : '' }}">
            <i class="lni lni-cog"></i>        
            <span class="d-none d-sm-inline">Setting</span>           
          </a>
        </li> 

        <li>
          <a href="{{ url('/menus') }}" class="nav-link px-0 {{(request()->is('menus')) ? 'active' : ''}} {{(request()->is('add-menu/*')) ? 'active' : ''}} {{(request()->is('edit-menu/*')) ? 'active' : ''}}">
            <i class="lni lni-list"></i>
            <span class="d-none d-sm-inline">Manage Navigation</span>
          </a>
        </li>


      </ul>
    </li>

    <li class="nav-item">
      <a href="{{ url('/inquiries') }}" class="nav-link {{ Route::is('inquiries.*') || Route::is('inquiries.*')  ? 'active' : '' }}">
        <i class="lni lni-question-circle"></i>
        <span class="name"> Inquiries</span>
        <span class="hover-name"> Inquiries</span>
      </a>
    </li>
 
 

     
      <li class="nav-item dropdown">
      <a href="#homepageMenu" data-bs-toggle="collapse" class="nav-link has-arrow"  aria-expanded="{{ Route::is('home-slider.*') || Route::is('home-slider.*')  ? 'true' : '' }} {{(request()->is('homepage-settings')) ? 'true' : ''}}">
        <i class="lni lni-home"></i><span class="name">Homepage Settings</span></a>

      <ul class="collapse nav flex-column ms-0 w-100  {{ Route::is('home-slider.*') || Route::is('home-slider.*')  ? 'show' : '' }}{{(request()->is('homepage-settings')) ? 'show' : ''}} " id="homepageMenu" data-bs-parent="#sideMenu">
     
        <li class="">
          <a href="{{ url('/home-slider') }}" class="nav-link px-0 nav-link {{ Route::is('home-slider.*') || Route::is('home-slider.*')  ? 'active' : '' }}">
            <i class="lni lni-slideshare"></i><span class="d-none d-sm-inline">Homepage Slider </span></a>
        </li>        
       
        <li>
          <a href="{{ url('/homepage-settings') }}" class="nav-link px-0 {{(request()->is('homepage-settings')) ? 'active' : ''}} ">
           <i class="lni lni-layout"></i> <span class="d-none d-sm-inline"> Homepage Sections</span> </a>
        </li>

         
      </ul>
    </li>
 

    <li class="nav-item">
      <a href="{{ url('/coupons') }}" class="nav-link {{ Route::is('coupons.*') || Route::is('coupons.*')  ? 'active' : '' }}">
        <i class="lni lni-tag"></i>      
        <span class="name"> Coupons</span>
        <span class="hover-name">Coupons</span>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{ url('/gift-vouchers') }}" class="nav-link {{ Route::is('gift-vouchers.*') || Route::is('gift-vouchers.*')  ? 'active' : '' }}">
        <i class="lni lni-gift"></i>      
        <span class="name"> Gift Vouchers</span>
        <span class="hover-name">Gift Vouchers</span>
      </a>
    </li>

<!--     <li class="nav-item">
      <a href="{{ url('/shipping') }}" class="nav-link {{ Route::is('shipping.*') || Route::is('shipping.*')  ? 'active' : '' }}">
        <i class="lni lni-delivery"></i>    
        <span class="name"> Shipping</span>
        <span class="hover-name">Shipping</span>
      </a>
    </li> -->

    <li class="nav-item">
      <a href="{{ url('/orders') }}" class="nav-link {{ Route::is('orders.*') || Route::is('orders.*')  ? 'active' : '' }}">
        <i class="lni lni-shopping-basket"></i>    
        <span class="name">Manage Orders</span>
        <span class="hover-name">Manage Orders</span>
      </a>
    </li>

    <li class="nav-item dropdown">
      <a href="#productMenu" data-bs-toggle="collapse" class="nav-link has-arrow " aria-expanded="{{ (request()->is('products')) ? 'true' : '' }}{{ Route::is('collections.*') || Route::is('collections.*')  ? 'true' : '' }}{{ (request()->is('product-queries')) ? 'true' : '' }}{{(request()->is('products/create')) ? 'true' : ''}}{{(request()->is('products/*/edit')) ? 'true' : ''}}">
        <i class="lni lni-producthunt"></i>    
        <span class="name">Manage Products</span>           
      </a>
      <ul class="collapse nav flex-column ms-0 w-100 {{ (request()->is('products')) ? 'show' : '' }}{{ Route::is('collections.*') || Route::is('collections.*')  ? 'show' : '' }}{{ (request()->is('product-queries')) ? 'show' : '' }}{{(request()->is('products/create')) ? 'show' : ''}}{{(request()->is('products/*/edit')) ? 'show' : ''}}" id="productMenu" data-bs-parent="#sideMenu">
        <li>
          <a href="{{ url('/collections') }}" class="nav-link px-0 {{ Route::is('collections.*') || Route::is('collections.*')  ? 'active' : '' }}">
            <i class="lni lni-connectdevelop"></i>
            <span class="d-none d-sm-inline">Collections</span>
          </a>
        </li>
        <li class="">
          <a href="{{ url('/products') }}" class="nav-link px-0 nav-link {{(request()->is('products')) ? 'active' : ''}}{{(request()->is('products/create')) ? 'active' : ''}}{{(request()->is('products/*/edit')) ? 'active' : ''}}">
            <i class="lni lni-list"></i>         
            <span class="d-none d-sm-inline">Listing All Products </span>           
          </a>
        </li> 
 
        <li class="">
          <a href="{{ url('/product-queries') }}" class="nav-link px-0 nav-link {{ (request()->is('product-queries')) ? 'active' : '' }}">
            <i class="lni lni-question-circle"></i>       
            <span class="d-none d-sm-inline">Products Inquiries</span>           
          </a>
        </li>       
        
      </ul>
    </li>


    <li class="nav-item dropdown">
      <a href="#userMenu" data-bs-toggle="collapse" class="nav-link has-arrow"  aria-expanded="{{ Route::is('users.*') || Route::is('users.*')  ? 'true' : '' }}{{ Route::is('subscribed-users.*') || Route::is('subscribed-users.*')  ? 'true' : '' }}">
        <i class="lni lni-users"></i>    
        <span class="name"> Manage Users</span>           
      </a>
      <ul class="collapse nav flex-column ms-0 w-100 {{ Route::is('users.*') || Route::is('users.*')  ? 'show' : '' }}{{ Route::is('subscribed-users.*') || Route::is('subscribed-users.*')  ? 'show' : '' }}" id="userMenu" data-bs-parent="#sideMenu">
        <li class="">
          <a href="{{ url('/users') }}" class="nav-link px-0 nav-link {{ Route::is('users.*') || Route::is('users.*')  ? 'active' : '' }}">
            <i class="lni lni-list"></i>         
            <span class="d-none d-sm-inline">Listing All Users </span>           
          </a>
        </li>        
        <li>
          <a href="{{ url('/subscribed-users') }}" class="nav-link px-0 {{ Route::is('subscribed-users.*') || Route::is('subscribed-users.*')  ? 'active' : '' }}">
            <i class="lni lni-envelope"></i>
            <span class="d-none d-sm-inline">Subscribed Users</span>
          </a>
        </li>
      </ul>
    </li>

   
  </ul>
</div>