<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Services\MailManager;
use Contao\Config;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\OptIn\OptIn;
use Contao\Email;
use Contao\Environment;
use Contao\FrontendUser;
use Contao\Idna;
use Contao\MemberModel;
use Contao\System;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class RegistrationController extends AbstractController
{
    private $mailManager;

    public function __construct(MailManager $mailManager, ContaoFramework $contaoFramework)
    {
        $this->mailManager = $mailManager;
        $contaoFramework->initialize(true);
    }

    /**
     * @Route("/registierung.html", name="app_register_index")
     * @throws \Exception
     */
    public function registerAction(Request $request, EncoderFactoryInterface $encoderFactory): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        // check for existing email
        if (!empty($form->get('email')->getData())) {
            $mail   = $form->get('email')->getData();
            $member = MemberModel::findOneBy('email', $mail);
            if ($member) {
                $form->get('email')->addError(
                    new FormError(
                        'Für diese E-Mail-Adresse existiert schon ein Account. Benutzen Sie in diesem Fall die "Passwort vergessen"-Funktion'
                    )
                );
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $mail              = $form->get('email')->getData();
            $pw                = $form->get('password')->getData();
            $member            = new MemberModel();
            $member->email     = $mail;
            $member->login     = true;
            $member->tstamp    = time();
            $member->disable   = true;
            $member->dateAdded = time();
            $member->username  = $this->generateUsername($mail);
            $encoder           = $encoderFactory->getEncoder(FrontendUser::class);
            $member->password  = $encoder->encodePassword($pw, null);
            $member->save();
            $optIn      = System::getContainer()->get('contao.opt-in');
            $optInToken = $optIn->create('reg', $member->email, array('tl_member' => array($member->id)));
            $link = $this->generateUrl('app_register_checkToken', ['token' => $optInToken->getIdentifier()], UrlGeneratorInterface::ABSOLUTE_URL);

            $isSendSuccess = $this->mailManager->sendConfirmation($member, $link);
            if ($isSendSuccess) {
                $this->addFlash(
                    'notice',
                    'Wir haben Ihnen zur Bestätigung eine E-Mail an '.$form->get('email')->getData()
                    .' gesendet. Dort finden Sie den Link zur Bestätigung Ihrer Anmeldung.'
                );
            } else {
                $this->addFlash(
                    'warning',
                    'Es ist ein Fehler während des Versands der Bestätigungs-E-Mail aufgetretten. Bitte wenden Sie sich per E-Mail an dennis.esken@hhu.de'
                );
            }

            return $this->redirectToRoute('app_register_index');
        }

        return $this->render(
            'registration/register.html.twig',
            [
                'registrationForm' => $form->createView(),
            ]
        );
    }

    private function generateUsername($mail): string
    {
        $first   = explode('@', $mail);
        $preMail = explode('.', $first[0]);
        $cname   = '';
        foreach ($preMail as $mailPart) {
            $cname .= mb_strtoupper(substr($mailPart, 0, 1)).'.';
        }

        return $cname;
    }

    /**
     * @Route("/register/{token}", name="app_register_checkToken")
     */
    public function checkTokenAction(string $token): RedirectResponse
    {
        $msg     = 'Ihre E-Mail-Adresse wurde bestätigt. Sie können Sich nun einloggen.';
        $msgType = 'notify';
        /** @var OptIn $optIn */
        $optIn = System::getContainer()->get('contao.opt-in');
        // Find an unconfirmed token with only one related record
        if ((!$optInToken = $optIn->find($token)) || !$optInToken->isValid()
            || count(
                   $arrRelated = $optInToken->getRelatedRecords()
               ) !== 1
            || key($arrRelated) !== 'tl_member'
            || count($arrIds = current($arrRelated)) !== 1
            || (!$objMember = MemberModel::findByPk($arrIds[0]))) {
            $msgType = 'error';
            $msg     = $GLOBALS['TL_LANG']['MSC']['invalidToken'];
            $this->addFlash($msgType, $msg);

            return $this->redirectToRoute('app_register_index');
        }
        if ($optInToken->isConfirmed()) {
            $msgType = 'error';
            $msg     = $GLOBALS['TL_LANG']['MSC']['tokenConfirmed'];
            $this->addFlash($msgType, $msg);

            return $this->redirectToRoute('app_register_index');
        }
        if ($optInToken->getEmail() !== $objMember->email) {
            $msgType = 'error';
            $msg     = $GLOBALS['TL_LANG']['MSC']['tokenEmailMismatch'];
            $this->addFlash($msgType, $msg);

            return $this->redirectToRoute('app_register_index');
        }
        $objMember->disable = '';
        $objMember->save();

        $objEmail = new Email();
        $objEmail->from = Config::get('adminEmail');
        $objEmail->fromName = Config::get('adminEmail');
        $objEmail->subject = "Neue Registrierung auf: " . Idna::decode(Environment::get('host'));
        $objEmail->text = "Neu Registrierung auf " . Idna::decode(Environment::get('host')) . "\n\nvon: " . $objMember->email;
        $objEmail->sendTo(Config::get('adminEmail'));

        $this->addFlash($msgType, $msg);

        return $this->redirect('/');
    }


}
