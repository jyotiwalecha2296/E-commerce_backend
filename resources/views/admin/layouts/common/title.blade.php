<div class="titlebar-wrap">
	<div class="titlebar">
		<div class="collapse" id="collapseTitle">
			<div class="page-content">  
			   	<div class="row mb-2">
			   		<div class="col-sm-8 text-sm-start">
			   			<div id="pageTitle" class="page-title fs-5">Dashboard </div>
			   		</div>
			   		<div class="col-sm-4">
			   			<div class="breadcrumb" id="breadcrumb">
			   				<a href="/crm">Dashboard</a>			   				
			   			</div>
			   		</div>
			   		<script>
						window.onload = function() {
						    var element = document.getElementById("titleData");
						    console.log(element.dataset);	
							var pageLink = element.dataset.link;
							var pageTitle = element.dataset.title;
							var parentPage = element.dataset.parent;

							var breadcrumb= '';

							if(pageTitle && parentPage){
								breadcrumb+= '<a href="/crm">Dashboard</a><span class="ms-1 me-1">  >  </span><a href="'+parentPage+'">'+parentPage+'</a><span class="ms-1 me-1">  >  </span><a href="">'+pageTitle+'</a>';								
							}else if(pageTitle && !parentPage){
								breadcrumb+= '<a href="/crm">Dashboard</a><span class="ms-1 me-1">  > </span><a href="">'+pageTitle+'</a>';
							}else{
								breadcrumb+= '<a href="/crm">Dashboard</a>';
							}
							document.getElementById("breadcrumb").innerHTML=breadcrumb;

							document.getElementById("pageTitle").innerHTML=pageTitle;
						}										 
					</script>
			   	</div>
			   	<div class="row gx-0 border-radious">
			   		<div class="col count_box">
			   			<div class="total_data">
			                <div class="order_count">
			                    <p class="text-gray">Total Orders</p>
			                    <span class="fs-5 count_text">{{$order_count}}</sapn>
			                </div>
			                <div class="">
			                    <div class="order_icon">
			                        <span><i class="lni lni-cart-full"></i></span>
			                    </div>
			                    <a class="vm-link" href="{{ url('orders') }}">View More</a>
			                </div>
			            </div>			   			
			        </div>
			        <div class="col count_box">
			        	<div class="total_data">
			                <div class="order_count">
			                    <p class="text-gray">Customer</p>
			                    <span class="fs-5 count_text">{{$user_count}}</sapn>
			                </div>
			                <div class="">
			                    <div class="order_icon">
			                        <span><i class="lni lni-users"></i></span>
			                    </div>
			                    <a class="vm-link" href="{{ url('users') }}">View More</a>
			                </div>
			            </div>			        	 
			        </div>
			          <div class="col count_box">
			        	<div class="total_data">
			                <div class="order_count">
			                    <p class="text-gray">Products</p>
			                    <span class="fs-5 count_text">{{$product_count}}</h4>
			                </div>
			                <div class="">
			                    <div class="order_icon">
			                        <span><i class="lni lni-producthunt"></i></span>
			                    </div>
			                    <a class="vm-link" href="{{ url('products') }}">View More</a>
			                </div>
			            </div>			        	      
			        </div>
			        <div class="col count_box">
			        	<div class="total_data">
			                <div class="order_count">
			                    <p class="text-gray">Annual Profit</p>
			                    <span class="fs-5 count_text">489k</sapn>
			                </div>
			                <div class="">
			                    <div class="order_icon">
			                        <span><i class="lni lni-money-protection"></i></span>
			                    </div>
			                    <a class="vm-link" href="/">View More</a>
			                </div>
			            </div>
			        	   
			        </div>
			      
			        <div class="col count_box">
			        	<div class="total_data">
			                <div class="order_count">
			                    <p class="text-gray">Annual Deals</p>
			                    <span class="fs-5 count_text">2600</h4>
			                </div>
			                <div class="">
			                    <div class="order_icon">
			                        <span><i class="lni lni-package"></i></span>
			                    </div>
			                    <a class="vm-link" href="/">View More</a>
			                </div>
			            </div>				        	     
			        </div>
			   	</div>
			</div>	  
		</div>	
		<a class="btn collapse-btn" data-bs-toggle="collapse" href="#collapseTitle" role="button" aria-expanded="false" aria-controls="collapseExample">
		    <span><i class="lni lni-arrow-down"></i></span>
		    <span><i class="lni lni-arrow-up"></i></span>
		</a>		
	</div>
</div>