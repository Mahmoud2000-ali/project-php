$(document).ready(function(){
    // Change The Show Icon
    var show = false;
    $('.pass').on('click', function(){
       if(show == false){ // show it
            $(this).css({color : '#007bff'});
            $(this).next('.custom-password').attr('type', 'text');
            show = true;
       }else{ // hide it 
            $(this).css({color : '#000'});
            $(this).next('.custom-password').attr('type', 'password');
            show = false;
       }
    });
    // Toggle The Login || sign page
    $(".title span").on('click', function(){
          $(this).addClass('select').siblings('span').removeClass('select');
          $('.signup, .login').slideUp(500);
          $('.' + $(this).data('select')).slideDown(500);
    });

    // Take The Item Description To Card
    $('.live').on('keyup', function(){
     $($(this).data('class')).text($(this).val());
    });
    // Tags
    $('#tags').tagsInput();
    // Click Me
    $('.click-me').click(function(){
     confirm('You Must Login To Save Item');
    });
    // Click Me To Remove
    $('.click-remove').click(function(){
     confirm('This Will Remove This Item From Save ');
     if(confirm == YES){
          console.log('d');
     }
    });
});