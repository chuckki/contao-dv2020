<?php
// src/EventListener/CompileFormFieldsListener.php
namespace App\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Form;
use Contao\FormModel;
use Contao\FormTextField;
use Contao\Widget;
use Terminal42\ServiceAnnotationBundle\ServiceAnnotationInterface;

class CompileFormFieldsListener implements ServiceAnnotationInterface
{
    /**
     * @Hook("parseWidget")
     */
    public function onParseWidget(string $buffer, Widget $widget): string
    {
        return $buffer;
        // Do something …
        //$widget->strTemplate = 'form_textfield_mail';
        /** @var FormTextField $widget */
        dump($widget->template);
        $widget->template = '/contao/form_textfield_mail';
        //$widget->template = 'form_textfield_mail';
        dump($widget);
        $widget->addAttribute('autofocus','autofocus');
        dump($widget->inherit());
        die("walter");
        return $widget->inherit();
    }

}
