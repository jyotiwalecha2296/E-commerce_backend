let menuButton = document.querySelector(".button-menu");
let container = document.querySelector(".dashboard-container");
let pageContent = document.querySelector(".page-content");
let responsiveBreakpoint = 991;

if (window.innerWidth <= responsiveBreakpoint) {
  container.classList.add("nav-closed");
}

menuButton.addEventListener("click", function () {
 container.classList.toggle("nav-closed");
});

pageContent.addEventListener("click", function () {
  if (window.innerWidth <= responsiveBreakpoint) {
    container.classList.add("nav-closed");
  }
});

window.addEventListener("resize", function () {
  if (window.innerWidth > responsiveBreakpoint) {
    container.classList.remove("nav-closed");
  }
});

$(window).scroll(function() {
  if ($(this).scrollTop() > 100){
    console.log("hello") ; 
    $('.titlebar-wrap').addClass("sticky-title");
  }
  else{
    $('.titlebar-wrap').removeClass("sticky-title");      
  }
});
$(document).ready(function () {
  $('#pageList').DataTable({ 
    
    language: {
      lengthMenu: "_MENU_",
      search: "_INPUT_",
      searchPlaceholder: "Search Pages...",
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
  // $('#recentProductTable').DataTable();
});