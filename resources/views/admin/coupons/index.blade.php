@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-3">
    <span class="title-data" id="titleData" data-link="coupons" data-parent="" data-title="coupons"></span>
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    <div class="row">              
      <div class="col-sm-12 form-group mb-4 text-end">
        <a href="{{ url('coupons/create') }}" type="button" class="btn btn-primary custom-dark-btn float-right text-end"> 
          Add Coupon <i class="fa fa-plus ms-2"></i></a>
      </div>
    </div>        
    <div class="card custom_card">
      <div class="dataTables_wrapper dt-bootstrap5 table-responsive">             
        <table id="custom_datatable" class="table table-striped dataTable table-hover">
          <thead>
            <tr>
              <th>Serial No.</th> 
              <th>Coupon Code</th>   
              <th>Discount Percentage</th> 
              <th>Minimum Amount</th>                                             
              <th>Start Date</th> 
              <th>End Date</th>                                              
              <th>Status</th>
              <th>Action</th>                                       
            </tr>
          </thead>
          <tbody>
            @if($data)
            @foreach ($data as $coupons)
            <tr>
              <td>{{ $loop->index + 1}}</td>
              <td>{{ $coupons->code }}</td>
              <td>{{ $coupons->discount_percentage }}</td>  
              <td>{{ $coupons->minimum_amount }}</td>                                           
              <td>{{ $coupons->start_date }}</td> 
              <td>{{ $coupons->end_date }}</td> 
              <td>@if($coupons->status=="1") Active @else Inactive @endif </td>    
              <td>
                <a class="edit tooltip-wrap"  href="{{route('coupons.edit',$coupons->id)}} "><i class="lni lni-pencil"></i><span class="show_name">Edit</span></a>
                <form method="POST" action="{{ route('coupons.destroy', $coupons->id) }}">
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