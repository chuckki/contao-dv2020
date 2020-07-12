<?php


$GLOBALS['TL_DCA']['tl_reference'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_member',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'foreignKey'              => 'tl_member.email',
			'sql'                     => "int(10) unsigned NOT NULL default 0",
			'relation'                => array('type'=>'belongsTo', 'load'=>'lazy')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default 0"
		),
		'dateAdded' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['MSC']['dateAdded'],
			'default'                 => time(),
			'sorting'                 => true,
			'flag'                    => 6,
			'eval'                    => array('rgxp'=>'datim', 'doNotCopy'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default 0"
		)
	)
);


$config = array(
    'exclude'   => true,
    'search'    => true,
    'sorting'   => true,
    'flag'      => 1,
    'inputType' => 'text',
    'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
    'sql'       => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_reference']['fields']['ref_year'] = $config;
$GLOBALS['TL_DCA']['tl_reference']['fields']['ref_author'] = $config;
$GLOBALS['TL_DCA']['tl_reference']['fields']['ref_title'] = $config;
$GLOBALS['TL_DCA']['tl_reference']['fields']['submission'] = array(
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'),
    'sql'       => "varchar(10) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_reference']['fields']['q1'] = array(
    'exclude'     => true,
    'search'      => true,
    'inputType'   => 'textarea',
    'eval'        => array('mandatory' => true, 'rte' => 'tinyMCE', 'helpwizard' => true),
    'sql'         => "mediumtext NULL",
);
$GLOBALS['TL_DCA']['tl_reference']['fields']['q2'] = array(
    'exclude'     => true,
    'search'      => true,
    'inputType'   => 'textarea',
    'eval'        => array('mandatory' => true, 'rte' => 'tinyMCE', 'helpwizard' => true),
    'sql'         => "mediumtext NULL",
);
$GLOBALS['TL_DCA']['tl_reference']['fields']['q3'] = array(
    'exclude'     => true,
    'search'      => true,
    'inputType'   => 'textarea',
    'eval'        => array('mandatory' => true, 'rte' => 'tinyMCE', 'helpwizard' => true),
    'sql'         => "mediumtext NULL",
);
$GLOBALS['TL_DCA']['tl_reference']['fields']['q4'] = array(
    'exclude'     => true,
    'search'      => true,
    'inputType'   => 'textarea',
    'eval'        => array('mandatory' => true, 'rte' => 'tinyMCE', 'helpwizard' => true),
    'sql'         => "mediumtext NULL",
);
$GLOBALS['TL_DCA']['tl_reference']['fields']['q5'] = array(
    'exclude'     => true,
    'search'      => true,
    'inputType'   => 'textarea',
    'eval'        => array('mandatory' => true, 'rte' => 'tinyMCE', 'helpwizard' => true),
    'sql'         => "mediumtext NULL",
);
$GLOBALS['TL_DCA']['tl_reference']['fields']['q6'] = array(
    'exclude'     => true,
    'search'      => true,
    'inputType'   => 'textarea',
    'eval'        => array('mandatory' => true, 'rte' => 'tinyMCE', 'helpwizard' => true),
    'sql'         => "mediumtext NULL",
);
$GLOBALS['TL_DCA']['tl_reference']['fields']['q7'] = array(
    'exclude'     => true,
    'search'      => true,
    'inputType'   => 'textarea',
    'eval'        => array('mandatory' => true, 'rte' => 'tinyMCE', 'helpwizard' => true),
    'sql'         => "mediumtext NULL",
);
$GLOBALS['TL_DCA']['tl_reference']['fields']['q8'] = array(
    'exclude'     => true,
    'search'      => true,
    'inputType'   => 'textarea',
    'eval'        => array('mandatory' => true, 'rte' => 'tinyMCE', 'helpwizard' => true),
    'sql'         => "mediumtext NULL",
);
$GLOBALS['TL_DCA']['tl_reference']['fields']['q9'] = array(
    'exclude'     => true,
    'search'      => true,
    'inputType'   => 'textarea',
    'eval'        => array('mandatory' => true, 'rte' => 'tinyMCE', 'helpwizard' => true),
    'sql'         => "mediumtext NULL",
);
$GLOBALS['TL_DCA']['tl_reference']['fields']['autosave'] = array(
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => array('tl_class' => 'w50'),
    'sql'       => "char(1) NOT NULL default ''",
);

