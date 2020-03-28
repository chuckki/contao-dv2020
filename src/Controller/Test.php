<?php

namespace App\Controller;

use Contao\CoreBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Test extends AbstractController
{

    /**
     * @Route("manu.html")
     */
    public function testAction()
    {
        return new Response("mann");
    }
}