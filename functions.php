<?php

// Headway Specific Code

// Register Custom Block Classes
// add_action('init', 'aj_child_theme_add_block_styles');
// function aj_child_theme_add_block_styles() {
// 
// 	HeadwayChildThemeAPI::register_block_style(array(
// 		'id' => 'green',
// 		'name' => 'Groovy Green',
// 		'class' => 'green groovy'
// 		// This will show for every block
// 	));
// 
// 	HeadwayChildThemeAPI::register_block_style(array(
// 		'id' => 'blue',
// 		'name' => 'Badass Blue',
// 		'class' => 'blue',
// 		'block-types' => array('navigation', 'footer')
// 		// This will only show for certain blocks that are in the array.
// 	));
// 
// }

// Loads the Panel functions file created in the Child Theme
add_action('headway_visual_editor_init', 'aj_load_panel_options');
function aj_load_panel_options() {
	require_once( get_stylesheet_directory(). '/aj-hw-options.php' );
}

// Adds an inline style to the <head> so that you can
add_action('wp_head', 'switch_background_image');
function switch_background_image() {
	$image = HeadwayOption::get('aj-background-image', 'general');
	
	switch ($image)
	{
	case 'square_bg.png':
		break;
	case 'argyle.png':
		echo '<style type="text/css"> body { background: url(\'wp-content/themes/aj-morris/images/argyle.png\'); } </style>';
		break;
	case 'robots.png':
		echo '<style type="text/css"> body { background: url(\'wp-content/themes/aj-morris/images/robots.png\'); } </style>';
		break;
	case 'pinstriped_suit.png':
		echo '<style type="text/css"> body { background: url(\'wp-content/themes/aj-morris/images/pinstriped_suit.png\'); } </style>';
		break;
	}
}



// Non-Headway Specific Code

// Adds Post Format support for images since I like to post images at time
add_theme_support('post-formats', array('image', 'link') );

// Removes a few things from Headway when the child theme is activated.
// In this case, the design editor is turned off, and there's not outputted css from Headway,
// other than what's needed for the grid
add_action('headway_setup_child_theme', 'aj_child_setup');
function aj_child_setup(){
	remove_theme_support('headway-design-editor');
	remove_theme_support('headway-structure-css');
}


// Adds the facebook like button code to the <head> area so that it can be displayed
add_action('wp_head', 'facebook_like_button');
function facebook_like_button() {
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=285510254349";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php
}

// Adding the Open Graph in the Language Attributes
add_filter('language_attributes', 'add_opengraph_doctype');
function add_opengraph_doctype( $output ) {
	return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}


// Adds Google's +1 script to the <head>
add_action('wp_head', 'add_to_head');
function add_to_head() {
?>

<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

<?php
}

// This contains everything below the post. Has Social Sharing, Affiliate box, and Author Bio
add_action('headway_after_entry_content', 'aj_bio_share');
function aj_bio_share() {
	
	if(is_single()) { ?>
		
		<div class="post-ending"></div>
		
		<div class="social-sharing">
			<h3>Like this Article? Considering Sharing with Others!</h3>
			<ul class="sharing-loc">
				<li><fb:like class="fb-like" send="false" layout="button_count" width="40" show_faces="false"></fb:like></li>
				<li><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="ajmorris" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" >Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></li>
				<li><g:plusone size="medium"><?php echo the_permalink(); ?></g:plusone></li>
			</ul>
		</div>
		
		<div class="headway-aff">
			<h3>Get the best theme out there</h3>
			<a href="/make/headway"><img src="/wp-content/themes/aj-morris/images/headway_aff.png" alt="headway_aff" width="125" height="125" /></a>
			<p>Headway gives you total control over the appearance of your WordPress site without writing any code. Headway lets you design your site your way.</p>
		</div>
		
		<div class="below-entry-subscribe">
			<span class="subscribe-heading">If you enjoyed this article, sign up for the newsletter (it's free!)</span>
			<?php echo do_shortcode('[emailbuddy type="event" list="1" button="Get Instant Access!" confirmation="Thank you for subscribing!" text="Enter Email Addess"]'); ?>
		</div>
		
		<div class="author">
			<h3>About <?php echo get_the_author_meta('display_name'); ?></h3>
			<p class="author-image"><?php echo get_avatar( get_the_author_meta('email'), '124' ); ?></p>
			<p class="author-bio"><?php the_author_meta('description'); ?></p>
			<p class="author-follow">Follow Me On: <?php echo do_shortcode('[twitter]'); ?> <?php echo do_shortcode('[github]'); ?></p>
		</div>

	<?php }
	
}

// Change Post Buttons
add_filter('next_post_link', 'headway_change_next_post_link', 12, 2);
function headway_change_next_post_link($format, $link) {
	return preg_replace('/\">(.*?)<\/a>/i', '">Next Post &gt;&gt;</a>', $format);
}

add_filter('previous_post_link', 'headway_change_previous_post_link', 12, 2);
function headway_change_previous_post_link($format, $link) {
	return preg_replace('/\">(.*?)<\/a>/i', '">&lt;&lt; Previous Post</a>', $format);
}

// Shortcodes

// Adds the ability to run shortcodes in the text widget and the content of a post
add_filter('widget_text', 'do_shortcode');
add_filter('the_content', 'do_shortcode');

// Notice shortcode
add_shortcode('box', 'box_shortcode');
function box_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
      'color' => '',
      'size' => '',
      'type' => '',
	  'align' => '',
      ), $atts ) );

      return '<div class="post-notice">' . $content . '</div>';
}

// Twitter shortcode
add_shortcode('twitter', 'follow_twitter');
function follow_twitter() {
	$output = '
	<a href="https://twitter.com/ajmorris" class="twitter-follow-button" data-show-count="false">Follow @ajmorris</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
	
	return $output;
}

// Github shortcode
add_shortcode('github', 'follow_github');
function follow_github() {
	$output = '
		<iframe src="http://markdotto.github.com/github-buttons/github-btn.html?user=ajmorris&type=follow&count=false"
  allowtransparency="true" frameborder="0" scrolling="0" width="165px" height="20px"></iframe>';
	return $output;
}

// Subscribe shortcode
add_shortcode('subscribe', 'subscribe_box');
function subscribe_box() {
	$emailbuddy = do_shortcode('[emailbuddy type="event" list="1" button="Join Today!" confirmation="Thank you for subscribing!" text="Enter Email Addess"]');
	$output .= '
		<div class="subscribe-box">
			<span class="subscribe-heading">Sign up for the <strong>FREE</strong> newsletter, giving you access to great tips and tricks.</span>
			' .$emailbuddy. '
		</div>
	';
	
	return $output;
}

