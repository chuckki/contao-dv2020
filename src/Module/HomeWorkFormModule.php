<?php

namespace App\Module;

use App\Model\ReferenceModel;
use App\Services\FormBuilder;
use Contao\FrontendUser;
use Contao\Module;
use Contao\System;
use Patchwork\Utf8;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

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

        $this->Template->questionArray = array(
            'q1' => array(
                'list' => 1,
                'help'  => '<p>Bitte beachten Sie, dass es aus technischen Gründen nicht möglich ist, Schrift im Antwortfeld kursiv zu setzen. Ignorieren Sie deshalb den eigentlich notwendigen Kursivsatz des Journal-Titels und geben Sie diesen in normalem Schriftsatz ein.</p><div class="example"><i>Beispiel:</i><div>Schmidt, B., Müller, A., & Schneider, C. (2019). Validierung des Super-Intelligenz-Tests 3000 R (S-I-T 3000 R) in einer Stichprobe hochbegabter Schüler. Assessment and Personality Psychology, 19, 201-213. doi: 10.3942/s4256-040-06693-2</div></div>',
                'count' => null,
            ),
            'q2' => array(
                'list' => 2,
                'help'  => '<p>Nennen Sie den Lang- und den Kurznamen des Verfahrens und zitieren Sie die Version, welche im von Ihnen behandelten Artikel verwendet wurde, im APA-Format.</p><div class="example"><i>Beispiel:</i><div>Super-Intelligenz-Test 3000 R (S-I-T 3000 R; Müller, Schmidt & Schneider, 2019)</div></div><p>Falls mehrere diagnostische Verfahren eingesetzt wurden, beispielsweise in einem Methodenvergleich, nennen Sie diese nacheinander.</p><div class="example"><i>Beispiel:</i><div>Super-Intelligenz-Test 3000 (S-I-T 3000; Schmidt, Müller & Schneider, 2015),<br>Super-Intelligenz-Test 3000 R (S-I-T 3000 R; Müller, Schmidt & Schneider, 2019)</div></div><p>Falls bisher kein Lang- oder Kurzname verfügbar ist, weil beispielsweise in dem von Ihnen behandelten Artikel ein Verfahren neu vorgestellt oder erstmalig eingesetzt wurde, fügen Sie eine entsprechende Beschreibung ein (vgl. Beispiel 2).</p><div class="example"><i>Beispiel:</i><div>Neuvorstellung einer Batterie kognitiver Leistungstests (Müller, Schmidt & Schneider, 2019)</div></div>',
                'count' => null,
            ),
            'q3' => array(
                'list' => 3,
                'help'  => '<p>Sofern das diagnostische Verfahren auf einem etablierten psychologischen Modell (beispielsweise der Persönlichkeit oder der Intelligenz) aufbaut, nennen Sie dieses zu Beginn. Beschreiben Sie dann stichpunktartig, welche Haupt- und gegebenenfalls Unterdimensionen das diagnostische Verfahren messen soll. Falls mehrere diagnostische Verfahren eingesetzt wurden, beispielsweise in einem Methodenvergleich, beschreiben Sie die Haupt- und gegebenenfalls Unterdimensionen jedes Verfahrens.</p>',
                'count' => array(
                    'min' => 20,
                    'max' => 200,
                ),
            ),
            'q4' => array(
                'list' => 4,
                'help'  => '<p>Konzentrieren Sie sich in Ihrer Antwort auf die wichtigsten Forschungsfragen und ignorieren Sie weniger wichtige Nebenfragestellungen.</p>',
                'count' => array(
                    'min' => 150,
                    'max' => 300,
                ),
            ),
            'q5' => array(
                'list' => 5,
                'help'  => '<p>Konzentrieren Sie sich in Ihrer Antwort auf die wichtigsten Ergebnisse mit Bezug zu den zentralen Forschungsfragen beitragen, und ignorieren Sie weniger wichtige Nebenergebnisse. Beschreiben Sie die Ergebnisse inhaltlich und verzichten Sie soweit wie möglich auf deskriptive oder inferenzstatistische Kennwerte. Halten Sie sich an die Interpretation, welche die Autoren selbst im Artikel liefern.</p>',
                'count' => array(
                    'min' => 200,
                    'max' => 500,
                ),
            ),
            'q6' => array(
                'list' => 6,
                'help'  => '<p>Beschreiben Sie, was sich beispielsweise in inhaltlicher oder methodischer Hinsicht an dem Artikel bzw. der durchgeführten Untersuchung kritisieren lässt und welche möglicherweise problematischen Konsequenzen sich hieraus ergeben. Beschränken Sie sich auf die drei wichtigsten Kritikpunkte. Sie dürfen in Ihre Antwort sowohl Kritikpunkte aufnehmen, welche die Autoren im Artikel äußern, als auch Kritikpunkte, die Ihnen selbst aufgefallen sind.</p>',
                'count' => array(
                    'min' => 200,
                    'max' => 500,
                ),
            ),
            'q7' => array(
                'list' => 7,
                'help'  => '<p>Entwickeln Sie ein angepasstes oder neues Versuchsdesign für eine empirische Anschlussstudie, anhand derer die zuvor genannten, wichtigsten Kritikpunkte entweder systematisch untersucht oder ausgeschlossen werden könnten. Beschreiben Sie die im Design zu berücksichtigenden Variablen und stellen Sie inhaltliche Hypothesen auf, welche sich empirisch prüfen lassen.</p>',
                'count' => array(
                    'min' => 200,
                    'max' => 500,
                ),
            ),
            'q8' => array(
                'list' => null,
                'help'  => '<p>Falls Sie weitere Anmerkungen zu dem von Ihnen behandelten Artikel haben, welche sich nicht den bisherigen Fragen zuordnen lassen, fügen Sie diese hier ein.</p>',
            ),
            'q9' => array(
                'list' => null,
                'help'  => '<p>Um Ihnen die Note für Ihre Hausarbeit nach der Bewertung anonym per E-Mail zurückmelden zu können, geben Sie hier bitte ein möglichst eindeutiges Codewort an, das Sie wiedererkennen werden, das jedoch niemandem Rückschlüsse auf Ihre Person ermöglicht. Mögliche Codewörter sind z.B. „Superkreativ“ oder „Intelligenzstruktour“ (bitte denken Sie sich aber ein eigenes Codewort aus).</p>',
            ),
        );

        $userRef = ReferenceModel::findRefByUser($objUser->id);
        $this->Template->showForm = false;
        if(!empty($userRef)){
            $this->Template->showForm = true;
        }

        if ($form->validate()) {
            $arrData            = $form->fetchAll();

            $userEntry = ReferenceModel::findRefByUser($objUser->id);
            if(empty($userEntry)){
                throw new NotFoundResourceException();
            }
            $userEntry->pid = $objUser->id;
            $userEntry->q1  = $arrData['q1'];
            $userEntry->q2  = $arrData['q2'];
            $userEntry->q3  = $arrData['q3'];
            $userEntry->q4  = $arrData['q4'];
            $userEntry->q5  = $arrData['q5'];
            $userEntry->q6  = $arrData['q6'];
            $userEntry->q7  = $arrData['q7'];
            $userEntry->q8  = $arrData['q8'];
            $userEntry->q9  = $arrData['q9'];
            $userEntry->save();
        }

        $this->Template->homeWorkForm     = $form;
        $this->Template->requstToken = $csrfManager->getToken($form->getFormId());

    }
}