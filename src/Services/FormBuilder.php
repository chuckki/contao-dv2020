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
        $q4 = $userEntry->q4 ?? '';
        $q5 = $userEntry->q5 ?? '';
        $q6 = $userEntry->q6 ?? '';
        $q7 = $userEntry->q7 ?? '';
        $q8 = $userEntry->q8 ?? '';
        $q9 = $userEntry->q9 ?? '';


        $objForm = new Form('homework_' . $userId, 'POST', function ($objHaste) {
            return Input::post('FORM_SUBMIT') === $objHaste->getFormId();
        });

        $objForm->addFormField('q1',array(
            'default'   => $q1,
            'label'     => 'Wie lautet die vollständige Literaturangabe des von Ihnen behandelten Artikels im APA-Format (6. Auflage)?',
            'inputType' => 'textarea',
            'eval' => array(
                'placeholder' => '',
                'class'       => 'form-control',
                'size'        => 4,
                'cols'        => 40,
                'rows'        => 4,
            ),
        ));

        $objForm->addFormField('q2',array(
            'default'   => $q2,
            'label'     => 'Zu welchem diagnostischen Verfahren steht der von Ihnen behandelte Artikel in starkem Bezug?',
            'inputType' => 'textarea',
            'eval' => array(
                'placeholder' => '',
                'class'       => 'form-control',
                'size'        => 4,
                'cols'        => 40,
                'rows'        => 4,
            ),
        ));

        $objForm->addFormField('q3',array(
            'default'   => $q3,
            'label'     => 'Welches Konstrukt bzw. welche Konstrukte soll bzw. sollen mit diesem diagnostischen Verfahren gemessen werden?',
            'inputType' => 'textarea',
            'eval' => array(
                'placeholder' => '',
                'onkeyup'     => 'countChar(this)',
                'class'       => 'form-control',
                'size'        => 4,
                'cols'        => 40,
                'rows'        => 4,
            ),
        ));


        $objForm->addFormField('q4',array(
            'default'   => $q4,
            'label'     => 'Was waren die zentralen Forschungsfragen in dem von Ihnen behandelten Artikel? Wie haben die Autoren diese hergeleitet?',
            'inputType' => 'textarea',
            'eval' => array(
                'placeholder' => '',
                'onkeyup'     => 'countChar(this)',
                'class'       => 'form-control',
                'size'        => 4,
                'cols'        => 40,
                'rows'        => 4,
            ),
        ));


        $objForm->addFormField('q5',array(
            'default'   => $q5,
            'label'     => 'Was waren die zentralen Ergebnisse? Wie interpretieren die Autoren diese Ergebnisse?',
            'inputType' => 'textarea',
            'eval' => array(
                'placeholder' => '',
                'onkeyup'     => 'countChar(this)',
                'class'       => 'form-control',
                'size'        => 4,
                'cols'        => 40,
                'rows'        => 4,
            ),
        ));


        $objForm->addFormField('q6',array(
            'default'   => $q6,
            'label'     => 'Was sind die drei aus Ihrer Sicht wichtigsten Kritikpunkte an dem von Ihnen behandelten Artikel? Welche Probleme ergeben sich aus diesen Kritikpunkten?',
            'inputType' => 'textarea',
            'eval' => array(
                'placeholder' => '',
                'onkeyup'     => 'countChar(this)',
                'class'       => 'form-control',
                'size'        => 4,
                'cols'        => 40,
                'rows'        => 4,
            ),
        ));


        $objForm->addFormField('q7',array(
            'default'   => $q7,
            'label'     => 'Wie ließe sich diesen Kritikpunkten im Rahmen einer empirischen Studie begegnen?',
            'inputType' => 'textarea',
            'eval' => array(
                'placeholder' => '',
                'onkeyup'     => 'countChar(this)',
                'class'       => 'form-control',
                'size'        => 4,
                'cols'        => 40,
                'rows'        => 4,
            ),
        ));


        $objForm->addFormField('q8',array(
            'default'   => $q8,
            'label'     => 'Abschließender Kommentar',
            'inputType' => 'textarea',
            'eval' => array(
                'placeholder' => '',
                'class'       => 'form-control',
                'size'        => 4,
                'cols'        => 40,
                'rows'        => 4,
            ),
        ));


        $objForm->addFormField('q9',array(
            'default'   => $q9,
            'label'     => 'Codewort für die anonymisierte Ergebnisrückmeldung',
            'inputType' => 'text',
            'eval' => array(
                'placeholder' => '',
                'class'       => 'form-control',
                'size'        => 4,
                'cols'        => 40,
                'rows'        => 1,
            ),
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
                            'maxval'    => 2021,
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
