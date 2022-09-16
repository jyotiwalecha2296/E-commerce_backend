@extends('admin.layouts.app') 
@section('content')
<div class="container-fluid pt-5">
  <span class="title-data" id="titleData" data-link="pages/{{$pagesdata->id}}/edit" data-parent="pages" data-title="edit page"></span>
  {!!Form::model($pagesdata,['method'=>'PATCH', 'route'=>['pages.update',$pagesdata->id] ,'id'=>'form','files'=>'true' ,'data-parsley-validate' => '','name'=>'page_form']) !!}
    {{ csrf_field() }}
    <div class="row">
      <div class="col-lg-9 col-md-8 col-sm-7 order-2 order-sm-1">   
        <div class="card custom_card mb-3">
          <div class="row">
            <div class="col-sm-12">
              <span class="fs-6">Page Information</span>
            </div>
          </div> 
          <div class="card-body">
            <input type="hidden" name="page_id" value="{{$pagesdata->id}}">            
            <div class="form-group row ">
              <div class="col-sm-12 mb-3">
                <label for="name" class="form-label">Title</label>
                <input type="text" name="name" class="form-control field-validate" value="{{$pagesdata->title}}" disabled>
              </div>           
            </div>
            <div class="form-group row" >
              <div class="col-sm-12 mb-3">         
                <label class="form-label">Content</label>            
                <textarea name="content" class="form-control" placeholder="Please write content here" rows="15" id="content">{{htmlspecialchars_decode(str_replace("&quot;", "\"",$pagesdata->content))}}
                </textarea>
              </div>
              <script>
                CKEDITOR.replace('content');
                $("form").submit(function (e) {
                var messageLength = CKEDITOR.instances['content'].getData().replace(/<[^>]*>/gi, '').length;
                if (!messageLength) {
                  swal({
                    title: "You Missed Something!",
                    text: "Please write Content ",
                    icon: "warning",
                    button: "close",
                    });
                    e.preventDefault();
                  }
                });
              </script>
            </div>                
          </div>
        </div>
        <div class="card custom_card mb-3">
          <div class="collapse-box">
            <a class="collapse-border-box" data-bs-toggle="collapse" href="#pageSeoSettings" role="button" aria-expanded="false" aria-controls="pageSeoSettings">
              <span class="fs-6 title">SEO Settings </span> 
              <span class="icon">
                <i class="lni lni-chevron-down"></i>
                <i class="lni lni-chevron-up"></i>
              </span>
            </a>
            <div class="collapse" id="pageSeoSettings">
              <div class="collapse-content">
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3" >                
                      <label for="copyright_text" class="form-label">Meta Title</label>                
                      <input type="text" name="meta_title" class="form-control field-validate" value="{{$pagesdata->meta_title}}" required>
                    </div>
                    <div class="col-sm-6 mb-3" >
                      <label for="copyright_text" class="form-label">Meta Keywords</label>
                      <input type="text" name="meta_keywords" class="form-control field-validate" value="{{$pagesdata->meta_keywords}}" required>
                    </div>
                  </div>
                  <div class="form-group row ">
                    <div class="col-sm-12 mb-3" >                
                      <label for="copyright_text" class="form-label">Meta Description</label>
                      <textarea name="meta_description" class="form-control" rows="4" required>{{$pagesdata->meta_description}}</textarea>
                    </div>             
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-5 order-1 order-sm-2">
        <div class="setting-wrap">
          <div class="card mb-3">
            <div class="border-bottom">            
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#pageInfo" role="button" aria-expanded="false" aria-controls="pageSeoSettings">
                <span class="title">Update Page </span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>
            <div class="card-body">
              <div class="collapse" id="pageInfo">
                <div class="mb-3">
                  <p class="mb-1"><span>Page Name: </span><span>{{$pagesdata->title}}</span></p>
                  <p class="mb-1">
                    <span>Page Link: </span>
                    <span><a href="http://170.187.143.249/crm/pages/3/edit">http://170.187.143.249/crm/pages/{{$pagesdata->id}}/edit</a></span>
                  </p>
                </div>                
              </div> 
              <div class="w-100 text-end">
                <button type="submit" class="btn btn-primary custom-dark-btn w-30">Update</button>
              </div>
            </div> 
          </div>
          
        </div>
      </div>
    </div>
  {!! Form::close() !!}
</div>
@endsection