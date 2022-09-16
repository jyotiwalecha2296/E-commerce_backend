@extends('admin.layouts.app') 
@section('content') 
  <div class="container-fluid pt-3">
    <span class="title-data" id="titleData" data-link="pages" data-parent="" data-title="pages"></span>
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif          
    <div class="row">              
      <div class="col-sm-12 form-group mb-4 text-end">
        <a href="{{ url('pages/create') }}" type="button" class="btn btn-primary custom-dark-btn float-right text-end"> 
          Add Page <i class="fa fa-plus ms-2"></i></a>
      </div>
    </div>          
    <div class="card custom_card ">
      <div class="dataTables_wrapper dt-bootstrap5 table-responsive">
        <table id="custom_datatable" class="table table-striped dataTable table-hover">
          <thead>
            <tr>
              <th>Serial No.</th>
              <th>Title</th>
              <th>Slug</th>                                                               
              <th>Actions</th>                                   
            </tr>
          </thead>
          <tbody>
            @foreach ($all_pages as $page)
            <tr>
              <td>{{ $loop->index + 1}}</td>
              <td>{{ $page->title}}</td>
              <td>{{ $page->slug }}</td> 
              <td>
                <a class="edit tooltip-wrap"  href="{{route('pages.edit',$page->id)}} "><i class="lni lni-pencil"></i><span class="show_name">Edit</span></a>              
              <form method="POST" action="{{ route('pages.destroy', $page->id) }}">
                  @csrf
                  <input name="_method" type="hidden" value="DELETE">
                  <button type="submit" class="delete tooltip-wrap show_confirm" data-toggle="tooltip" title='Delete'><i class="lni lni-trash-can"></i><span class="show_name">Delete</span></button>
                  </form>
              </td>         
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>       
    </div> 
  </div>
@endsection