@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-3">
    <span class="title-data" id="titleData" data-link="inquiries" data-parent="" data-title="inquiries"></span>
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
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
      <div class="col-sm-12 form-group mb-4 p-1 text-end">
       </div>
    </div>        
    <div class="card custom_card">
      <div class="dataTables_wrapper dt-bootstrap5 table-responsive"> 
      @if($data->count() > 0)            
        <table id="custom_datatable" class="table table-striped dataTable table-hover">
          <thead>
            <tr>
              <th>Serial No.</th>   
              <th>Menu Type</th>
              <th>Menu</th>                 
              <th>Action</th>               
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $detail)
            <tr>
              <td>{{ $loop->index + 1}}</td> 
              <td>{{ $detail->title}}</td>                  
              <td> <ul id="tree1" class="tree">
              
                         @foreach($detail['menu'] as $menu)
                            <li @if(count($menu->childs)) class="branch" @endif>
                                {{ $menu->title }} 
                                @if(count($menu->childs))
                                    @include('admin.menu.manageChild',['childs' => $menu->childs])
                                @endif
                            </li>
                         @endforeach
                        </ul></td>
               
              <td><a class="tooltip-wrap" href="{{url('add-menu/'.$detail->id)}}"> <i class="lni lni-circle-plus"></i><span class="show_name">Add Menu</span></a>
                  <a class="tooltip-wrap" href="{{url('edit-menu/'.$detail->id)}}"> <i class="lni lni-pencil"></i><span class="show_name">Edit Menu</span></a>
                   
                </td>            
            </tr>
            @endforeach              
          </tbody>
        </table>
        @else
        <div class="text-center">No Inquiry Received Yet</div>
        @endif
      </div>
    </div>
  </div>
 

@endsection