<?php

namespace App\Controller;

use App\Processor\EmailProcessor;
use App\Processor\FileProcessor;
use App\Processor\RequestProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(\Swift_Mailer $mailer)
    {
//        $message = (new \Swift_Message('Hello Email'))
//                ->setTo('pzatorski@allset.pl')
//                ->setBody(
//                        $this->renderView(
//                                'email.html.twig',
//                                [
//
//                                ]
//
//                        ),
//                        'text/html'
//                );
//        $mailer->send($message);

        return $this->render('home.html.twig');
    }

    /**
     * @Route("/analyze", name="analyze")
     */
    public function analyze(RequestProcessor $requestProcessor, FileProcessor $fileProcessor, EmailProcessor $emailProcessor)
    {
        $results = $requestProcessor->getServerResponseTimes();
        $fileProcessor->logResultsToFile($results);
        $emailProcessor->mailAboutSlowWebsite($results);
        return $this->render(
                'results.html.twig',
                $results
        );
    }
}
