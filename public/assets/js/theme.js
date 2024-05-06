;
(function ($) {
    "use strict";



    sideManu()

    function sideManu() {
        let manuStor = $(".side-bar").html();

        $(".side-bar").html("<div class='overlay'></div>" + manuStor);
        $(".sidebar-opner").on("click ", function () {
            $(".side-bar, .section-container").toggleClass("active");
        });
        $(".side-bar .close-btn, .side-bar .overlay").on("click ", function () {
            $(".side-bar, .section-container").toggleClass("active");
        });

        $("li>ul").toggleClass("dropdown-menu");

        let animationSpeed = 300;

        let subMenuSelector = ".dropdown-menu";

        $('.side-bar-manu > ul').on('click', '.dropdown a', function (e) {
            let $this = $(this);
            let checkElement = $this.next();

            if (checkElement.is(subMenuSelector) && checkElement.is(':visible')) {
                checkElement.slideUp(animationSpeed, function () {
                    checkElement.removeClass('menu-open');
                });
                checkElement.parent("li").removeClass("active");
            }

            //If the menu is not visible
            else if ((checkElement.is(subMenuSelector)) && (!checkElement.is(':visible'))) {
                //Get the parent menu
                let parent = $this.parents('ul').first();
                //Close all open menus within the parent
                let ul = parent.find('ul:visible').slideUp(animationSpeed);
                //Remove the menu-open class from the parent
                ul.removeClass('menu-open');
                //Get the parent li
                let parent_li = $this.parent("li");

                //Open the target menu and add the menu-open class
                checkElement.slideDown(animationSpeed, function () {
                    //Add the class active to the parent li
                    checkElement.addClass('menu-open');
                    parent.find('li.active').removeClass('active');
                    parent_li.addClass('active');
                });
            }
            //if this isn't a link, prevent the page from being redirected
            if (checkElement.is(subMenuSelector)) {
                e.preventDefault();
            }
        });
    }

    // $('.header-select, .graph-nice-select, .table-select').niceSelect();

    //* Isotope js
    // function isotopee(){
    //     // Activate isotope in container
    //     $(".new-order-wrapper").imagesLoaded( function() {
    //         $(".new-order-wrapper").isotope({
    //             layoutMode: 'masonry',
    //             filter: '*',
    //             // animationOptions: {
    //             //     duration: 750,
    //             //     easing: 'linear',
    //             //     queue: false
    //             // }
    //         });

    //     });
    // };
    // isotopee();

    // photo upload preview
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.image-preview').attr('src', e.target.result);
                $('.image-preview').hide();
                $('.image-preview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#add-profile").change(function () {
        readURL(this);
        $('.image-preview-icon').addClass('d-none');
    });


    $("#feature-btn").click(function(e){
        e.preventDefault();
        var value = $('.add-feature').val();
        if(value !== '') {
            $('.feature-list').append(`

            <div class="col-lg-6 mb-4 remove-list">
                <div class="feature-wrp">
                    <div class="form-control d-flex justify-content-between align-items-center">
                        <input class="form-control" type="text" value=" ${value}" disabled>
                        <label class="switch m-0">
                            <input type="checkbox" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <button type="button" class="remove-one d-none"><i class="fal fa-times"></i></button>
                </div>
            </div>
            `);
            $('.add-feature').val('');
        }
    });

})(jQuery);
