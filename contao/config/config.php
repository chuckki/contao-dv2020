<?php

// Frontend modules
use App\Module\ReferenceListModule;
use App\Module\HomeWorkFormModule;
use App\Model\ReferenceModel;

$GLOBALS['FE_MOD']['miscellaneous']['referencesList'] = ReferenceListModule::class;
$GLOBALS['FE_MOD']['miscellaneous']['homeWork'] = HomeWorkFormModule::class;

$GLOBALS['TL_MODELS']['tl_reference'] = ReferenceModel::class;
