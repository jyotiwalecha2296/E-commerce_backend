<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Invoice </title>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
    
  </head> 
  <body>
    <style type="text/css">
      body {
        background-color: #ffffff;
        color: #000033;
        font-family: "verdana", "sans-serif";
        margin: 0px;
        padding-top: 0px;
        font-size: 1em;
      }

      h1 {
        font-size: 1.8em;
        color: #189cd8;
      }

      h2 {
        font-size: 1.6em;
        color: #222222;
        margin-top: 30px;
        padding-bottom: 10px;
      }

      h3 { 
        font-size: 1.3em;
        color: #222222;
        margin-top: 30px;
        padding-bottom: 10px;
      }

      img { 
        border: none;
      }

      img.border {
        border: 1px solid #114C8D;
      }

      pre {
        font-family: "verdana", "sans-serif";
        color: #FFFFff;
        font-size: 0.7em;
      }
      ul {
        color: #000033;
        list-style-type: circle;
        list-style-position: inside;
        margin: 0px;
        padding: 3px;
      }

      li { 
        color: #000033;
      }

      li.alpha {
        list-style-type: lower-alpha;
        margin-left: 15px;
      }

      p {
        font-size: 0.8em;
      }

      a:link,
      a:visited {
        text-decoration: none;
        color: #114C8D;
      }
      a:hover {
        text-decoration: underline;
        color: #860000;
      }

      hr {
        border: 0;
      }
      .header{
        margin-bottom: 2em;
      }
      #page_header { 
        position: relative; /* required to make the z-index work */  
        z-index: 2;
      }

      #body {         
        padding: 12px 0.5% 2em 3px;
        min-height: 20em;
        margin: 0px;
        width: 100%;

      }

      #body pre {
        color: #000033;
      }
      
      .table .border-bottom{
        border-bottom: 1px solid lightgray;
      }
      .table-striped tr:nth-child(even) {
        background-color: #f2f2f2;
      }
      .table-striped tr:nth-child(odd) {
        background-color: #fff;
      } 
      table {
        empty-cells: show;
      }
      .table-bordered{
        border: 1px solid #eeeeee;
        border-radius: 5px;
      }              
     
    </style>
    <table style="width: 100%;" class="header" id="page_header">
      <tr>
        <td style="width: 50%; vertical-align: middle;">
          <img src="{{ $data['logo']}}" alt="Logo" width="60" />
        </td>

        <td style="width: 50%; text-align: right;">
          <h1 style="text-align: right">Invoice</h1>
          <span style="font-weight: bold; font-size: 1em; color: #333"><span>Order Id:</span> {{$data['order_id']}}</span>
        </td>
      </tr>
    </table>
    <table style="width: 100%;" id="body">
      <tr>
        <td style="width: 50%; vertical-align: top;  padding-bottom: 20px;">
          <table style="width: 80%;">
            <tr>
              <td style=""><h3>Customer Details</h3></td>
            </tr>
            <tr>
              <td style="width: 100%;">
                <table class="pt-4 table table-responsive no-footer border-bottom table-bordered" cellpadding="5px" style="width: 100%;">
                  <tr class="border-bottom">
                    <th style="text-align:left;">Name</th>
                    <td>{{ $data['customer_name']}}</td>
                  </tr>
                  <tr class="border-bottom">
                    <th style="text-align:left;">Phone:</th>
                    <td>{{ $data['customer_phone']}}</td>
                  </tr>
                  <tr>
                    <th style="text-align:left;">Email</th>
                    <td>{{ $data['customer_email']}}</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td> 
    
        <td style="width: 50%; vertical-align: top;" >
          <table style="width: 80%;">
            <tr>
              <td style="text-align:left"><h3>Order Details</h3></td>
            </tr>           
            <tr>
              <td style="width: 100%; padding-bottom: 20px;">
                <table class="table table-responsive table-bordered table-striped no-footer" cellpadding="5px" style="width: 100%;">          
                  <tr class="border-bottom">
                    <th style="text-align:left;">Order Status</th>
                    <td>{{$data['status']}}</td>
                  </tr>
                  <tr class="border-bottom">
                    <th style="text-align:left;">Order Date</th>
                    <td>{{$data['order_date']}}</td>
                  </tr>
                  <tr class="border-bottom">
                    <th style="text-align:left;">Order Time</th>
                    <td>{{$data['order_date']}}</td>
                  </tr>
                  <tr class="border-bottom">
                    <th style="text-align:left;">Total Amount</th>
                    <td>{{$data['final_total']}}</td>
                  </tr>                  
               </table>
              </td>
            </tr>
          </table>
        </td>
        
      </tr>
      <tr>
        <td colspan="2" style="padding-bottom: 30px;">
          <table style="width: 100%;" id="body" class="table table-responsive table-bordered table-striped no-footer" cellpadding="5px">
            <tr>
              <th scope="col">Serial No.</th>
                <th scope="col">Product Name</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>  
            </tr>            
            @foreach($order_item_data as $order_item)
              <tr>
                <td>{{ $loop->index + 1}}</td>                
                <td>{{ $order_item->product_name}}</td> 
                <td><img src="{{ asset($order_item->product_image)}}" height="50" width="50"/> </td>
                <td>${{ $order_item->product_price}}</td>
                <td>{{ $order_item->quantity}}</td>  
                <td>{{ $order_item->total}}</td>                
               </tr>
              @endforeach 
            
          </table> 
        </td>
      </tr>
      
      <tr>
        <td colspan="2" style="text-align:center; margin-top: 20px;" >
          <p><span style="text-align: center; font-size: 2em; width: 0.7em; height: 0.9em; line-height: 1;">THANKS FOR YOUR PURCHASE</span> 
        </td>
      </tr>
    </table>
  </body>
</html>