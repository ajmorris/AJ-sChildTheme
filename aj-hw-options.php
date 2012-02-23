<?php
class ManageAjChildThemePanel extends HeadwayVisualEditorPanelAPI {
	
	public $id = 'aj-child-theme';
	public $name = 'Child Theme Options';
	public $mode = 'manage';
	
	public $tabs = array(
		'background' => 'Background'
	);
	
	public $tab_notices = array(
		'background' => 'These settings are for the child theme you\'ve activated.'
	);
	
	public $inputs = array(		
		'background' => array(
			'aj-background-image' => array(
				'type' => 'select',
				'name' => 'aj-background-image',
				'options' => array(
					'square_bg.png' => 'Default',
					'argyle.png' => 'Argyle',
					'robots.png' => 'Black with Robots',
					'pinstriped_suit.png' => 'Pinstriped Suit'
				),
				'label' => 'Background Image',
				'default' => 'Default',
				'tooltip' => 'Change the background image of the theme.',
				'callback' => '$i("body").css({background: "url(" + Headway.childThemeURL + "/images/" + value + ") white" });'
			)
		)
	);

}
headway_register_visual_editor_panel('ManageAjChildThemePanel');


