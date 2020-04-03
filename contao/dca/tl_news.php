<?php

$GLOBALS['TL_DCA']['tl_news']['fields']['moreLabel'] = array
		(
		    'label'                   => ['Linktext','Linktext für den Weiterleitungslink'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'                 => 'Weiterlesen ...',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50 clr'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		);


// using str_replace() to insert the field after the username
$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace('{source_legend}', '{source_legend},moreLabel', $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);
//str_replace('source_legend', '{source_legend},moreLabel', $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);


