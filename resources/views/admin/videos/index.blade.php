@extends('admin.layouts.app') 
@section('content')    
  <div class="container-fluid pt-3" id="video-section">
    <span class="title-data" id="titleData" data-link="videos" data-parent="" data-title="Videos"></span>
    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

    <div class="row">  
     <div class="col-sm-9 form-group mb-4 text-start">
        <a href="{{ url('videos/create') }}" type="button" class="btn btn-primary custom-dark-btn float-right text-end">Add Video <i class="fa fa-plus ms-2"></i></a>
      </div>
      <div class="col-sm-3">
        @if($data->count() > 0)
         <div class="box box-success box-solid">
          <div class="box-body">    
            <form action="{{url('/search-videos')}}" method="POST" role="search" class="form-horizontal">
              {{ csrf_field() }}
              <div class="input-group">
                <input type="text" class="form-control" name="search"  placeholder="Search video title here" required>
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-primary custom-dark-btn float-right text-end">
                    <i class="lni lni-search-alt"></i>
                  </button>
                </span>
              </div>
              
            </form>
          </div>
        </div>
       @endif
      </div>          
     </div>
    
    <div class="card custom_card">
      <div class="dataTables_wrapper dt-bootstrap5 table-responsive">
      @if($data->count() > 0)
        
        <div class="row">      
         @foreach ($data as $detail)        
          <div class="col-sm-4 form-group mb-4">
            <video  class="video-cl" controls>
              <source src="{{asset($detail->path)}}" type="video/mp4">           
              </video>
              <div class="row">              
              <div class="col-sm-12 form-group mb-4">
                <span>{{$detail->name}}</span>
              </div>             
            </div>
             <div class="delete-video-cl">
                <form method="POST" action="{{ route('videos.destroy', $detail->id) }}">
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                 <button type="submit" class="delete tooltip-wrap show_confirm" data-toggle="tooltip" title='Delete'><i class="lni lni-cross-circle"></i><span class="show_name">Delete</span></button>
              </form>
              </div>
             
              
          </div>
          @endforeach
        </div>
<div class="col-xs-12 text-right">
  {{ $data->links('pagination::bootstrap-5') }}

                                     
                                </div>
 
        @else
          <div class="text-center"> 
            No Data Yet
          </div>
        @endif
      </div>
    </div>
  </div>

@endsection