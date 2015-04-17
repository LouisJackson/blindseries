// -------------------------------- TIMER ----------------------------


var timer = 45;
var centiSec = 100;


function countdown(){
    var str = "0" + timer;
    
    if (timer == 0) {
		timer = 45;
	}

	document.getElementById("time").innerHTML = str.substr(str.length-2,str.length);
    timer--;
   
}



function countdownBis(){
	var str = "0" + centiSec;

	if (centiSec==0) {
		centiSec = 100;
	}

	document.getElementById("timeSec").innerHTML = str.substr(str.length-2,str.length);
    centiSec--;

}

countdown();
countdownBis();

var countdownMin = window.setInterval(function(){ countdown(); }, 1000);
var countdownSec = window.setInterval(function () { countdownBis(); }, 10);




// Get popin

$('.show').on('click',function() {
	alert('yo');
	$('.show').fadeOut('fast', function() {});
	$('.popin_page_info').fadeIn('fast', function() {}).toggleClass('visible');
	return false;
});

 

$(document).mouseup(function (e)
{
    var container = $('.popin_page_info');

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... or a descendant of the container
    {
        $('.popin_page_info').fadeOut('fast', function() {}).toggleClass('hidden');
		$('.show').fadeIn('slow', function() {});
    }
});

// travel

$('.selection').click(function () {
	$('.info_content').toggleClass('hidden').toggleClass('visible');
	$('.info_photos').toggleClass('hidden').toggleClass('visible');

	$('.serie_content').toggleClass('hidden').toggleClass('visible_inline');
	$('.serie_pictures').toggleClass('hidden').toggleClass('visible_inline');


});


// slideshow

var slider_width = $('.serie_photos').width();


var Slider = function (options) {

	this.init(options);
};

Slider.prototype = {

	init : function (options) {
		this.main 			= options.target;
		this.arrow_left 	= this.main.find('.arrow.left');
		this.arrow_right 	= this.main.find('.arrow.right');
		this.container	 	= this.main.find('.container');
		this.slides 		= this.main.find('.slide');

		this.index = 0;

		var that = this;

		this.arrow_left.on('click', function () {
			that.go_to(that.index - 1);
			return false;
		});

		this.arrow_right.on('click', function () {
			that.go_to(that.index + 1);
			return false;
		});

		// key events
		$("body").keydown(function(e) {
		  if(e.keyCode == 37) { // left
		    that.go_to(that.index - 1);
			return false;
		  }
		  else if(e.keyCode == 39) { // right
		    that.go_to(that.index + 1);
			return false;
		  }
		});

	},

	go_to : function (index) {

		if (index < 0) 
			index = this.slides.length - 1;
		else if (index > this.slides.length - 1)
			index = 0;

		console.log(index);

		this.container[0].style.webkitTransform 	= 'translateX(' + ( - index * 1000) + 'px)';
		this.container[0].style.mozTransform 		= 'translateX(' + ( - index * 1000) + 'px)';
		this.container[0].style.oTransform 			= 'translateX(' + ( - index * 1000) + 'px)';
		this.container[0].style.transform 			= 'translateX(' + ( - index * 1000) + 'px)';

		this.index = index;
	}
};

var slider_2 = new Slider( { target: $('.slider-2') });




// carcter limite

var stars             = $('.stars'),
    n_st            = 60,
    synopsis        = $('.synopsis_content'),
    n_sy            = 600;
    
// Remember the text()

$('.stars').each(function() {

    $(this).data('textefull',$(this).text());
    stars.text(stars.text().substring(0,n_st));
});

$('.synopsis_content').each(function() {

    $(this).data('textefull_2',$(this).text());
    stars.text(stars.text().substring(0,n_st));
});

// start with substring

var limit_stars     = stars.text(stars.text().substring(0,n_st)),
    limit_synopsis    = synopsis.text(synopsis.text().substring(0,n_sy));

//----

$('.info_star').click(function() {

    $('.info_star').toggleClass('hidden').toggleClass('visible_inline');
    $('.stars').text($('.stars').data('textefull'));
    $('.info_star_2').toggleClass('hidden').toggleClass('visible_inline');
});


$('.info_star_2').click(function() {

    $('.info_star').toggleClass('hidden').toggleClass('visible_inline');
    $('.stars').text($('.stars').data('textefull').substring(0,n_st));
    $('.info_star_2').toggleClass('hidden').toggleClass('visible_inline');
});

// ---
$('.synopsis_info').click(function() {
    
    $('.synopsis_info').toggleClass('hidden').toggleClass('visible_inline');
    $('.synopsis_content').text($('.synopsis_content').data('textefull_2'));
    $('.synopsis_info_2').toggleClass('hidden').toggleClass('visible_inline');


});


$('.synopsis_info_2').click(function() {

    $('.synopsis_info').toggleClass('hidden').toggleClass('visible_inline');
    $('.synopsis_content').text($('.synopsis_content').data('textefull_2').substring(0,n_sy));
    $('.synopsis_info_2').toggleClass('hidden').toggleClass('visible_inline');
});
