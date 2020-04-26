<?php

namespace App\Module;

use App\Model\ExtMemberModel;
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
            $template->title = $this->headline;
            $template->id = $this->id;
            $template->link = $this->name;
            $template->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

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

        $formBuilder = new FormBuilder();
        $form = $formBuilder->buildForm($objUser->id);

        $userRef = ExtMemberModel::findRefByUser($objUser->id);

        if ($form->validate() && !$userRef) {
            $arrData = $form->fetchAll();
            $objUser->ref_year = $arrData['year'];
            $objUser->ref_author = $arrData['author'];
            $objUser->ref_title = $arrData['title'];
            $objUser->save();
        }

        if($userRef)
        {
            foreach ($form->getWidgets() as $formField) {
                /** @var $formField FormTextField */
                //$formField->readonly = true;
                $formField->disabled = true;
            }
        /** @var FormTextField $widget */
        $widget = null;
            $form->getWidget('year')->value = '22';
        }

        /** @var FormTextField $widget */
        $form->getWidget('year')->addAttribute('size',4);

        // find all pages with language "de" and pid 1
        $this->Template->userRow = ExtMemberModel::findAllReference();
        $this->Template->refForm = $form;
        $this->Template->requstToken = \RequestToken::get();
    }


}