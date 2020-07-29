<?php

namespace App\Controller;

use App\Model\ReferenceModel;
use Contao\CoreBundle\Framework\ContaoFramework;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Annotation\Route;

class PdfCreatorController extends AbstractController
{

    public function __construct(ContaoFramework $contaoFramework)
    {
        $contaoFramework->initialize(true);
    }


    /**
     * @Route("/getPDF", name="app_pdf", methods={"GET"})
     */
    public function index2Action()
    {
        $userRef = ReferenceModel::findAll();
        foreach ($userRef as $ref)
        {
            // get memberData
            $userref = ReferenceModel::findRefByUser($ref->pid);
            $member  = \MemberModel::findById($ref->pid);
            $email   = $member->email;
            $q1      = html_entity_decode($userref->q1);
            $q2      = html_entity_decode($userref->q2);
            $q3      = html_entity_decode($userref->q3);
            $q4      = html_entity_decode($userref->q4);
            $q5      = html_entity_decode($userref->q5);
            $q6      = html_entity_decode($userref->q6);
            $q7      = html_entity_decode($userref->q7);
            $q8      = html_entity_decode($userref->q8);
            $q9      = html_entity_decode($userref->q9);
            // Configure Dompdf according to your needs
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);
            // Retrieve the HTML generated in our twig file
            $html = $this->renderView(
                'default/mypdf.html.twig',
                [
                    'q1'    => $q1,
                    'q2'    => $q2,
                    'q3'    => $q3,
                    'q4'    => $q4,
                    'q5'    => $q5,
                    'q6'    => $q6,
                    'q7'    => $q7,
                    'q8'    => $q8,
                    'q9'    => $q9,
                    'email' => $email,
                ]
            );

            // Load HTML to Dompdf
            $dompdf->loadHtml($html);
            // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'portrait');
            $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
            $dompdf->getCanvas()->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0, 0, 0));
            // Render the HTML as PDF
            $dompdf->render();
            // Store PDF Binary Data
            $output = $dompdf->output();

            $publicDirectory = $this->getParameter('kernel.project_dir') . '/web/pdf';
            $filesystem      = new Filesystem();
            try {
                $filesystem->mkdir($publicDirectory.'/'.$email);
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating your directory at ".$exception->getPath();
            }
            $pdfFilepath = $publicDirectory.'/'.$email.'/DV2020-T1-'.$email.'.pdf';
            // Write file to the desired path
            file_put_contents($pdfFilepath, $output);
        }

        return new Response("The PDF file has been succesfully generated !");
    }

}