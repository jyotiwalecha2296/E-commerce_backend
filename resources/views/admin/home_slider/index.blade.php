@extends('admin.layouts.app') 
@section('content')    
  <div class="container-fluid pt-3">
    <span class="title-data" id="titleData" data-link="home-slider" data-parent="" data-title="Home Slider"></span>
    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

    <div class="row">              
      <div class="col-sm-12 form-group mb-4 text-end">
        <a href="{{ url('home-slider/create') }}" type="button" class="btn btn-primary custom-dark-btn float-right text-end"> 
          Add Slide <i class="fa fa-plus ms-2"></i></a>
      </div>
    </div>

    <div class="card custom_card">
      <div class="dataTables_wrapper dt-bootstrap5 table-responsive">
      @if($data->count() > 0)
          <table id="custom_datatable" data-page-length='25' class="table table-striped dataTable table-hover">
            <thead>
              <tr>
                <th>Serial No.</th>               
                <th>Watch Image</th>  
                <th>Background Image</th>  
                <th>Slide Name</th>
                <th>Position</th>
                <th>status</th>
                <th>Action</th>                                    
              </tr> 
            </thead>
            <tbody>              
              @foreach ($data as $detail)
              <tr>
                <td>{{ $loop->index + 1}}</td>                
                <td><img src="{{ asset($detail->watch_image  ?: 'public/image_placeholder.png')}}" width="50"></td>  
                <td><img src="{{ asset($detail->background_image ?: 'public/image_placeholder.png')}}" width="100"></td>  
                <td>{{ $detail->title}}</td> 
                <td>{{ $detail->position}}</td>                  
                <td>@if($detail->status=="0") Disabled @else Enabled @endif </td>           
                <td><a class="edit tooltip-wrap"  href="{{route('home-slider.edit',$detail->id)}} "><i class="lni lni-pencil"></i><span class="show_name">Edit</span></a>  
                    <form method="POST" action="{{ route('home-slider.destroy', $detail->id) }}">
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
  </div>

@endsection