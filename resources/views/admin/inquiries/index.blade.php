@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-3">
    <span class="title-data" id="titleData" data-link="inquiries" data-parent="" data-title="inquiries"></span>
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
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
              <th>Name</th>
              <th>Email</th>  
              <th>Subject</th>  
              <th>Message</th>   
              <th>status</th> 
              <th>Created At</th>   
              <th>Action</th>               
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $detail)
            <tr>
              <td>{{ $loop->index + 1}}</td> 
              <td>{{ $detail->name}}</td>                  
              <td>{{$detail->email}}</td>
              <td>{{$detail->subject}}</td>
              <td>{{mb_strimwidth($detail->message, 0, 70, "...") }}</td>
              <td>@if($detail->status=="0") Pending @else Replied @endif </td>  
              <td>{{ $detail->created_at}}</td>  
              <td><a class="tooltip-wrap" href="{{route('inquiries.show',$detail->id)}}"> <i class="lni lni-eye"></i><span class="show_name">View</span></a>
                  <form method="POST" action="{{ route('inquiries.destroy', $detail->id) }}">
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
        <div class="text-center">No Inquiry Received Yet</div>
        @endif
      </div>
    </div>
  </div>
 

@endsection