<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
<script>
    $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this record?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
 

 //datatable
  $(document).ready(function() {    
    $('#custom_datatable').DataTable({       
      language: {
        lengthMenu: "_MENU_",
        search: "_INPUT_",
        searchPlaceholder: "Search Here...",
        paginate: {
          next: '&#8250;',
          previous: '&#8249;'
        }
      }, 
      lengthMenu: [
        [10, 20, 50,100, -1],
        ['10 Records Per Page', '20 Records Per Page', '50 Records Per Page','100 Records Per Page', 'All'],
      ],
      buttons: [
        'pageLength'
      ],
      pagingType: 'simple_numbers',
      responsive: true,
    });
  } );
</script>