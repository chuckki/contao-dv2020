<?php

namespace App\Module;

use App\Model\ExtMemberModel;
use Contao\FrontendUser;
use Contao\Input;
use Contao\MemberModel;
use Contao\Module;
use Patchwork\Utf8;

class ReferenceListModule extends Module
{
    /**
     * @var string
     */
    protected $strTemplate = 'module/mod_referenceList';

    /**
     * Displays a wildcard in the back end.
     *
     * @return string
     */
    public function generate()
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
        // find all pages with language "de" and pid 1
        $userData = ExtMemberModel::findAllReference();
        $objUser = FrontendUser::getInstance();

        $formId = 'addReference_' . $objUser->id;

        if (Input::post('FORM_SUBMIT') == $formId) {

        }

        if(!$userData){
            $this->Template->userRow = [$userData];
        }else{
            $this->Template->userRow = $userData;
        }
        $this->Template->message = 'Hello World';
        $this->Template->formId = $formId;
    }
}