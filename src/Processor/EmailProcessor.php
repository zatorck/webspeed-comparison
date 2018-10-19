<?php
/**
 * Created by PhpStorm.
 * User: piotrzatorski
 * Date: 19/10/2018
 * Time: 18:17
 */

namespace App\Processor;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EmailProcessor
 *
 * @package App\Processor
 */
class EmailProcessor
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $templating;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * EmailProcessor constructor.
     *
     * @param \Swift_Mailer      $mailer
     * @param \Twig_Environment  $templating
     * @param ContainerInterface $container
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, ContainerInterface $container)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->container = $container;
    }

    /**
     * @param array $results
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function mailAboutSlowWebsite(array $results): void
    {
        if ($results['mailAlert']) {
            $message = (new \Swift_Message('Alert'))
                    ->setFrom($this->container->getParameter('env(EMAIL_FROM)'))
                    ->setTo($results['mailAlert'])
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