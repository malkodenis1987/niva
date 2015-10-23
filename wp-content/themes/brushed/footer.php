<!-- Footer -->
<?php
$footer='';
if (vp_option('vpt_option.copyright'))
{
    $footer = vp_option('vpt_option.copyright');
}
?>
<footer>
	<p style="margin-bottom: -20px; position: relative; top: 9px;">Сайт разработан <a rel="nofollow" href="mailto:malko.denis1987@gmail.com">Malko Denis</a> </p>
	<p class='credits'><?php echo $footer; ?></p>
</footer>
<!-- End Footer -->

<!-- Back To Top -->
<?php
if (vp_option('vpt_option.to_top'))
{
	echo "<a id='back-to-top' href='#'><i class='font-icon-arrow-simple-up'></i></a>";
}
?>
<!-- End Back to Top -->
<style type="text/css">
<?php
if (vp_option('vpt_option.logo'))
{
    echo "header #logo a {background: url(".vp_option('vpt_option.logo').") no-repeat;}
	    header #logo {
	        margin-left: ".vp_option('vpt_option.margin_left')."px;
	        margin-top: ".vp_option('vpt_option.margin_top')."px;
	    }
	";
}
?>
<?php
if (vp_option('vpt_option.primary_color'))
{
    $primary = vp_option('vpt_option.primary_color');
	echo "body{
		background: ".$primary.";
	}
	#home-slider .control-nav {
		background: ".$primary.";
	}
	#back-to-top {
		background-color: ".$primary.";
	}
	#navigation-mobile {
		border-bottom: 1px solid ".$primary.";
	}
	#navigation-mobile li {
		border-top: 1px solid ".$primary.";
	}
	.page {
		background: ".$primary.";
	}
	.fancybox-skin {
        background: ".$primary.";
    }
    #home-slider ul#slide-list li a {
    background-color: ".$primary.";
    }";
}
?>
<?php
if (vp_option('vpt_option.secondary_color'))
{
$secondary = vp_option('vpt_option.secondary_color');
echo "#home-slider .overlay {
		background: ".$secondary.";
	}
	#home-slider #nextslide,
	#home-slider #prevslide {
		background-color: ".$secondary.";
	}
	#home-slider #nextsection {
		background-color: ".$secondary.";
	}
	header .sticky-nav {
		background: ".$secondary.";
	}
	#navigation-mobile {
		background: ".$secondary.";
	}
	#contact-form .submit {
        background: ".$secondary.";
    }
	.page-alternate {
		background: ".$secondary.";
	}
	#contact-form input,
	#contact-form textarea {
		background: ".$secondary.";
	}
	#social ul li a {
		background: ".$secondary.";
	}
	footer {
		background: ".$secondary.";
	}
	.fancybox-close {
		background-color: ".$secondary.";
		}
		.fancybox-nav span {
			background-color: ".$secondary.";
			}"
			;}
?>
<?php
if (vp_option('vpt_option.hover_color'))
{
    $hover = vp_option('vpt_option.hover_color');
    echo "a{
	    color: ".$hover.";
    }
    .color-text {
        color: ".$hover.";
    }
    #home-slider #nextslide:hover,
    #home-slider #prevslide:hover {
        background-color:".$hover.";
    }
    #home-slider ul#slide-list li.current-slide a,
    #home-slider ul#slide-list li.current-slide a:hover {
        background-color:".$hover.";
    }
    #home-slider #nextsection:hover {
        background-color:".$hover.";
    }

    nav#menu #menu-nav li.current a,
    nav#menu #menu-nav li a:hover {
        color: ".$hover.";
    }
    .work-nav #filters li a.selected {
        color: ".$hover.";
    }
    .item-thumbs .hover-wrap .overlay-img {
        background: ".$hover.";
    }
    .image-wrap .hover-wrap .overlay-img {
    background: ".$hover.";
    }
    #contact-form .submit:hover {
        background: ".$hover.";
    }
    #social ul li:hover a,
    #social ul li.active a {
        background-color: ".$hover.";
    }
    #back-to-top:hover {
        background-color:".$hover.";
    }
    .fancybox-nav:hover span {
    background-color: ".$hover.";
    }
    .fancybox-close:hover {
        background-color: ".$hover.";
    }
    #home-slider ul#slide-list li a:hover {
    background-color: ".$hover.";
    }";
}
?>
<?php
if (vp_option('vpt_option.custom_css'))
{
	echo vp_option('vpt_option.custom_css');
}
?>
</style>

<!-- End Js -->
<!-- Js -->
<?php wp_footer(); ?>

</body>
<?php
if (vp_option('vpt_option.to_top'))
{
	echo "<script src='".get_template_directory_uri()."/js/TweenMax.min.js'></script>
    <script src='".get_template_directory_uri()."/js/ScrollToPlugin.min.js'></script>
    <script src='".get_template_directory_uri()."/js/modernizr.js'></script>
    <script src='".get_template_directory_uri()."/js/placeholder.js'></script>
    <script src='".get_template_directory_uri()."/js/Chart.min.js'></script>
    <script src='".get_template_directory_uri()."/js/main.js'></script>";
}
?>

<script type="text/javascript">
    <?php if (vp_option('vpt_option.to_top')) { ?>
	(function($){
		var scrollTime = 0.9;
		var scrollDistance = 250;

		$(window).on('mousewheel DOMMouseScroll', function(event){

			event.preventDefault();

			var delta = event.originalEvent.wheelDelta/120 || -event.originalEvent.detail/3;
			var scrollTop = $(window).scrollTop();
			var finalScroll = scrollTop - parseInt(delta*scrollDistance);

			TweenMax.to($(window), scrollTime, {
				scrollTo : { y: finalScroll, autoKill:true },
				ease: Power1.easeOut,
				overwrite: 5
			});

		});
	})(jQuery);
    <?php } ?>
	(function($){

		var $window = $(window);
		var scrollTime = 0.9;
		var scrollDistance = 250;

		$window.on("mousewheel DOMMouseScroll", function(event){

			event.preventDefault();

			var delta = event.originalEvent.wheelDelta/120 || -event.originalEvent.detail/3;
			var scrollTop = $window.scrollTop();
			var finalScroll = scrollTop - parseInt(delta*scrollDistance);

			TweenMax.to($window, scrollTime, {
				scrollTo : { y: finalScroll, autoKill:true },
				ease: Power1.easeOut,
				overwrite: 5
			});

		});
	})(jQuery);

	jQuery(document).ready(function(){
		/* ==================================================
		 Slider Options
		 ================================================== */
		BRUSHED.slider = function(){
			$.supersized({
				// Functionality
				slideshow               :   1,			// Slideshow on/off
				autoplay				:	1,			// Slideshow starts playing automatically
				start_slide             :   1,			// Start slide (0 is random)
				stop_loop				:	0,			// Pauses slideshow on last slide
				random					: 	0,			// Randomize slide order (Ignores start slide)
				slide_interval          :   <?php if (vp_option('vpt_option.slide_interval')){echo (vp_option('vpt_option.slide_interval'));}else{echo "12000";} ?>,		//11 Length between transitions
				transition              :   <?php if (vp_option('vpt_option.select_slider_effect')){echo (vp_option('vpt_option.select_slider_effect'));}else{echo "1";} ?>, 			//11 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
				transition_speed		:	<?php if (vp_option('vpt_option.transition_speed')){echo (vp_option('vpt_option.transition_speed'));}else{echo "300";} ?>,		//11 Speed of transition
				new_window				:	1,			// Image links open in new window/tab
				pause_hover             :   0,			// Pause slideshow on hover
				keyboard_nav            :   <?php if (vp_option('vpt_option.keyboard_nav')){echo (vp_option('vpt_option.keyboard_nav'));}else{echo "0";} ?>,			//11 Keyboard navigation on/off
				performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
				image_protect			:	1,			// Disables image dragging and right click with Javascript

				// Size & Position
				min_width		        :   0,			// Min width allowed (in pixels)
				min_height		        :   0,			// Min height allowed (in pixels)
				vertical_center         :   1,			// Vertically center background
				horizontal_center       :   1,			// Horizontally center background
				fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
				fit_portrait         	:   1,			// Portrait images will not exceed browser height
				fit_landscape			:   0,			// Landscape images will not exceed browser width

				// Components
				slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
				thumb_links				:	0,			// Individual thumb links for each slide
				thumbnail_navigation    :   0,			// Thumbnail navigation
				slides 					:  	[			// Slideshow Images
					<?php if (vp_option('vpt_option.slide_upload1'))
					 {
						echo "{image : '".vp_option('vpt_option.slide_upload1')."'},";
						if (vp_option('vpt_option.slide_upload2'))
					 {
						echo "{image : '".vp_option('vpt_option.slide_upload2')."'},";
					 }
					 if (vp_option('vpt_option.slide_upload3'))
					 {
						echo "{image : '".vp_option('vpt_option.slide_upload3')."'},";
					 }
					 if (vp_option('vpt_option.slide_upload4'))
					 {
						echo "{image : '".vp_option('vpt_option.slide_upload4')."'},";
					 }
					 if (vp_option('vpt_option.slide_upload5'))
					 {
						echo "{image : '".vp_option('vpt_option.slide_upload5')."'},";
					 }
					 if (vp_option('vpt_option.slide_upload6'))
					 {
						echo "{image : '".vp_option('vpt_option.slide_upload6')."'},";
					 }
					 if (vp_option('vpt_option.slide_upload7'))
					 {
						echo "{image : '".vp_option('vpt_option.slide_upload7')."'},";
					 }
					 if (vp_option('vpt_option.slide_upload8'))
					 {
						echo "{image : '".vp_option('vpt_option.slide_upload8')."'},";
					 }
					 if (vp_option('vpt_option.slide_upload9'))
					 {
						echo "{image : '".vp_option('vpt_option.slide_upload9')."'},";
					 }
					 if (vp_option('vpt_option.slide_upload10'))
					 {
						echo "{image : '".vp_option('vpt_option.slide_upload10')."'},";
					 }
					 }
					 else{
					 echo "{image : '".get_template_directory_uri()."/img/slider-images/image03.jpg'},";
					 }?>
				],
				// Theme Options
				progress_bar			:	0,			// Timer for each slide
				mouse_scrub				:	0
			});
		}
		BRUSHED.slider();
	});
	<?php
	if (vp_option('vpt_option.custom_js'))
	{
		echo vp_option('vpt_option.custom_js');
	}
	?>
</script>
</html>