@extends('admin.layouts.app') 
@section('content')
   
     
<div class="container-fluid pt-3">
  <span class="title-data" id="titleData" data-link="orders" data-parent="" data-title="View Order"></span> 
  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif
  <div class="row">
   <div class="card">    
    <style>
      label:not(.form-check-label):not(.custom-file-label) {
        font-weight: 700;
      }
      .btn-default {
        background-color: #f8f9fa;
        border-color: #ddd;
        color: #444;
      }
      .text-green {
    color: #1b4b43!important;
}
.text-blue {
    color: #00457f!important;
}
.text-purple {
    color: #6f42c1!important;
}

.text-red {
    color: #df1f21!important;
}
.text-orange {
    color: #d28441!important;
}
.text-white {
    color: #ffffff!important;
}
.product-image-thumbs {
    -ms-flex-align: stretch;
    align-items: stretch;
    display: -ms-flexbox;
    display: flex;
    margin-top: 2rem;
}
.product-image-thumb {
    box-shadow: 0 1px 2px rgb(0 0 0 / 8%);
    border-radius: 0.25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    display: -ms-flexbox;
    display: flex;
    margin-right: 1rem;
    max-width: 7rem;
    padding: 0.5rem;
}
.product-image-thumb img {
    max-width: 70%;
    height: auto;
    -ms-flex-item-align: center;
    align-self: center;
}
 
 img {
    vertical-align: middle;
    border-style: none;
} 

/*tabs css*/
/* Style the tab */
 

.tab {
    overflow: hidden;
    border: 1px solid #cccccc2e;
    background-color: #f1f1f13b;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #7c7f83;
  color:white;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #7c7f83;
  color:white;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  
  border-top: none;
}


.info-box {
    box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
    border-radius: 0.25rem;
    background-color: #fff;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 1rem;
    min-height: 80px;
    padding: 0.5rem;
    position: relative;
    width: 100%;
}

.info-box .info-box-content {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-pack: center;
    justify-content: center;
    line-height: 1.8;
    -ms-flex: 1;
    flex: 1;
    padding: 0 10px;
    overflow: hidden;
}


.merch-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  grid-template-rows: masonry; /* this will do the magic */
  grid-gap: 15px;
}


  </style>    
    <div class="row">            
      <div class="col-sm-5 form-group mb-4 text-center">
        <img src="{{ asset($data->featured_image ?: 'public/watch_placeholder.png') }}" alt="featured_image" class="img-fluid" style="max-width: 30% !important;">
        <div class="row">
      @if(count($gallery_array) > 0)
      <div class="col-12 product-image-thumbs">
        @foreach($gallery_array as $gallery_img)
            <div class="product-image-thumb @if($loop->index =='0')active @endif">
              <img src="{{$gallery_img}}" alt="Product Image">
            </div>
        @endforeach         
      </div>
      @endif
    </div>
      </div>
      <div class="col-sm-7 form-group mb-4">

        <h3 class="my-3">{{$data->name}}</h3>
        <p>{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->description))}}</p>
        <hr>
        <h6 class="mt-3">Categories</h6>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          @php $col_array = explode(',',$data->collection_id); @endphp
          @foreach($collection_list as $val)
           @if(in_array($val->id,$col_array))  
          <label class="btn btn-default text-center">            
            <span class="text-xl">{{$val->name}}</span>
          </label>
          @endif 
        @endforeach
        </div>
        <br/> <br/>
          <h6> Color</h6>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <label class="btn btn-default text-center">                     
            {{$data->color}} 
            <br>
            <i class="fas fa-circle fa-2x text-{{$newcolor}}"></i>
          </label>
        </div>
           
        
        <div class="bg-gray py-2 px-3 mt-4">        
          
          @if(($data->is_steel=="0") && ($data->is_rubber=="0"))
          <h2 class="mb-0">
            ${{$data->Price}} 
          </h2>
          <br/>
          <h5 class="mt-0">
            @if($data->stock)<small>Product Stock:  {{ $data->stock }} </small> @endif 
          </h5>
          <h5 class="mt-0">
            @if($data->item_code)<small>Item Code:  {{ $data->item_code }} </small> @endif 
          </h5>

          @endif

          <h5 class="mt-0">
            @if($data->product_line_type)<small>Product Type:  {{ $data->product_line_type }} </small> @endif 
          </h5>
        </div> 
      </div>
    </div>

      @if(($data->is_steel=="1") || ($data->is_rubber=="1"))
          @if($data->is_steel=="1")
          <div class="card custom_card mb-3">
            <div class="collapse-box">
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#steelProductData" role="button" aria-expanded="false" aria-controls="pageSeoSettings">
                <span class="fs-6 title"><h5>{{$data->name}}<span style="color:#08387d"> Steel Braclet</span></h5></span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
              <div class="collapse  " id="steelProductData">
                <div class="collapse-content">
                  <div class="card-body">
                  
                   <div class="row">            
                      <div class="col-sm-7 form-group mb-4 text-start"> 
                     <br/>
                     <table class="table">                        
                          <tbody>
                            @if($data->steel_price != null) 
                            <tr>      
                              <td><strong>Product Price</strong></td>
                              <td>${{$data->steel_price}}</td>
                            </tr>
                            @endif 

                            @if($data->steel_stock != null) 
                            <tr>      
                              <td><strong>Product Stock </strong></td>
                              <td>{{$data->steel_stock}}</td>
                            </tr>
                            @endif 

                            @if($data->steel_item_code != null) 
                            <tr>      
                              <td><strong>Item Code</strong></td>
                              <td>{{$data->steel_item_code}}</td>
                            </tr>
                            @endif  
  
                            @if($data->steel_strap_image != null) 
                            <tr>      
                              <td><strong>Strap Image</strong></td>
                              <td><img src="{{asset($data->steel_strap_image ?: 'public/watch_placeholder.png')}}"  width="60" /></td>
                            </tr>
                            @endif


                           </tbody>
                      </table>
                       @if($data->steel_description) <p><strong>Description: </strong>{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->steel_description))}}</p>@endif
                      </div>
                      <div class="col-sm-1">
                      </div>
                       <div class="col-sm-4 form-group mb-4 text-start">
                        <div class="row">
                          
                              @if($data->steel_image != null) 
                              <div class="col-sm-5 card">
                                <h5 class="card-title">Featured Image</h5>
                                  <div class="text-center">
                                      <img src="{{asset($data->steel_image ?: 'public/watch_placeholder.png')}}"  width="130" />
                                </div>                              
                              </div>
                              @endif

                              
                              @if($data->steel_night_view_image != null) 
                              <div class="col-sm-5 card">
                                <h5 class="card-title">Night View Image</h5>
                                  <div class="text-center">
                                      <img src="{{asset($data->steel_night_view_image ?: 'public/watch_placeholder.png')}}"  width="130" />
                                </div>                              
                              </div>
                              @endif

                               @if($data->steel_gallery_image != null)
                                <div class="col-12 product-image-thumbs">
                                  @foreach(json_decode($data->steel_gallery_image) as $gallery_img)
                                      <div class="product-image-thumb @if($loop->index =='0')active @endif">
                                        <img src="{{$gallery_img }}" alt="Product Image">
                                      </div>
                                  @endforeach         
                                </div>
                                @endif
                        </div>
                       </div> 

                    </div>
                                 
                   
                     
                    </div>  
                  </div>
                </div>
              </div>
            </div>
           
          @endif
        
          @if($data->is_rubber=="1")

          <div class="card custom_card mb-3">
            <div class="collapse-box">
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#rubberProductData" role="button" aria-expanded="false" aria-controls="pageSeoSettings">
                <span class="fs-6 title"><h5>{{$data->name}}<span style="color:#08387d"> Rubber Strap</span></h5></span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
              <div class="collapse  " id="rubberProductData">
                <div class="collapse-content">
                  <div class="card-body">
                  
                   <div class="row">            
                      <div class="col-sm-7 form-group mb-4 text-start"> 
                     <br/>
                     <table class="table">                        
                          <tbody>
                            @if($data->rubber_price != null) 
                            <tr>      
                              <td><strong>Product Price</strong></td>
                              <td>${{$data->rubber_price}}</td>
                            </tr>
                            @endif 

                            @if($data->rubber_stock != null) 
                            <tr>      
                              <td><strong>Product Stock </strong></td>
                              <td>{{$data->rubber_stock}}</td>
                            </tr>
                            @endif 

                            @if($data->rubber_item_code != null) 
                            <tr>      
                              <td><strong>Item Code</strong></td>
                              <td>{{$data->rubber_item_code}}</td>
                            </tr>
                            @endif  
  
                            @if($data->rubber_strap_image != null) 
                            <tr>      
                              <td><strong>Strap Image</strong></td>
                              <td><img src="{{asset($data->rubber_strap_image ?: 'public/watch_placeholder.png')}}"  width="60" /></td>
                            </tr>
                            @endif


                           </tbody>
                      </table>
                       @if($data->rubber_description) <p><strong>Description: </strong>{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->rubber_description))}}</p>@endif
                      </div>
                      <div class="col-sm-1">
                      </div>
                       <div class="col-sm-4 form-group mb-4 text-start">
                        <div class="row">
                          
                              @if($data->rubber_image != null) 
                              <div class="col-sm-5 card">
                                <h5 class="card-title">Featured Image</h5>
                                  <div class="text-center">
                                      <img src="{{asset($data->rubber_image ?: 'public/watch_placeholder.png')}}"  width="130" />
                                </div>                              
                              </div>
                              @endif

                              
                              @if($data->rubber_night_view_image != null) 
                              <div class="col-sm-5 card">
                                <h5 class="card-title">Night View Image</h5>
                                  <div class="text-center">
                                      <img src="{{asset($data->rubber_night_view_image ?: 'public/watch_placeholder.png')}}"  width="130" />
                                </div>                              
                              </div>
                              @endif

                               @if($data->rubber_gallery_image != null)
                                <div class="col-12 product-image-thumbs">
                                  @foreach(json_decode($data->rubber_gallery_image) as $gallery_img)
                                      <div class="product-image-thumb @if($loop->index =='0')active @endif">
                                        <img src="{{$gallery_img}}" alt="Product Image">
                                      </div>
                                  @endforeach         
                                </div>
                                @endif
                        </div>
                       </div> 

                    </div>
                                 
                   
                     
                    </div>  
                  </div>
                </div>
              </div>
            </div>




          @endif
        @endif
    <div class="row">
  <div class="col-12">
   
 <div class="tab">
   @if($data->key_features != null)<button class="tablinks active" onclick="openCity(event, 'key_features')">Product Key Features</button>@endif
  @if($data->specification_data != null)<button class="tablinks " onclick="openCity(event, 'technical_data')">Product Technical Data</button>@endif
  <button class="tablinks" onclick="openCity(event, 'story')">Product Story</button>
  <button class="tablinks" onclick="openCity(event, 'merchandising')">Product Merchandising</button>
  <button class="tablinks" onclick="openCity(event, 'seo')">SEO Settings </button>
</div>
       @if($data->key_features != null)
      <div id="key_features" class="tabcontent" style="display: block;">
        <br/>
        <div class="row">
          @foreach($data->key_features as $key_features)
            <div class="col-12 col-sm-4">
              <div class="info-box">
                <div class="info-box-content">
                    <span class="info-box-text text-center text-muted"><img src="{{asset($key_features['image']  ?: 'public/image_placeholder.png')}}" height="50" width="50" /></span>
                    <span class="info-box-number text-center text-muted mb-0">{{ $key_features['label'] }}</span>
                     <span class="info-box-number text-center text-muted mb-0">{{ $key_features['value'] }}</span>
                </div>
                </div>
            </div>
         @endforeach 
      </div>  
      </div>
      @endif


      @if($data->specification_data != null)
      <div id="technical_data" class="tabcontent">
        <br/>
        <table class="table">
        <thead>
          <tr>
            <th scope="col">Label</th>
            <th scope="col">Value</th>       
        </thead>
        <tbody>
          @foreach($data->specification_data as $specification_details)
          <tr>      
            <td><strong>{{ $specification_details['label'] }}</strong></td>
            <td>{{ $specification_details['value'] }}</td>
          </tr>  
          @endforeach 
         </tbody>
      </table>
      </div>
      @endif


    <div id="story" class="tabcontent">
      <br/>
      <h4>{{$data->story_title}}</h4>
       <div class="row">            
          <div class="col-sm-10 form-group mb-4 text-start">
           <p>{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->story_description))}}</p>
          </div>
          <div class="col-sm-2 form-group mb-4 text-start">
            <img src="{{asset($data->story_image ?: 'public/watch_placeholder.png')}}" width="80" />
          </div>
        </div>
    </div> 

    <div id="merchandising" class="tabcontent">
       <br/>
      <div class="merch-container">   
       @foreach(json_decode($data->merchandising_images) as $key => $imgval)
         <img src="{{$imgval}}" style="width: 100%;">
      @endforeach   
      </div>
    </div> 

    <div id="seo" class="tabcontent">
         <table class="table">       
        <tbody>
          @if($data->meta_title)
          <tr>      
            <td><strong>Meta-Title</strong></td>
            <td>{{ $data->meta_title }}</td>
          </tr>
          @endif 

          @if($data->meta_keywords)
          <tr>      
            <td><strong>Meta-Keywords</strong></td>
            <td>{{ $data->meta_keywords }}</td>
          </tr>
          @endif 

          @if($data->meta_description)
          <tr>      
            <td><strong>Meta-Description</strong></td>
            <td>{{ $data->meta_description }}</td>
          </tr> 
         @endif

         </tbody>
      </table>
    </div>

 </div>
</div>

    
  </div>
</div>


<div class="back_btn view_page text-start mt-3">
  <a class="btn btn-primary float-right" href="/crm/products">Back</a>
</div>

</div>
<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
@endsection