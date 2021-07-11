<?php

namespace App\Module;

use App\Model\ReferenceModel;
use App\Services\FormBuilder;
use Contao\FrontendUser;
use Contao\Module;
use Contao\System;
use Patchwork\Utf8;

class ReferenceListModule extends Module
{
    /**
     * @var string
     */
    protected $strTemplate = 'mod_referenceList';

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
        $form        = $formBuilder->buildRefForm($objUser->id);
        $form->getWidget('year')->addAttribute('size', 4);

        $userRef = ReferenceModel::findRefByUser($objUser->id);

        $this->Template->noEntry     = true;
        $this->Template->userRow     = ReferenceModel::findAllAsArray();
        $this->Template->refForm     = $form;
        $this->Template->requstToken = $csrfManager->getToken($form->getFormId());

        if ($form->validate() && !$userRef) {
            $arrData            = $form->fetchAll();
            $refObj             = new ReferenceModel();
            $refObj->ref_year   = $arrData['year'];
            $refObj->ref_author = $arrData['author'];
            $refObj->ref_title  = $arrData['title'];
            $refObj->pid        = $objUser->id;
            $refObj->tstamp     = time();
            $refObj->save();
            $userRef = $refObj;
            $this->Template->noEntry = false;
        }

        if ($userRef) {
            $this->Template->noEntry = false;
            $this->Template->userRef = $userRef;
            $refArtikel = $userRef->ref_author .' ('.$userRef->ref_year .') '. $userRef->ref_title;
            $this->Template->html = sprintf($this->html, $refArtikel);
        }
    }
}
