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
  <div class="row"> 
    <div class="back_btn view_page text-start my-3">
      <a class="btn btn-primary float-right" href="/crm/menus"><i class="lni lni-arrow-left"></i>&nbsp;Back</a>
    </div>             
    <div class="col-lg-9 col-md-8 col-sm-7 order-2 order-sm-1">

      <div class="card custom_card">  
        <div class="row">
          <div class="col-sm-6">
            <span class="fs-6">Add New Menu In {{$menu_type->title}}</span>
          </div>
          <div class="col-sm-6 text-end">
            <a class="btn btn-primary" href="{{url('edit-menu/'.$menu_type->id)}}"> <i class="lni lni-pencil"></i> Edit Menu</a>
          </div>
        </div>          
        <div class="card-body">    
         
            <form role="form" data-parsley-validate="" method="POST" action="{{url('store-menu')}}">
                                           
          @csrf
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

         <div class="form-group row">
          <div class="col-sm-12 mb-3"> 
            <label for="name" class="form-label">Title</label>              
            <input type="text" name="title" class="form-control field-validate" placeholder="Enter Title Here" value="">
          </div>              
        </div>

        <div class="form-group row">
          <div class="col-sm-12 mb-3"> 
            <label for="name" class="form-label">Menu Type</label>              
            <input type="text" disabled class="form-control field-validate" value="{{$menu_type->title}}">
          </div>              
        </div>


        <div class="form-group row">
          <div class="col-sm-12 mb-3"> 
            <label for="name" class="form-label">Parent</label>              
            <select class="form-control" name="parent_id">
              <option selected disabled>Select Parent Menu</option>
              @foreach($allMenus as  $menuvalue)
              <option value="{{ $menuvalue->id }}">{{ $menuvalue->title}}</option>
              @endforeach
            </select>
          </div>              
        </div>

        <div class="form-group row">
          <div class="col-sm-12 mb-3"> 
            <label for="name" class="form-label">Link</label>              
            <input type="text" name="link" class="form-control field-validate" placeholder="Enter menu link here" value="">
          </div>              
        </div>
        

        <div class="w-100 text-end">
          <button class="btn btn-primary custom-dark-btn w-30">Save</button>
        </div>
      </form> 
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


@endsection