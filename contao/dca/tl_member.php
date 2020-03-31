<?php


unset($GLOBALS['TL_DCA']['tl_member']['config']['sql']['keys']['username']);
$GLOBALS['TL_DCA']['tl_member']['config']['sql']['keys']['email'] = 'unique';
$GLOBALS['TL_DCA']['tl_member']['fields']['firstname']['eval']['mandatory'] = false;
$GLOBALS['TL_DCA']['tl_member']['fields']['lastname']['eval']['mandatory'] = false;