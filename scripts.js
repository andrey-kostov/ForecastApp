$(document).ready(function(){
    $(".precipitation-bar-wrapper.owl-carousel").owlCarousel({
        margin:10,
        responsive:{
            0:{
                items:10
            },
            600:{
                items:16
            },
            1000:{
                items:33
            }
        }
    });

    $(".hrs-wrapper.owl-carousel").owlCarousel({
        margin:10,
        responsive:{
            0:{
                items:2
            },
            600:{
                items:4
            },
            1000:{
               items:6
            }
        }
    });

    $(".day-wrapper.owl-carousel").owlCarousel({
        margin:10,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
               items:2
            }
        }
    });


  });