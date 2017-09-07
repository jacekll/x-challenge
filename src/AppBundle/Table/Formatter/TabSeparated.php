<?php

namespace AppBundle\Table\Formatter;

use AppBundle\Table\Formatter;
use Psr\Log\LoggerInterface;

/**
 * Simple table formatter implementation; builds a "table" simply by separating cells with tab characters
 */
class TabSeparated implements Formatter
{
    /** @var LoggerInterface */
    private $logger;

    private $currentLine = '';

    private $firstCellInCurrentLine = true;

    /**
     * Tabs constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function addCell(string $content)
    {
        if (!$this->firstCellInCurrentLine) {
            $this->printInCurrentLine("\t");
        }
        $this->printInCurrentLine($content);
        $this->firstCellInCurrentLine = false;
    }

    public function finishRow()
    {
        $this->logger->info($this->currentLine);
        $this->currentLine = '';
        $this->firstCellInCurrentLine = true;
    }

    private function printInCurrentLine(string $string)
    {
        $this->currentLine .= $string;
    }

}