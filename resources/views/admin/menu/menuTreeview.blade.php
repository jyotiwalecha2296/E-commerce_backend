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
       <div class="row">
                  <div class="col-md-6">
                     <h5 class="mb-4 text-center bg-success text-white ">Add New Menu</h5>
                     <form accept="{{ route('menus.store')}}" method="post">
                        @csrf
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
                               <button type="button" class="close" data-dismiss="alert">×</button>   
                                   <strong>{{ $message }}</strong>
                           </div>
                        @endif
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Title</label>
                                 <input type="text" name="title" class="form-control">   
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Parent</label>
                                 <select class="form-control" name="parent_id">
                                    <option selected disabled>Select Parent Menu</option>
                                    @foreach($allMenus as $key => $value)
                                       <option value="{{ $key }}">{{ $value}}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                              <button class="btn btn-success">Save</button>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="col-md-6">
                     <h5 class="text-center mb-4 bg-info text-white">Menu List</h5>
                      <ul id="tree1">
                         @foreach($menus as $menu)
                            <li>
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
 <script>
  $.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        /* initialize each of the top levels */
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this);
            branch.prepend("");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        /* fire event from the dynamically added icon */
        tree.find('.branch .indicator').each(function(){
            $(this).on('click', function () {
                $(this).closest('li').click();
            });
        });
        /* fire event to open branch if the li contains an anchor instead of text */
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        /* fire event to open branch if the li contains a button instead of text */
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});
/* Initialization of treeviews */
$('#tree1').treed();
</script>

@endsection