// JavaScript Document
$(".menu_toggle_button").click(function(){
	$( ".nav.nav-justified" ).slideToggle( "slow" );
});




$(window).resize(); //on page load

jQuery('.badge_M').hover(function() {
    jQuery('.badge_text_M').show();
});

jQuery('.badge_M').mouseleave(function() {
    jQuery('.badge_text_M').hide();
});

jQuery('.badge_C').hover(function() {
    jQuery('.badge_text_C').show();
});

jQuery('.badge_C').mouseleave(function() {
    jQuery('.badge_text_C').hide();
});

jQuery('.badge_H').hover(function() {
    jQuery('.badge_text_H').show();
});

jQuery('.badge_H').mouseleave(function() {
    jQuery('.badge_text_H').hide();
});

jQuery('.badge_I').hover(function() {
    jQuery('.badge_text_I').show();
});

jQuery('.badge_I').mouseleave(function() {
    jQuery('.badge_text_I').hide();
});