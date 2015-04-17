
// Get popin


$(document).mouseup(function (e)
{
    var container = $('.popin_page_info');

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... or a descendant of the container
    {
        $('.popin_page_info').fadeOut('fast', function() {}).addClass('hidden');
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

var arrow_left, arrow_right;
index = 1;
arrow_left 	= $('.arrow.left');
arrow_right = $('.arrow.right');

arrow_left.on('click', function () {

	$('.container').css('-webkit-transform','translateX(' + ( - (index-2) * 1000) + 'px)');
	index = index-1;
});

arrow_right.on('click', function () {
	$('.container').css('-webkit-transform','translateX(' + ( - index * 1000) + 'px)');
	index = index+1;
});



// carcter limite

var stars             = $('.stars'),
n_st            = 60,
synopsis        = $('.synopsis_content'),
n_sy            = 600;

updateContent = function() {

	stars             = $('.stars');
    n_st            = 60;
    synopsis        = $('.synopsis_content');
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
}

updateContent();

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


/* API REQUEST ON TV SHOW CLICK */
var endPercent, curPerc;

function loadSerie(id) {
	var dataSent = 'id='+id;
	$.ajax({
		url: 'http://louisamiot.com/lab/series/get_tvshow.php',
		data: dataSent,
		method: 'POST',
		success: function(data) {
			data = JSON.parse(data);
			$('.big_text').html(data.original_name);
			$('.release-year').html(data.first_air_date.substr(0,4));
			$('.runtime').html(data.episode_run_time[0]+' min');
			$('.number_season').html(data.number_of_seasons+' seasons');
			$('.creators').html('');
			for (var i = 0; i < data.created_by.length; i++) {
				$('.creators').append(data.created_by[i].name+', ');
			};
			$('.synopsis_content').html(data.overview);
			endPercent = parseFloat(data.vote_average);
			curPerc = 0;
			animate();
			updateContent();
			$('.poster').attr('src','http://image.tmdb.org/t/p/w500'+data.poster_path);
			$('.show').fadeOut('fast', function() {});
			$('.popin_page_info').fadeIn('fast', function() {}).toggleClass('visible');
		},
		error: function (request, error) {
	        console.log(arguments);
    	}

	});
	$.ajax({
		url: 'http://louisamiot.com/lab/series/get_img.php',
		data: dataSent,
		method: 'POST',
		success: function(data) {
			data = JSON.parse(data);
			data = data.backdrops;
			for (var i = 0; i < data.length; i++) {
				$('.container').append('<div class="slide"><img class="photos" src="http://image.tmdb.org/t/p/w500'+data[i].file_path+'"></div>');
			};
		},
		error: function (request, error) {
			console.log(arguments);
		}
	});
	
};


/* ANIM RATING */

(function() {
var requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
                            window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
window.requestAnimationFrame = requestAnimationFrame;
})();


var canvas = document.getElementById('myCanvas');
var context = canvas.getContext('2d');
var x = canvas.width / 2;
var y = canvas.height / 2;
var radius = 45;                                    
var counterClockwise = false;
var circ = Math.PI * 2;
var quart = Math.PI / 2;

context.lineWidth = 3;
context.strokeStyle = '#66d0a0  ';


function animate(current) {
   context.clearRect(0, 0, canvas.width, canvas.height);
   context.beginPath();
   context.arc(x, y, radius, -(quart), ((circ) * current) - quart, false);
   context.stroke();
   curPerc+= 0.1;
   if (curPerc < endPercent) {
       requestAnimationFrame(function () {
           animate(curPerc / 10);
           document.getElementById('loading_rating').innerHTML = curPerc.toFixed(1);
       });
   }
}

animate();


/* FB SHARE */

fbShare = function() {
	$.ajax({
		url: 'http://louisamiot.com/lab/series/share_fb.php',
		method: 'POST',
		success: function(data) {
		},
		error: function (request, error) {
			console.log(arguments);
		}
	});
}

fb_share = function() {
	document.location = 'https://www.facebook.com/dialog/feed?app_id=145634995501895&display=popup&caption=I%20score%20<?php echo $score; ?>%20points%20at%20Blind%20Series.%20Can%20you%20beat%20me%20?&link=http%3A%2F%2Flouisamiot.com%2Flab%2Fseries%2F&redirect_uri=https://developers.facebook.com/tools/explorer';
}