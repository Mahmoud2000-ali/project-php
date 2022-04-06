
/*
    ===============================================
    == Csutomer js File
    = Conatin All js Code in admin Control
    ===============================================

*/


$(document).ready(function(){
    // Change The Show Icon
    var show = false;
    $('.pass').on('click', function(){
       if(show == false){ // show it
            show = true;
            $(this).css({color : '#007bff'});
            $('.custom-password').attr('type', 'text');
       }else{ // hide it 
            $(this).css({color : '#000'});
            $('.custom-password').attr('type', 'password');
            show = false;
       }
    });

    // Toggle The Contain

});