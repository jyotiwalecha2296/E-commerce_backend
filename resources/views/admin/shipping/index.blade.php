@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-3">
    <span class="title-data" id="titleData" data-link="shipping" data-parent="" data-title="shipping"></span>
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    <div class="row">              
      <div class="col-sm-12 form-group mb-4 text-end">
        <a href="{{ url('shipping/create') }}" type="button" class="btn btn-primary custom-dark-btn float-right text-end"> 
          Add Shipping <i class="fa fa-plus ms-2"></i></a>
      </div>
    </div>        
    <div class="card custom_card">
      <div class="dataTables_wrapper dt-bootstrap5 table-responsive">             
        <table id="custom_datatable" class="table table-striped dataTable table-hover">
          <thead>
            <tr>
              <th>Serial No.</th> 
              <th>Country</th>
              <th>Country Code</th>  
              <th>Shipping Charges</th> 
              <th>status</th>                                                                   
              <th>Action</th>                                      
            </tr>
          </thead>
          <tbody>
            @if($data)
            @foreach ($data as $detail)
            <tr>
              <td>{{ $loop->index + 1}}</td>
              <td>{{ $detail->country}}</td>                  
              <td>{{ $detail->country_code}}</td>
              <td>${{ $detail->shipping_charges}}</td>
              <td>@if($detail->status=="0") Disabled @else Enabled @endif </td>                
              <td>
                <a class="edit tooltip-wrap"  href="{{route('shipping.edit',$detail->id)}} "><i class="lni lni-pencil"></i><span class="show_name">Edit</span></a>
                <form method="POST" action="{{ route('shipping.destroy', $detail->id) }}">
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