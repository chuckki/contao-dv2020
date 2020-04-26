<?php

namespace App\Services;

use Haste\Form\Form;
use Haste\Input\Input;

class FormBuilder
{

    public function buildForm(int $userId) :Form
    {
        $objForm = new Form('addReference_' . $userId, 'POST', function ($objHaste) {
            return Input::post('FORM_SUBMIT') === $objHaste->getFormId();
        });

        // year
        $objForm->addFormField('year', array(
            'default'   => '',
            'label'     => 'Jahr',
            'inputType' => 'text',
            'eval' => array('multiple'  => true,
                            'size'      => 4,
                            'maxlength' => 4,
                            'minlength' => 4,
                            'onkeyup'   => 'myFunction()',
                            'class'     => 'form-control',
                            'mandatory' => true,
                            'rgxp'      => 'digit',
                            'maxval'    => 2020,
                            'minval'    => 1850,
            ),
        ));

        // author
        $objForm->addFormField('author', array(
            'default'   => '',
            'label'     => 'Autor',
            'inputType' => 'text',
            'eval'      => array('mandatory' => true)
        ));

        // title
        $objForm->addFormField('title', array(
            'default'   => '',
            'label'     => 'Titel',
            'inputType' => 'text',
            'eval'      => array('mandatory' => true)
        ));

        return $objForm;
    }

}