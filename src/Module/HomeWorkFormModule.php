<?php

namespace App\Module;

use App\Model\ReferenceModel;
use App\Services\FormBuilder;
use Contao\FrontendUser;
use Contao\Module;
use Contao\System;
use Patchwork\Utf8;

class HomeWorkFormModule extends Module
{
    /**
     * @var string
     */
    protected $strTemplate = 'mod_homework_form';

    /**
     * Displays a wildcard in the back end.
     *
     * @return string
     */
    public function generate(): string
    {
        if (TL_MODE === 'BE') {
            $template           = new \BackendTemplate('be_wildcard');
            $template->wildcard = '### '.Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['helloWorld'][0]).' ###';
            $template->title    = $this->headline;
            $template->id       = $this->id;
            $template->link     = $this->name;
            $template->href     = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $template->parse();
        }

        return parent::generate();
    }

    /**
     * Generates the module.
     */
    protected function compile()
    {
        $csrfManager = System::getContainer()->get('contao.csrf.token_manager');
        $objUser     = FrontendUser::getInstance();
        $formBuilder = new FormBuilder();
        $form        = $formBuilder->buildWorkForm($objUser->id);
        if ($form->validate()) {
            $arrData            = $form->fetchAll();
            dump($arrData);
            die;
/*
            $refObj             = new ReferenceModel();
            $refObj->ref_year   = $arrData['year'];
            $refObj->ref_author = $arrData['author'];
            $refObj->ref_title  = $arrData['title'];
            $refObj->pid        = $objUser->id;
            $refObj->tstamp     = time();
            $refObj->save();
*/
        }

        $this->Template->homeWorkForm     = $form;
        $this->Template->requstToken = $csrfManager->getToken($form->getFormId());

    }
}