<?php


unset($GLOBALS['TL_DCA']['tl_member']['config']['sql']['keys']['username']);
$GLOBALS['TL_DCA']['tl_member']['config']['sql']['keys']['email'] = 'unique';
$GLOBALS['TL_DCA']['tl_member']['fields']['firstname']['eval']['mandatory'] = false;
$GLOBALS['TL_DCA']['tl_member']['fields']['lastname']['eval']['mandatory'] = false;
$GLOBALS['TL_DCA']['tl_member']['fields']['username']['eval']['nospace'] = false;
$GLOBALS['TL_DCA']['tl_member']['list']['label']['fields'] = array('icon', 'username', 'email',  'groups:tl_member_group.name','dateAdded');
