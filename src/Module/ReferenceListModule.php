<?php

namespace App\Module;

use App\Model\ExtMemberModel;
use App\Model\ReferenceModel;
use App\Services\FormBuilder;
use Contao\FormTextField;
use Contao\FrontendUser;
use Contao\Module;
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
            $template = new \BackendTemplate('be_wildcard');
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
        $objUser = FrontendUser::getInstance();
        $userRef                 = ReferenceModel::findRefByUser($objUser->id);
        dump($userRef);
        if ($userRef) {
            $this->Template->noEntry = false;

        } else {

            $formBuilder = new FormBuilder();
            $form        = $formBuilder->buildForm($objUser->id);
            if ($form->validate() && !$userRef) {
                $arrData             = $form->fetchAll();
                $refObj = new ReferenceModel();

                $refObj->ref_year   = $arrData['year'];
                $refObj->ref_author = $arrData['author'];
                $refObj->ref_title  = $arrData['title'];
                $refObj->pid        = $objUser->id;
                $refObj->tstamp        = time();

                $refObj->save();
            }

            $form->getWidget('year')->addAttribute('size', 4);
            $this->Template->noEntry = true;
            $this->Template->userRow     = ReferenceModel::findAllAsArray();
            $this->Template->refForm     = $form;
            $this->Template->requstToken = \RequestToken::get();

        }

    }


}