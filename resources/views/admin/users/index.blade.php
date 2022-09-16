@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-3">
    <span class="title-data" id="titleData" data-link="users" data-parent="" data-title="users"></span>
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    <div class="row">              
      <div class="col-sm-12 form-group mb-4 text-end">
        <a href="{{ url('users/create') }}" type="button" class="btn btn-primary custom-dark-btn float-right text-end"> 
          Add User <i class="fa fa-plus ms-2"></i></a>
      </div>
    </div>        
    <div class="card custom_card">
      <div class="dataTables_wrapper dt-bootstrap5 table-responsive">             
        <table id="custom_datatable" class="table table-striped dataTable table-hover">
          <thead>
            <tr>
              <th>Serial No.</th> 
              <th>Image</th>   
              <th>Name</th>             
              <th>Email</th>                
              <th>Phone Number</th>   
              <th>status</th> 
              <th>Created At</th>                                                      
              <th>Action</th>                                      
            </tr>
          </thead>
          <tbody>
            @if($data)
            @foreach ($data as  $detail)            
            <tr>
              <td>{{ $loop->index + 1}}</td>
              <td><img src="{{ asset($detail->image ?: 'public/images/user.png') }}" height="45" width="50"/></td>
              <td>{{ucwords($detail->name)}}</td>
              <td>{{$detail->email}}</td>              
              <td>{{$detail->country_code}}{{$detail->contact_no}}</td>
              <td>@if($detail->status=="0") Inactive @else Active @endif </td>  
              <td>{{ $detail->created_at}}</td> 
              <td>
                <a class="tooltip-wrap" href="{{route('users.show',$detail->id)}}"> <i class="lni lni-eye"></i><span class="show_name">View</span></a>
                <a class="edit tooltip-wrap"  href="{{route('users.edit',$detail->id)}} "><i class="lni lni-pencil"></i><span class="show_name">Edit</span></a>
                <form method="POST" action="{{ route('users.destroy', $detail->id) }}">
                  @csrf
                  <input name="_method" type="hidden" value="DELETE">
                  <button type="submit" class="delete tooltip-wrap show_confirm" data-toggle="tooltip" title='Delete'><i class="lni lni-trash-can"></i><span class="show_name">Delete</span></button>
                </form>
              </td>                 
            </tr>           
            @endforeach
            @else
            <tr><td>No Record Found</td></tr>
            @endif              
          </tbody>
        </table>
      </div>
    </div>
  </div>
<script>
  $(document).ready(function() {
    $('#table').DataTable();
  } );
</script>

@endsection