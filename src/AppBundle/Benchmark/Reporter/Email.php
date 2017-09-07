<?php

namespace AppBundle\Benchmark\Reporter;


use AppBundle\Benchmark\Reporter;
use AppBundle\Dto\TestResult;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class Email implements Reporter
{
    /** @var string[] */
    private $recipientAddresses = [];

    /** @var string */
    private $fromAddress;

    /** @var \Swift_Mailer */
    private $mailer;

    /** @var EngineInterface */
    private $templating;

    /** @var string */
    private $templatePath;

    /**
     * @param string[] $recipientAddresses
     * @param string $fromAddress
     * @param \Swift_Mailer $mailer
     * @param EngineInterface $templating
     * @param string $templatePath path to twig template relative to app Resources/views directory, no leading slash
     */
    public function __construct(
        array $recipientAddresses,
        string $fromAddress,
        \Swift_Mailer $mailer,
        EngineInterface $templating,
        string $templatePath
    )
    {
        $this->recipientAddresses = $recipientAddresses;
        $this->fromAddress = $fromAddress;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->templatePath = $templatePath;
    }

    public function report(TestResult $result): void
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom($this->fromAddress)
            ->setTo($this->recipientAddresses)
            ->setBody(
                $this->templating->render(
                    $this->templatePath,
                    [
                        'benchmark' => $result,
                        'website' => $result->getMainWebsiteResult()->getUrl()->getUrl()
                    ]
                )
            );

        $this->mailer->send($message);
    }
}