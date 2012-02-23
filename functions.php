<?php

add_action('headway_visual_editor_init', 'aj_load_panel_options');
function aj_load_panel_options() {
	require_once( get_stylesheet_directory(). '/aj-hw-options.php' );
}

function switch_background_image() {
	$image = HeadwayOption::get('aj-background-image', 'general', $default);
	
	switch ($image)
	{
	case 'default':
		break;
	case 'argyle':
		echo 'header("Content-type: text/css");	body { background: url(\'wp-content/themes/aj-morris/images/argyle.png\'); }';
		break;
	case 'robots':
		wp_enqueue_style( 'headway-optin-box-block', plugins_url('/css/style2.css', __FILE__) );
		break;
	case 'pinstriped-suit':
		wp_enqueue_style( 'headway-optin-box-block', plugins_url('/css/style3.css', __FILE__) );
		break;
	}
}

add_theme_support('post-formats', array('image', 'link') );

add_action('headway_setup_child_theme', 'aj_child_setup');
function aj_child_setup(){
	remove_theme_support('headway-design-editor');
	remove_theme_support('headway-structure-css');
}

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

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
		return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
	}
add_filter('language_attributes', 'add_opengraph_doctype');

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
			<h3>About <?php the_author('display_name'); ?></h3>
			<p class="author-image"><?php echo get_avatar( get_the_author_email(), '124' ); ?></p>
			<p class="author-bio"><?php the_author_meta('description'); ?></p>
			<p class="author-follow">Follow Me On: <?php echo do_shortcode('[twitter]'); ?> <?php echo do_shortcode('[github]'); ?></p>
		</div>

	<?php }
	
}

//Change Post Buttons
add_filter('next_post_link', 'headway_change_next_post_link', 12, 2);
function headway_change_next_post_link($format, $link) {
	return preg_replace('/\">(.*?)<\/a>/i', '">Next Post &gt;&gt;</a>', $format);
}

add_filter('previous_post_link', 'headway_change_previous_post_link', 12, 2);
function headway_change_previous_post_link($format, $link) {
	return preg_replace('/\">(.*?)<\/a>/i', '">&lt;&lt; Previous Post</a>', $format);
}

//Shortcodes
add_filter('widget_text', 'do_shortcode');
add_filter('the_content', 'do_shortcode');
//Notice Function
function box_shortcode( $atts, $content = null )
{
	extract( shortcode_atts( array(
      'color' => '',
      'size' => '',
      'type' => '',
	  'align' => '',
      ), $atts ) );

      return '<div class="post-notice">' . $content . '</div>';

}
add_shortcode('box', 'box_shortcode');

//Twitter shortcode
function follow_twitter() {
	$output = '
	<a href="https://twitter.com/ajmorris" class="twitter-follow-button" data-show-count="false">Follow @ajmorris</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
	
	return $output;
}
add_shortcode('twitter', 'follow_twitter');

//Github shortcode
function follow_github() {
	$output = '
		<iframe src="http://markdotto.github.com/github-buttons/github-btn.html?user=ajmorris&type=follow&count=false"
  allowtransparency="true" frameborder="0" scrolling="0" width="165px" height="20px"></iframe>';
	return $output;
}
add_shortcode('github', 'follow_github');

//Subscribe shortcode
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
add_shortcode('subscribe', 'subscribe_box');

