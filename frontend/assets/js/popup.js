$(document).ready(function(c) {
        $('.forget-pass').hide();
        $('.main-register').hide();
	   $('#forget').on('click', function(c){
            $('#loginPopForm').hide();
            $('.forget-pass').show();
            
	});
        
        $('#backtologin').on('click', function(c){
            $('#loginPopForm').show();
            $('.forget-pass').hide();
	});
        
        $('.show-register').on('click', function(c){
            $('.main-register').show();
            $('.main-login').hide();
	});
        
        $('.cd-signin').on('click', function(c){
            $('.main-register').hide();
            $('.main-login').show();
            $('.forget-pass').hide();
            $('#loginPopForm').show();
            
	});
        
        $('#backtomainlogin').on('click', function(c){
            $('.main-register').hide();
            $('.main-login').show();
            $('.forget-pass').hide();
            $('#loginPopForm').show();
	}); 
});

$(window).bind("load", function() {
    $('#preloader1').fadeOut(2000);
});