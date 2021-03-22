<?php

namespace App\Services;

use Contao\Environment;
use Contao\Idna;
use Contao\MemberModel;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailManager
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendConfirmation(MemberModel $member, string $absolutUrl): bool
    {
		$domain = Idna::decode(Environment::get('host'));
        $reg_text = 'Vielen Dank für Ihre Registrierung auf '.$domain
                    .'. \n Bitte klicken Sie hier, um Ihre Registrierung abzuschließen und Ihr Konto zu aktivieren: '
                    .$absolutUrl
                    .' \n\nDer Bestätigungslink ist 24 Stunden gültig.\n\nWenn Sie keinen Zugang angefordert haben, ignorieren Sie bitte diese E-Mail.';
        $reg_html = '<p>Vielen Dank für Ihre Registrierung auf '.$domain
                    .'<br><br> Bitte klicken Sie hier, um Ihre Registrierung abzuschließen und Ihr Konto zu aktivieren: '
                    .'<a href="'.$absolutUrl.'">'.$absolutUrl.'</a>'
                    .'<br><br>Der Bestätigungslink ist 24 Stunden gültig.<br><br>Wenn Sie keinen Zugang angefordert haben, ignorieren Sie bitte diese E-Mail.';

        $subject = sprintf('Ihre Registrierung auf %s', Idna::decode(Environment::get('host')));

        $abs   = new Address('dv2021@diagdiff.online', 'DV2021 Seminar');
        $email = (new Email())->from($abs)->to($member->email)->replyTo($abs)->subject($subject)->text($reg_text)->html($reg_html);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            dump($e);
            die;

            return false;
        }

        return true;
    }

    public function sendPasswortReset(MemberModel $member, string $absolutUrl): bool
    {
        $abs   = new Address('dv2021@diagdiff.online', 'DV2020 Seminar');
        $email = (new Email())->from($abs)->to($member->email)->replyTo($abs)->subject(
            'Zurücksetzen Ihres Passworts'
        )->text(
            'Passwort zurücksetzen: '.$absolutUrl)->html(
            '<p>Passwort zurücksetzen:  <a href="'.$absolutUrl.'">'.$absolutUrl
            .'</a></p>'
        );

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return false;
        }

        return true;
    }

}
