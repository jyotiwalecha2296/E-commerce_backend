@extends('admin.layouts.app') 
@section('content')
<div class="container-fluid pt-3">
  <span class="title-data" id="titleData" data-link="add-menu" data-parent="" data-title="Add Menu"></span>
   <style>
    .tree, .tree ul {
      margin:0;
      padding:0;
      list-style:none
    }
    .tree ul {
      margin-left:1em;
      position:relative
    }
    .tree ul ul {
      margin-left:.5em
    }
    .tree ul:before {
      content:"";
      display:block;
      width:0;
      position:absolute;
      top:0;
      bottom:0;
      left:0;
      border-left:1px solid
    }
    .tree li {
      margin:0;
      padding:0 1em;
      line-height:2em;
      color:#369;
      font-weight:700;
      position:relative
    }
    .tree ul li:before {
      content:"";
      display:block;
      width:10px;
      height:0;
      border-top:1px solid;
      margin-top:-1px;
      position:absolute;
      top:1em;
      left:0
    }
    .tree ul li:last-child:before {
      background:#fff;
      height:auto;
      top:1em;
      bottom:0
    }
    .indicator {
      margin-right:5px;
    }
    .tree li a {
      text-decoration: none;
      color:#369;
    }
    .tree li button, .tree li button:active, .tree li button:focus {
      text-decoration: none;
      color:#369;
      border:none;
      background:transparent;
      margin:0px 0px 0px 0px;
      padding:0px 0px 0px 0px;
      outline: 0;
    }
  </style>
  <head>
    <title>Create Drag and Droppable Datatables Using jQuery UI Sortable in Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
  <div class="row"> 
    <div class="back_btn view_page text-start my-3">
      <a class="btn btn-primary float-right" href="/crm/menus"><i class="lni lni-arrow-left"></i>&nbsp;Back</a>
    </div>             
    <div class="col-lg-9 col-md-8 col-sm-7 order-2 order-sm-1">

      <div class="card custom_card">  
        <div class="row">
          <div class="col-sm-6">
            <span class="fs-6">Edit {{$menu_type->title}}</span>
          </div>
          <div class="col-sm-6 text-end">
            <a class="btn btn-primary" href="{{url('add-menu/'.$menu_type->id)}}"> <i class="lni lni-circle-plus"></i> Add Menu</a>
          </div>
        </div>          
        <div class="card-body">    
         
             
          <input type="hidden" value="{{$menu_type->id}}" name="menu_type">
          @if(count($errors) > 0)
          <div class="alert alert-danger  alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            @foreach($errors->all() as $error)
            {{ $error }}<br>
            @endforeach
          </div>
          @endif
          @if ($message = Session::get('success'))
          <div class="alert alert-success  alert-dismissible">              
           <strong>{{ $message }}</strong>
         </div>
         @endif
         <table  class="table table-striped dataTable" id="table">
          <thead>
            <tr>                
              <th>Title</th>
              <th>Parent</th>  
              <th>Link</th>
              <th>Update</th>
              <th>Remove</th>                
                        
            </tr>
          </thead>
          <tbody id="tablecontents">
            @foreach($allMenus as $menu)
            <tr class="row1" data-id="{{$menu->id}}">
              <form role="form" data-parsley-validate="" method="POST" action="{{url('update-menu')}}">
               @csrf
               <input type="hidden" value="{{$menu->id}}" name="menu_id">
              <td><input type="text" name="title" class="form-control field-validate" placeholder="Enter Title Here" value="{{ $menu->title }}"></td> 
              <td>
                  <select class="form-control" name="parent_id">
                    <option selected disabled>Select Parent Menu</option>
                    <option value="0" @if($menu->parent_id=="0")selected @endif>None</option>
                    @foreach($allMenus as  $menuvalue)
                    <option value="{{ $menuvalue->id }}" @if($menu->parent_id==$menuvalue->id)selected @endif>{{ $menuvalue->title}}</option>
                    @endforeach
                   </select>
              </td>                  
              <td><input type="text" name="link" class="form-control field-validate" placeholder="Enter link here" value="{{ $menu->link }}"></td>               
              <td><button class="btn btn-primary custom-dark-btn w-30" data-toggle="tooltip" title="Edit"><i class="lni lni-pencil"></i></button></td>  
              </form>
              <td><form method="POST" action="{{url('delete-menu')}}">
                    @csrf
                    <input type="hidden" value="{{$menu->id}}" name="menu_id">
                    <button type="submit" class="delete tooltip-wrap show_confirm" data-toggle="tooltip" title='Delete'><i class="lni lni-trash-can"></i><span class="show_name">Delete</span></button>
                  </form>
                </td>       
            </tr>
            @endforeach              
          </tbody>
        </table>
    </div>              
  </div>
</div>
<div class="col-lg-3 col-md-4 col-sm-5 order-1 order-sm-2">
 <div class="setting-wrap">
  <div class="card">
    <div class="border-bottom">            
      <a class="collapse-border-box" data-bs-toggle="collapse" href="#pageInfo" role="button" aria-expanded="false" aria-controls="pageSeoSettings">
        <span class="title">Preview {{$menu_type->title}}</span> 
        <span class="icon">
          <i class="lni lni-chevron-down"></i>
          <i class="lni lni-chevron-up"></i>
        </span>
      </a>
    </div>             
    <ul id="tree1" class="tree">
     @foreach($menus as $menu)
     <li  @if(count($menu->childs)) class="branch" @endif>
      {{ $menu->title }}
      @if(count($menu->childs))
      @include('admin.menu.manageChild',['childs' => $menu->childs])
      @endif
    </li>
    @endforeach
  </ul>
</div>
</div>
</div>


</div>        

</div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
    <script type="text/javascript">
      $(function () {
        $("#table").DataTable();

        $( "#tablecontents" ).sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function() {
              sendOrderToServer();
              
              window.location.reload();
          }
        });

        function sendOrderToServer() {
          var order = [];
          var token = $('meta[name="csrf-token"]').attr('content');
          $('tr.row1').each(function(index,element) {
            order.push({
              id: $(this).attr('data-id'),
              position: index+1
            });
          });

          $.ajax({
            type: "POST", 
            dataType: "json", 
            url: "{{ url('menu-sortable') }}",
                data: {
              order: order,
              _token: token
            },
            success: function(response) {
                if (response.status == "success") {
                  console.log(response);
                } else {
                  console.log(response);
                }
            }
          });
        }
      });
    </script>

@endsection