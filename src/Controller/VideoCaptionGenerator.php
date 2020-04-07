<?php

namespace App\Controller;

use Contao\FrontendUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Contao\CoreBundle\Framework\ContaoFramework;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideoCaptionGenerator extends AbstractController
{

    public function __construct(ContaoFramework $contaoFramework)
    {
        $contaoFramework->initialize(true);
    }

    /**
     * @Route("video/caption", name="app_caption")
     */
    public function getCaption()
    {
        $objUser = FrontendUser::getInstance();
        $email = $objUser->email ?? 'anonymous';

        $body = $this->renderView(
            'caption/caption.html.twig',
            ['ident' => $email]
        );

        $response = new Response($body);
        $response->headers->set('Content-Type', 'text/vtt');
        return $response;
    }
}