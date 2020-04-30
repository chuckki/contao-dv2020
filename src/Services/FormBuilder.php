<?php

namespace App\Services;

use App\Model\ReferenceModel;
use Haste\Form\Form;
use Haste\Input\Input;

class FormBuilder
{


    public function buildWorkForm(int $userId):Form
    {
        $userEntry = ReferenceModel::findRefByUser($userId);

        $q1 = $userEntry->q1 ?? '';
        $q2 = $userEntry->q2 ?? '';
        $q3 = $userEntry->q3 ?? '';


        $objForm = new Form('homework_' . $userId, 'POST', function ($objHaste) {
            return Input::post('FORM_SUBMIT') === $objHaste->getFormId();
        });

        $objForm->addFormField('q1',array(
            'default'   => $q1,
            'label'     => 'Wie lautet die vollständige Zitation des Artikels nach dem American Psychological Association (APA)-Format?',
            'inputType' => 'textarea',
            'eval' => array(
                'placeholder' => 'max. 120 Zeichen',
                'class'       => 'form-control',
                'size'        => 4,
                'cols'        => 40,
                'rows'        => 4,
            ),
        ));

        $objForm->addFormField('q2',array(
            'default'   => $q2,
            'label'     => 'Welche Ergebnisse wurde gefunden?',
            'inputType' => 'textarea',
            'eval' => array(
                'placeholder' => 'max. 120 Zeichen',
                'class'       => 'form-control',
                'size'        => 4,
                'cols'        => 40,
                'rows'        => 4,
            ),
        ));

        $objForm->addFormField('q3',array(
            'default'   => $q3,
            'label'     => 'Welche Kritik könnte man über das Design der Studie anbringen?',
            'inputType' => 'textarea',
            'eval' => array(
                'placeholder' => 'max. 120 Zeichen',
                'class'       => 'form-control',
                'size'        => 4,
                'cols'        => 40,
                'rows'        => 4,
            ),
        ));

        $objForm->addFormField('submission',array(
            'default'   => '',
            'inputType' => 'checkbox',
            'label'         => array('', 'Abgabe endgültig einreichen. Halten Sie dazu Ihre Matrikelnummer bereit.'),

        ));

        return $objForm;
    }

    public function buildRefForm(int $userId) :Form
    {
        $objForm = new Form('addReference_' . $userId, 'POST', function ($objHaste) {
            return Input::post('FORM_SUBMIT') === $objHaste->getFormId();
        });

        // year
        $objForm->addFormField('year', array(
            'default'   => '',
            'label'     => 'Jahr',
            'inputType' => 'text',
            'eval' => array(
                            'placeholder' => 'Jahr',
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
            'eval' => array(
                'mandatory'   => true,
                'placeholder' => 'Autor',
                'onkeyup'     => 'myFunction()',
                'class'       => 'form-control'
            ),
        ));

        // title
        $objForm->addFormField('title', array(
            'default'   => '',
            'label'     => 'Titel',
            'inputType' => 'text',
            'eval' => array(
                'mandatory'   => true,
                'placeholder' => 'Titel',
                'onkeyup'     => 'myFunction()',
                'class'       => 'form-control',
            )
        ));

        return $objForm;
    }

}