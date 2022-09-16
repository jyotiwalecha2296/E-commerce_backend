jQuery(document).ready(function($) {    

   var i = 0;
   $("#dynamic-ar").click(function () {
      ++i;
      $("#dynamicAddRemove").append('<tr><td><input type="text" name="specification[' + i +
         '][label]" placeholder="Enter Label" class="form-control" /></td><td><input type="text" name="specification[' + i +
         '][value]" placeholder="Enter Value" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
         );
   });
 

   $("#dynamic-kf").click(function () {
      ++i;
      $("#dynamicAddRemoveKeyFeature").append('<tr><td><input type="file" name="key_features[' + i +
         '][image]" placeholder="Upload Image" class="form-control" /></td><td><input type="text" name="key_features[' + i +
         '][label]" placeholder="Enter Label" class="form-control" /></td><td><input type="text" name="key_features[' + i +
         '][value]" placeholder="Enter Value" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
         );
   });

    

   $("#edit-dynamic-kf").click(function () {
     var rownokf = $("#editAddRemoveKeyFeature tr").length;
     var rownokf = rownokf-1;    
      $("#editAddRemoveKeyFeature").append('<tr id="key_features_row_'+rownokf+'"><td><input type="file" name="key_features[' + rownokf +
         '][image]" placeholder="Upload Image" class="form-control" /></td><td><input type="text" name="key_features[' + rownokf +
         '][label]" placeholder="Enter Label" class="form-control" /></td><td><input type="text" name="key_features[' + rownokf +
         '][value]" placeholder="Enter Value" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
         );
   });


   $("#edit-dynamic-cat-widget").click(function () {
      console.log("a");
     var rownokf = $("#editAddRemoveCatWidget tr").length;
     var rownokf = rownokf-1;    
      $("#editAddRemoveCatWidget").append('<tr id="collection_widgets_row_'+rownokf+'"><td><input type="file" name="collection_widgets[' + rownokf +
         '][image]" placeholder="Upload Image" class="form-control" /></td><td><input type="text" name="collection_widgets[' + rownokf +
         '][label]" placeholder="Enter Label" class="form-control" /></td><td><input type="text" name="collection_widgets[' + rownokf +
         '][link]" placeholder="Enter Value" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
         );
   });


   $("#edit-dynamic-ar").click(function () {
     var rowno = $("#editspecificationstable tr").length;
     var rowno = rowno-1;    
      $("#editspecificationstable").append('<tr id="specification_row_'+rowno+'"><td><input type="text" name="specification[' + rowno +
         '][label]" placeholder="Enter Label" class="form-control" /></td><td><input type="text" name="specification[' + rowno +
         '][value]" placeholder="Enter Value" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
         );
   });

   $(document).on('click', '.remove-input-field', function () {
     
      swal({
          title: "Are you sure ?",
                  text: "you want to delete",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
          })
            .then((willDelete) => {
               if (willDelete) {


      $(this).parents('tr').remove();
       }
            });
   });

   $('.save_product_name').change(function() {
      if($(this).val() != ''){
         var product_name = $(this).val();
         var str = product_name.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ')
                 .toLowerCase();
         // trim spaces at start and end of string
         var str = str.replace(/^\s+|\s+$/gm,'');
         // replace space with dash/hyphen
         var product_slug = str.replace(/\s+/g, '-');

         $.ajax({
            type:'POST',
            url:'/crm/check-product',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data : {
               "product_slug": product_slug,  //pass the CSRF_TOKEN()
            },  
            success:function(result){
               if(result.status == false){
                  $('.save_product_slug').val(product_slug);
               }else{
                  $('.slug-result').html('<p class="slug-result">Product Name Already exist</p>');
               }   
            }
         });
      }else{
         $('.save_product_slug').val('');
      }
   });

   $('.save_product_slug').change(function() {

      if($(this).val() != ''){
         var s = $(this).val();
         if(s.indexOf(' ') >= 0){
            var str = s.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ')
                    .toLowerCase();
            // trim spaces at start and end of string
            var str = str.replace(/^\s+|\s+$/gm,'');
            // replace space with dash/hyphen
            var product_slug = str.replace(/\s+/g, '-');
         }else{
            var product_slug = $(this).val();
         }
      

         $.ajax({
            type:'POST',
            url:'/crm/check-product',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data : {
               "product_slug": product_slug,  //pass the CSRF_TOKEN()
            },  
            success:function(result){
               if(result.status == false){
                  $('.save_product_slug').val(product_slug);
               }else{
                  $('.slug-result').html('<p class="slug-result">Product Name Allready exist</p>');
               }  
            }
         });
      }else{
         $('.save_product_slug').val('');
      }
   });

   $('#product_type').on('change', function() {
      
      const optionValue = $("option:selected", this).val().toLowerCase();
      if(optionValue){
         $(".product_row").not("." + optionValue).hide();
         $("." + optionValue).show();
     } else{
         $(".product_row").hide();
     }
    
   });

   $(document).on('click', '.featured_product', function () {

      var data_status = $(this).attr('data-status');
      var data_id = $(this).attr('data-id');
      if(data_status == '0'){
         $('#featured_product_id').val(data_id);
         $("#featured_product_modal").modal('show');
        
      }else{
         //remove to feature
      }
   });

   $(document).on('change', '.featured_product_feature', function () {
      var featured_product_position = $(this).val();
      var featured_product_id = $(this).attr('data-id');
      
      if(featured_product_position){
         $.ajax({
            type:'POST',
            url:'/crm/update-featured-position',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data : {
               "featured_product_position": featured_product_position,  //pass the CSRF_TOKEN()
               "featured_product_id" : featured_product_id
            },  
            success:function(result){

               if(result.status == true){
                 window.location.reload();
               }else{
                  alert('Somthing went wrong! please try again');
               }  
            }
         });
      }else{
         alert('Somthing went wrong');
      }
   });

   $(document).on('change', '.filter-product', function () {
      var product_filter_val = $(this).val();
      
      if(product_filter_val){
         $.ajax({
            type:'POST',
            url:'/crm/product-filter',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data : {
               "product_filter_val": product_filter_val,  //pass the CSRF_TOKEN()
            },  
            success:function(result){

               if(result.status == true){
                 alert('one');
               }else{
                  alert('Somthing went wrong! please try again');
               }  
            }
         });
      }else{
         alert('Somthing went wrong');
      }
   });

});

             
 


