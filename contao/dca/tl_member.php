<?php


unset($GLOBALS['TL_DCA']['tl_member']['config']['sql']['keys']['username']);
$GLOBALS['TL_DCA']['tl_member']['config']['sql']['keys']['email'] = 'unique';