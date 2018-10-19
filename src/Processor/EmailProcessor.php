<?php
/**
 * Created by PhpStorm.
 * User: piotrzatorski
 * Date: 19/10/2018
 * Time: 18:17
 */

namespace App\Processor;

use Symfony\Component\DependencyInjection\ContainerInterface;

class EmailProcessor
{
    private $mailer;
    private $templating;
    private $container;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, ContainerInterface $container)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->container = $container;
    }

    public function mailAboutSlowWebsite(array $results): void
    {
        if ($results['mailAlert']) {
            $message = (new \Swift_Message('Alert'))
                    ->setFrom($this->container->getParameter('env(EMAIL_FROM)'))
                    ->setTo('pzatorski@allset.pl')
                    ->setBody(
                            $this->templating->render(
                                    'email.html.twig'
                            ),
                            'text/html'
                    );

            $this->mailer->send($message);
        }


    }

}