<?php


namespace Tests\AppBundle\lib;


use AppBundle\Table\Formatter;

class FormatterSpy implements Formatter
{
    /** @var string[] */
    private $cells;

    public function addCell(string $content)
    {
        $this->cells .= "\t" . $content;
    }

    public function finishRow()
    {
        // not needed
    }

    /**
     * @return string[]
     */
    public function getCells()
    {
        return $this->cells;
    }
}