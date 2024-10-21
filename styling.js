$('.navbar-toggler').click(function() {
    if($('.my-footer').is(":hidden")){
        $('.my-footer').show();
    }
    else{
        $('.my-footer').hide();
    }
});

$('.nav-link').click(function() {
    $('.navbar-collapse').collapse('hide');
    $('.my-footer').show();
});

//Tooltips
let tooltipTriggerList;
let tooltipList;

function toggleTooltips(x) {
    if (x.matches) {
        tooltipList.forEach(function (tooltip, index) {
            tooltip.dispose();
          });
    } else {
      tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
      tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    }
  }

  let x = window.matchMedia("(max-width: 992px)")

  toggleTooltips(x);
  
  x.addEventListener("change", function() {
    toggleTooltips(x);
  }); 

$('.my-tooltip').on("mouseleave",function() {
    for(i = 0; i < tooltipList.length; i++){
        tooltipList[i].hide();
    }
});

$('.my-tooltip').on("mouseenter",function() {
    for(i = 0; i < tooltipList.length; i++){
        tooltipList[i].hide();
    }
});

$('.my-tooltip').click(function() {
    for(i = 0; i < tooltipList.length; i++){
        tooltipList[i].hide();
    }
});

