require('./bootstrap');
require('alpinejs');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/*Start - Toggle dropdown list*/
if(document.getElementById("userMenu") && document.getElementById("userButton")) {
    var userMenuDiv = document.getElementById("userMenu");
    var userMenu = document.getElementById("userButton");
    document.onclick = check;
}

function check(e) {
    var target = (e && e.target) || (event && event.srcElement);
    //User Menu
    if (!checkParent(target, userMenuDiv)) { // click NOT on the menu
        if (checkParent(target, userMenu)) { // click on the link
            if (userMenuDiv.classList.contains("invisible")) {
                userMenuDiv.classList.remove("invisible");
            } else {
                userMenuDiv.classList.add("invisible");
            }
        } else { // click both outside link and outside menu, hide menu
            userMenuDiv.classList.add("invisible");
        }
    }
}

function checkParent(t, elm) {
    while (t.parentNode) {
        if (t == elm) {
            return true;
        }
        t = t.parentNode;
    }
    return false;
}
/*End - Toggle dropdown list*/

$(".container-menu").on("click", "[data-route]", function(e) {
    var route = $(this).data('route');
    window.location.href = route;
});