<?php


unset($GLOBALS['TL_DCA']['tl_member']['config']['sql']['keys']['username']);
$GLOBALS['TL_DCA']['tl_member']['config']['sql']['keys']['email'] = 'unique';
$GLOBALS['TL_DCA']['tl_member']['fields']['firstname']['eval']['mandatory'] = false;
$GLOBALS['TL_DCA']['tl_member']['fields']['lastname']['eval']['mandatory'] = false;
$GLOBALS['TL_DCA']['tl_member']['fields']['username']['eval']['nospace'] = false;
$GLOBALS['TL_DCA']['tl_member']['list']['label']['fields'] = array('icon', 'username', 'email','dateAdded');

/** reference data */

$config = array(
    'exclude'   => true,
    'search'    => true,
    'sorting'   => true,
    'flag'      => 1,
    'inputType' => 'text',
    'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
    'sql'       => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_member']['fields']['ref_year'] = $config;
$GLOBALS['TL_DCA']['tl_member']['fields']['ref_author'] = $config;
$GLOBALS['TL_DCA']['tl_member']['fields']['ref_title'] = $config;
