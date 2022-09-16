@extends('admin.layouts.app') 
@section('content')    
  <div class="container-fluid pt-3">
    <span class="title-data" id="titleData" data-link="orders" data-parent="" data-title="Orders"></span>
    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif
<style>
 
/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>

      <div class="tab">
          <button class="tablinks active" onclick="openCity(event, 'pending_order_sec')">Pending Orders <small> ({{$pending_orders->count() }})</small></button>
          <button class="tablinks" onclick="openCity(event, 'processing_order_sec')">Processing Orders <small>({{$processing_orders->count() }})</small></button>
          <button class="tablinks" onclick="openCity(event, 'completed_order_sec')">Completed Orders <small>({{$completed_orders->count() }})</small></button>
          <button class="tablinks" onclick="openCity(event, 'cancelled_order_sec')">Cancelled Orders<small>({{$decline_orders->count() }})</small></button>
          <button class="tablinks" onclick="openCity(event, 'deleted_order_sec')">Deleted Orders<small>({{$deleted_orders->count() }})</small></button>
      </div>

<div id="pending_order_sec" class="tabcontent" style="display: block;"> 
       <div class="dataTables_wrapper dt-bootstrap5 table-responsive">
        @if($pending_orders->count() > 0)
          <table id="pending_order_datatable" data-page-length='25' class="table table-striped dataTable table-hover">
            <thead>
              <tr>
                <th>Serial No.</th>               
                <th>Order Id</th>  
                <th>Customer Name</th>  
                <th>Customer Email</th>
                <th>Customer Phone</th>
                <th>Total</th>
                <th>status</th>
                <th>Action</th>                                    
              </tr> 
            </thead>
            <tbody>              
              @foreach ($pending_orders as $detail)
              <tr>
                <td>{{ $loop->index + 1}}</td>                
                <td>{{ $detail->order_id}}</td> 
                <td><span class="user-img"><img src="{{ asset($detail->image ?: 'public/images/user.png')}}" width="30"></span>{{ $detail->customer_name}}</td>
                <td>{{ $detail->customer_email}}</td>
                <td>{{ $detail->customer_phone}}</td>  
                <td>${{ $detail->final_total}}</td>                  
                <td>{{ $detail->status}}</td> 
                <td>
                    <a class="edit tooltip-wrap"  href="{{route('orders.edit',$detail->order_id)}} "><i class="lni lni-pencil"></i><span class="show_name">Edit</span></a>
                    <a class="edit tooltip-wrap"  href="{{route('orders.show',$detail->order_id)}} "><i class="lni lni-eye"></i><span class="show_name">View</span></a>  
                    <form method="POST" action="{{ route('orders.destroy', $detail->order_id) }}">
                      @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <button type="submit" class="delete tooltip-wrap show_confirm" data-toggle="tooltip" title='Delete'><i class="lni lni-trash-can"></i><span class="show_name">Delete</span></button>
                    </form>
                </td>              
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="text-center"> 
            No Data Yet
          </div>
        @endif
      </div>    
</div>

<div id="processing_order_sec" class="tabcontent"> 
       <div class="dataTables_wrapper dt-bootstrap5 table-responsive">
        @if($processing_orders->count() > 0)
          <table id="processing_order_datatable" data-page-length='25' class="table table-striped dataTable table-hover">
            <thead>
              <tr>
                <th>Serial No.</th>               
                <th>Order Id</th>  
                <th>Customer Name</th>  
                <th>Customer Email</th>
                <th>Customer Phone</th>
                <th>Total</th>
                <th>status</th>
                <th>Action</th>                                    
              </tr> 
            </thead>
            <tbody>              
              @foreach ($processing_orders as $detail)
              <tr>
                <td>{{ $loop->index + 1}}</td>                
                <td>{{ $detail->order_id}}</td> 
                <td><span class="user-img"><img src="{{ asset($detail->image  ?: 'public/images/user.png')}}" width="30"></span>{{ $detail->customer_name}}</td>
                <td>{{ $detail->customer_email}}</td>
                <td>{{ $detail->customer_phone}}</td>  
                <td>${{ $detail->final_total}}</td>                  
                <td>{{ $detail->status}}</td> 
                <td>
                    <a class="edit tooltip-wrap"  href="{{route('orders.edit',$detail->order_id)}} "><i class="lni lni-pencil"></i><span class="show_name">Edit</span></a>
                    <a class="edit tooltip-wrap"  href="{{route('orders.show',$detail->order_id)}} "><i class="lni lni-eye"></i><span class="show_name">View</span></a>  
                    <form method="POST" action="{{ route('orders.destroy', $detail->order_id) }}">
                      @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <button type="submit" class="delete tooltip-wrap show_confirm" data-toggle="tooltip" title='Delete'><i class="lni lni-trash-can"></i><span class="show_name">Delete</span></button>
                    </form>
                </td>              
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="text-center"> 
            No Data Yet
          </div>
        @endif
      </div>    
</div>

<div id="completed_order_sec" class="tabcontent"> 
       <div class="dataTables_wrapper dt-bootstrap5 table-responsive">
        @if($completed_orders->count() > 0)
          <table id="completed_order_datatable" data-page-length='25' class="table table-striped dataTable table-hover">
            <thead>
              <tr>
                <th>Serial No.</th>               
                <th>Order Id</th>  
                <th>Customer Name</th>  
                <th>Customer Email</th>
                <th>Customer Phone</th>
                <th>Total</th>
                <th>status</th>
                <th>Action</th>                                    
              </tr> 
            </thead>
            <tbody>              
              @foreach ($completed_orders as $detail)
              <tr>
                <td>{{ $loop->index + 1}}</td>                
                <td>{{ $detail->order_id}}</td> 
                <td><span class="user-img"><img src="{{ asset($detail->image  ?: 'public/images/user.png')}}" width="30"></span>{{ $detail->customer_name}}</td>
                <td>{{ $detail->customer_email}}</td>
                <td>{{ $detail->customer_phone}}</td>  
                <td>${{ $detail->final_total}}</td>                  
                <td>{{ $detail->status}}</td> 
                <td>
                    <a class="edit tooltip-wrap"  href="{{route('orders.edit',$detail->order_id)}} "><i class="lni lni-pencil"></i><span class="show_name">Edit</span></a>
                    <a class="edit tooltip-wrap"  href="{{route('orders.show',$detail->order_id)}} "><i class="lni lni-eye"></i><span class="show_name">View</span></a>  
                    <form method="POST" action="{{ route('orders.destroy', $detail->order_id) }}">
                      @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <button type="submit" class="delete tooltip-wrap show_confirm" data-toggle="tooltip" title='Delete'><i class="lni lni-trash-can"></i><span class="show_name">Delete</span></button>
                    </form>
                </td>              
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="text-center"> 
            No Data Yet
          </div>
        @endif
      </div>    
</div>

<div id="cancelled_order_sec" class="tabcontent"> 
       <div class="dataTables_wrapper dt-bootstrap5 table-responsive">
        @if($decline_orders->count() > 0)
          <table id="cancelled_order_datatable" data-page-length='25' class="table table-striped dataTable table-hover">
            <thead>
              <tr>
                <th>Serial No.</th>               
                <th>Order Id</th>  
                <th>Customer Name</th>  
                <th>Customer Email</th>
                <th>Customer Phone</th>
                <th>Total</th>
                <th>status</th>
                <th>Action</th>                                    
              </tr> 
            </thead>
            <tbody>              
              @foreach ($decline_orders as $detail)
              <tr>
                <td>{{ $loop->index + 1}}</td>                
                <td>{{ $detail->order_id}}</td> 
                <td><span class="user-img"><img src="{{ asset($detail->image  ?: 'public/images/user.png')}}" width="30"></span>{{ $detail->customer_name}}</td>
                <td>{{ $detail->customer_email}}</td>
                <td>{{ $detail->customer_phone}}</td>  
                <td>${{ $detail->final_total}}</td>                  
                <td>{{ $detail->status}}</td> 
                <td>
                    <a class="edit tooltip-wrap"  href="{{route('orders.edit',$detail->order_id)}} "><i class="lni lni-pencil"></i><span class="show_name">Edit</span></a>
                    <a class="edit tooltip-wrap"  href="{{route('orders.show',$detail->order_id)}} "><i class="lni lni-eye"></i><span class="show_name">View</span></a>  
                    <form method="POST" action="{{ route('orders.destroy', $detail->order_id) }}">
                      @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <button type="submit" class="delete tooltip-wrap show_confirm" data-toggle="tooltip" title='Delete'><i class="lni lni-trash-can"></i><span class="show_name">Delete</span></button>
                    </form>
                </td>              
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="text-center"> 
            No Data Yet
          </div>
        @endif
      </div>    
</div>

<div id="deleted_order_sec" class="tabcontent"> 
       <div class="dataTables_wrapper dt-bootstrap5 table-responsive">
        @if($deleted_orders->count() > 0)
          <table id="deleted_order_datatable" data-page-length='25' class="table table-striped dataTable table-hover">
            <thead>
              <tr>
                <th>Serial No.</th>               
                <th>Order Id</th>  
                <th>Customer Name</th>  
                <th>Customer Email</th>
                <th>Customer Phone</th>
                <th>Total</th>
                <th>status</th>
                <th>Action</th>                                    
              </tr> 
            </thead>
            <tbody>              
              @foreach ($deleted_orders as $detail)
              <tr>
                <td>{{ $loop->index + 1}}</td>                
                <td>{{ $detail->order_id}}</td> 
                <td>{{ $detail->customer_name}}</td>
                <td>{{ $detail->customer_email}}</td>
                <td>{{ $detail->customer_phone}}</td>  
                <td>${{ $detail->final_total}}</td>                  
                <td>{{ $detail->status}}</td> 
                <td>
                    <a class="edit tooltip-wrap"  href="{{route('orders.edit',$detail->order_id)}} "><i class="lni lni-pencil"></i><span class="show_name">Edit</span></a>
                    <a class="edit tooltip-wrap"  href="{{route('orders.show',$detail->order_id)}} "><i class="lni lni-eye"></i><span class="show_name">View</span></a>  
                    <form method="POST" action="{{ route('orders.destroy', $detail->order_id) }}">
                      @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <button type="submit" class="delete tooltip-wrap show_confirm" data-toggle="tooltip" title='Delete'><i class="lni lni-trash-can"></i><span class="show_name">Delete</span></button>
                    </form>
                </td>              
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="text-center"> 
            No Data Yet
          </div>
        @endif
      </div>    
</div>

 

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

$(document).ready(function() {    
    $('#pending_order_datatable').DataTable({       
      language: {
        lengthMenu: "_MENU_",
        search: "_INPUT_",
        searchPlaceholder: "Search Here...",
        paginate: {
          next: '&#8250;',
          previous: '&#8249;'
        }
      }, 
      lengthMenu: [
        [10, 20, 50,100, -1],
        ['10 Records Per Page', '20 Records Per Page', '50 Records Per Page','100 Records Per Page', 'All'],
      ],
      buttons: [
        'pageLength'
      ],
      pagingType: 'simple_numbers',
      responsive: true,
    });

    //processing_order_datatable  
    $('#processing_order_datatable').DataTable({       
      language: {
        lengthMenu: "_MENU_",
        search: "_INPUT_",
        searchPlaceholder: "Search Here...",
        paginate: {
          next: '&#8250;',
          previous: '&#8249;'
        }
      }, 
      lengthMenu: [
        [10, 20, 50,100, -1],
        ['10 Records Per Page', '20 Records Per Page', '50 Records Per Page','100 Records Per Page', 'All'],
      ],
      buttons: [
        'pageLength'
      ],
      pagingType: 'simple_numbers',
      responsive: true,
    });
    
    $('#completed_order_datatable').DataTable({       
      language: {
        lengthMenu: "_MENU_",
        search: "_INPUT_",
        searchPlaceholder: "Search Here...",
        paginate: {
          next: '&#8250;',
          previous: '&#8249;'
        }
      }, 
      lengthMenu: [
        [10, 20, 50,100, -1],
        ['10 Records Per Page', '20 Records Per Page', '50 Records Per Page','100 Records Per Page', 'All'],
      ],
      buttons: [
        'pageLength'
      ],
      pagingType: 'simple_numbers',
      responsive: true,
    });


    $('#cancelled_order_datatable').DataTable({       
          language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search Here...",
            paginate: {
              next: '&#8250;',
              previous: '&#8249;'
            }
          }, 
          lengthMenu: [
            [10, 20, 50,100, -1],
            ['10 Records Per Page', '20 Records Per Page', '50 Records Per Page','100 Records Per Page', 'All'],
          ],
          buttons: [
            'pageLength'
          ],
          pagingType: 'simple_numbers',
          responsive: true,
        });

        

      $('#deleted_order_datatable').DataTable({       
          language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search Here...",
            paginate: {
              next: '&#8250;',
              previous: '&#8249;'
            }
          }, 
          lengthMenu: [
            [10, 20, 50,100, -1],
            ['10 Records Per Page', '20 Records Per Page', '50 Records Per Page','100 Records Per Page', 'All'],
          ],
          buttons: [
            'pageLength'
          ],
          pagingType: 'simple_numbers',
          responsive: true,
        });

  } );
</script>
   
  </div>

@endsection