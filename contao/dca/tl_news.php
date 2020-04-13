<?php

$GLOBALS['TL_DCA']['tl_news']['fields']['moreLabel'] = array
		(
		    'label'                   => ['Linktext','Linktext für den Weiterleitungslink'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'                 => 'Weiterlesen ...',
			'eval'                    => array('maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		);


//$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace('{source_legend}', '{source_legend},moreLabel', $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);

use Contao\CoreBundle\DataContainer\PaletteManipulator;

PaletteManipulator::create()
    ->addField('moreLabel', 'source', PaletteManipulator::POSITION_BEFORE)
    ->applyToPalette('default', 'tl_news')
;

