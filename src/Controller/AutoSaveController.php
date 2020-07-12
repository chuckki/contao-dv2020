<?php

namespace App\Controller;

use App\Model\ReferenceModel;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\FrontendUser;
use Http\Discovery\Exception\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AutoSaveController extends AbstractController
{

    public function __construct(ContaoFramework $contaoFramework)
    {
        $contaoFramework->initialize(true);
    }

    /**
     * @Route("/autosave/{onoff}", name="app_autosave_switcher", methods={"POST"})
     */
    public function switchAutoSaveForMember(string $onoff): Response
    {
        $objUser = FrontendUser::getInstance();
        if ($objUser->id) {
            $userRef = ReferenceModel::findRefByUser($objUser->id);
            if ($onoff === 'on') {
                $userRef->autosave = true;
            } else {
                $userRef->autosave = false;
            }
            $userRef->save();
        } else {
            throw new NotFoundException('User not found.');
        }
        if ($userRef->autosave) {
            return new Response('Automatisches Speichern aktiviert');
        }

        return new Response('Automatisches Speichern deaktiviert');
    }

    /**
     * @Route("/autosavestatus", name="app_autosave_status", methods={"GET"})
     */
    public function getStatusAutoSaveForMember(): JsonResponse
    {
        $objUser = FrontendUser::getInstance();
        $userRef = ReferenceModel::findRefByUser($objUser->id);

        return new JsonResponse($userRef->autosave);
    }
}