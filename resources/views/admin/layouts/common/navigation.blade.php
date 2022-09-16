<div class="header">
    <div class="header-logo" style="padding-left:1rem;display: block;">
      <img src="{{ asset('public/images/logo/dummy-logo-white.png') }}" alt="E-Commerce Logo" title="E-Commerce">
    </div>
    <div class="header-search">
        <span class="button-menu"> 
            <span class="label">                      
              <span></span>
              <span></span>
              <span></span>
            </span>
        </span>
        <!-- <button class="button-menu">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 385 385">
              <path d="M12 120.3h361a12 12 0 000-24H12a12 12 0 000 24zM373 180.5H12a12 12 0 000 24h361a12 12 0 000-24zM373 264.7H132.2a12 12 0 000 24H373a12 12 0 000-24z" />
            </svg>                       
        </button> -->
        <div class="ms-auto">
            <ul class="list-unstyled d-flex ps-0 pb-0 mb-0 gap-3 align-items-center justify-content-end">
                <li class="dropdown">
                    <button class="notification dropdown-toggle" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">                        
                        <i class="material-icons">notifications_none</i>
                        <span class="count">2</span>
                    </button>
                    <div class="dropdown-menu notification-menu" aria-labelledby="notificationDropdown">
                        <div class="d-flex align-items-center space-between notif-header">
                            <span class="">Notifications</span>
                            <a class="" href="{{ url('/notifications') }}">View All</a>
                        </div>
                        <ul class="list-unstyled">
                            <li class="item">
                                <span class="icon"><i class="lni lni-cart"></i></span>
                                <span class="text">Received new order request from customer...</span>
                            </li>
                            <li class="item">                                
                                <span class="icon"><i class="lni lni-cart"></i></span>
                                <span class="text">Received new order request from customer...</span>                                
                            </li>
                            <li class="item">                                
                                <span class="icon"><i class="lni lni-information"></i></span>
                                <span class="text">Lorem ispum dollar sit amet</span>                                                              
                            </li>
                        </ul>    
                    </div>
                </li>
                <li>
                    <button class="usermenu" type="button" data-bs-toggle="offcanvas" data-bs-target="#profileOffCanvas" aria-controls="profileOffCanvas">
                      <i class="fa fa-user"></i>
                    </button>
                </li>
                <!-- <li class="dropdown">
                    <button class="usermenu dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="fa fa-user"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                        <li><a class="btn btn-theme-two text-capitalize" href="{{ route('logout.attempt') }}">Logout</a>                
                        </li>
                    </ul>
                </li> -->
            </ul>           
        </div> 
    </div>
</div>

<div class="offcanvas offcanvas-end bg_light" tabindex="-1" id="profileOffCanvas" data-bs-backdrop="false" aria-labelledby="profileOffCanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="profileOffCanvasLabel"></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">        
        <div class="profile-wrap">
           <div class="profile-img">  
                <img src="{{ asset('public/images/user-icon-image.png') }}" alt="user image"> 
           </div>
           <div class="profile-info">
                <p class="fs-6 mb-2">Admin User</p>
                <p class="mb-1">admin@itsolutionstuff.com</p>
                <p class="mb-1"><span>User ID: </span><span>123456789</span></p>
                <div class="links-wrap">                  
                    <a href="{{ route('admin.profile') }}" >
                        <span class="me-2">Update Profile</span>
                        <i class="lni lni-pencil"></i>
                    </a>                    
                    <a href="{{ route('logout.attempt') }}">
                        <span class="me-2">Sign Out</span>
                        <i class="lni lni-user"></i>
                    </a>
                </div> 
           </div>
        </div>
        <div class="card">
            <div class="card-info">
                <div class="title mb-2">Website Information</div>
                <p class="mb-1"><span class="me-2">Website Title: </span><span>E-Commerce</span></p>
                <p class="mb-1"><span class="me-2">Email: </span><span>hello@dummy.com</span></p>
                <p class="mb-1"><span class="me-2">Phone: </span><span>0097345345674</span></p>
                <div class="links-wrap">                  
                    <a href="{{ url('/settings') }}" >
                        <span class="me-2">Update Settings</span>
                        <i class="lni lni-pencil"></i>
                    </a> 
                </div>
            </div>            
        </div>
        <div class="card">
            <div class="card-info">
                <div class="title mb-2">Other Information</div>
                <p class="mb-1"><span class="me-2">Total Users: </span><span>1000</span></p>
                <p class="mb-1"><span class="me-2">Total collections: </span><span>500</span></p>
                <p class="mb-1"><span class="me-2">Total Products: </span><span>5000</span></p>
                <div class="links-wrap">                  
                    <a href="{{ url('/settings') }}" >
                        <span class="me-2">Update Information</span>
                        <i class="lni lni-pencil"></i>
                    </a> 
                </div>
            </div>            
        </div>
        <div class="card">
            <div class="card-info">
                <div class="title mb-2">Important Links</div>
                <ul class="imp_links">
                    <li>
                        <a href="{{ url('/') }}"><i class="lni lni-angle-double-right me-2 text-blue"></i>Admin Panel</a>
                    </li>
                    <li>
                        <a href="{{ url('/pages') }}"><i class="lni lni-angle-double-right me-2 text-blue"></i>E-Commerce Pages</a>
                    </li>
                    <li>
                        <a href="{{ url('/collections') }}"><i class="lni lni-angle-double-right me-2 text-blue"></i>E-Commerce Collections</a>
                    </li>
                    <li>
                        <a href="{{ url('/products') }}"><i class="lni lni-angle-double-right me-2 text-blue"></i>E-Commerce Products</a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}"><i class="lni lni-angle-double-right me-2 text-blue"></i>Invoices</a>
                    </li>
                </ul> 
            </div>            
        </div>       
    </div>
</div> 