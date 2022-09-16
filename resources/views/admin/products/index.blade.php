@extends('admin.layouts.app') 
@section('content')    
  <div class="container-fluid pt-3">
    <span class="title-data" id="titleData" data-link="products" data-parent="" data-title="products"></span>
    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

    <div class="row">       
      <div class="col-sm-6 form-group mb-4 text-start">
        <a href="{{ url('products/create') }}" type="button" class="btn btn-primary custom-dark-btn float-right text-end"> 
          Add Product <i class="fa fa-plus ms-2"></i></a>
      </div>
        
      <div class="col-sm-6 form-group mb-4 text-end">
        <div class="dropdown">
          <button class="btn btn-primary custom-dark-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Filter product type
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('products.index') }}">All Product</a></li>
            <li><a class="dropdown-item" href="{{ route('product.filter','featured') }}">Featured Product</a></li>
            <li><a class="dropdown-item" href="{{ route('product.filter','t-line') }}">Product By T Line</a></li>
            <li><a class="dropdown-item" href="{{ route('product.filter','s-line') }}">Product By S Line</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="card custom_card">
      <div class="dataTables_wrapper dt-bootstrap5 table-responsive">
        @if($data->count() > 0)
          <table id="custom_datatable" data-page-length='10' class="table table-striped dataTable table-hover">
            <thead>
              <tr>
                <th>Serial no.</th>
                <th>Image</th>  
                <th>Title</th>               
                <th>Collections</th>
                <th>Status</th> 
                <th>Featured product</th>  
                <th>Created date</th>                                                                         
                <th>Action</th>                                      
              </tr>
            </thead>
            <tbody>              
              @foreach ($data as $detail)
              <tr>
                <td>{{ $loop->index + 1}}</td>
                <td><img src="{{ asset($detail->featured_image ?: 'public/watch_placeholder.png')}}" width="40"></td>  
                <td>{{ $detail->name}}</td>   
                 
                <td>@if($detail->collection_id != null)

                    @if(count($detail['collections']) > 0)
                       @foreach($detail['collections'] as $collection_name) {{$collection_name->name}} @if(($loop->index+1) != count($detail['collections'])) , @endif @endforeach
                    @else
                    -
                    @endif

                    @else
                    -
                    @endif
                </td>                
                <td>@if($detail->status=="0") Disabled @else Enabled @endif </td>        
                <td>
                  @if($detail->featured_product_status == 0)
                      @if($featured_product_count < 5)
                        <a class="tooltip-wrap featured_product" data-status="0" data-id="{{ $detail->id }}">
                            <i class="lni lni-star"></i><span class="show_name">Add</span></a>
                        @else
                        <a class="tooltip-wrap featured_product" onclick='return swal("You can add only 5 products to featured section","Please remove another product from featured section to add this product to featured section");' ><i class="lni lni-star"></i><span class="show_name">Add</span></a>
                      @endif
                      <span class="featured-position"></span>
                  @else
                      <a class="tooltip-wrap" onclick="return confirm('Do you want to remove this product to featured section?')" href="{{ route('remove.featured.product',$detail->id) }}">
                        <i class="lni lni-star-filled"></i><span class="show_name">Remove</span>
                      </a>
                      <span class="featured-position"><input type="number" min="1" oninput="validity.valid||(value='');" class="featured_product_feature" name="featured_product_feature" data-id="{{ $detail->id }}" value="{{ $detail->featured_product_position }}"></span>
                  @endif
                  
                </td> 
                <td>
                  {{$detail->created_at}}
                </td>        
                <td>
                  <a class="edit tooltip-wrap"  href="{{url('products/'.$detail->id.'/edit')}}"><i class="lni lni-pencil"></i><span class="show_name">Edit</span></a>
                    <a class="edit tooltip-wrap"  href="{{route('products.show',$detail->id)}} "><i class="lni lni-eye"></i><span class="show_name">View</span></a>  
                   <form method="POST" action="{{ route('products.destroy', $detail->id) }}">
                      @csrf
                      @method('DELETE')
                      <input name="_method" type="hidden" value="DELETE">
                      <button type="submit" class="delete tooltip-wrap show_confirm" data-toggle="tooltip" title='Delete'><i class="lni lni-trash-can"></i><span class="show_name">Delete</span></button>
                    </form>
                   
                   
                </td>                
              </tr>
              @endforeach
              <div class="bs-example">
                  <!-- Modal HTML -->
                  <div id="featured_product_modal" data-bs-backdrop="false" class="modal fade" tabindex="-1">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                          <form role="form" data-parsley-validate="" method="POST" action="{{url('add-featured-product')}}" id="edit_product_form" name="edit_product_form"  enctype="multipart/form-data">
                              {{ csrf_field() }}  
                              <div class="modal-body">
                                  <p>Enter the position of the Featured product</p>
                                
                                  <input type="hidden" value="" name="featured_product_id" id="featured_product_id">
                                  <div class="form-group row">
                                    <div class="col-sm-6 mb-3">
                                      <label for="name" class="">Name</label>              
                                      <input type="number" min="1"  oninput="validity.valid||(value='');" name="featured_position" id="featured_position" class="form-control  @error('featured_position') is-invalid @enderror" placeholder="Enter Position" required>           
                                      @error('featured_position')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror 
                                    </div>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary custom-dark-btn w-30">Save</button>
                              </div>
                          </div>
                          </form>
                      </div>
                  </div>
              </div>
            </tbody>
          </table>
        @else
          <div class="text-center"> 
            No Data Yet
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection