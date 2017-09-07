<?php

namespace AppBundle\Benchmark\Reporter;

use AppBundle\Benchmark\Reporter;
use AppBundle\Dto\TestResult;
use SMSApi\Api\SmsFactory;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class Sms implements Reporter
{
    /** @var SmsFactory */
    private $smsActionFactory;

    /** @var EngineInterface */
    private $templating;

    /** @var string */
    private $templatePath;

    /** @var string */
    private $fromName;

    /** @var string */
    private $toNumber;

    public function __construct(
        SmsFactory $smsActionFactory,
        EngineInterface $templating,
        string $templatePath,
        string $fromName,
        string $toNumber
    )
    {
        $this->smsActionFactory = $smsActionFactory;
        $this->templating = $templating;
        $this->templatePath = $templatePath;
        $this->fromName = $fromName;
        $this->toNumber = $toNumber;
    }

    public function report(TestResult $result)
    {
        $actionSend = $this->smsActionFactory->actionSend();
        $actionSend->setTo($this->toNumber);
        $actionSend->setText($this->templating->render(
            $this->templatePath,
            [
                'benchmark' => $result,
                'website' => $result->getMainWebsiteResult()->getUrl()->getUrl()
            ]
        ));
        $actionSend->setSender($this->fromName);

        // TODO: check status in the result
        $response = $actionSend->execute();
    }

}