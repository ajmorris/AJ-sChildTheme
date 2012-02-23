<?php
class ManageAjChildThemePanel extends HeadwayVisualEditorPanelAPI {
	
	public $id = 'aj-child-theme';
	public $name = 'AJ\'s Child Theme Options';
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
					'default' => 'Default',
					'argyle' => 'Argyle',
					'robots' => 'Black with Robots',
					'pinstriped-suit' => 'Pinstriped Suit'
				),
				'label' => 'Background Image',
				'default' => '',
				'tooltip' => 'Change the background image of the child theme.'
			)
		)
	);

}
headway_register_visual_editor_panel('ManageAjChildThemePanel');
