<?php

namespace App\Controller;

use App\Processor\EmailProcessor;
use App\Processor\FileProcessor;
use App\Processor\RequestProcessor;
use App\Processor\SMSProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AppController
 *
 * @package App\Controller
 */
class AppController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/analyze", name="analyze")
     */
    public function analyze(
            RequestProcessor $requestProcessor,
            FileProcessor $fileProcessor,
            EmailProcessor $emailProcessor,
            SMSProcessor $SMSProcessor
    ) {
        $results = $requestProcessor->getServerResponseTimes();
        $fileProcessor->logResultsToFile($results);
        $emailProcessor->mailAboutSlowWebsite($results);
        $SMSProcessor->SMSAboutSlowWebsite($results);

        return $this->render(
                'results.html.twig',
                $results
        );
    }
}
