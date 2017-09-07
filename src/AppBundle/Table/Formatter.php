<?php


namespace AppBundle\Table;

/**
 * Table formatter; builds and outputs a table out of given cells
 */
interface Formatter
{
    public function addCell(string $content);

    public function finishRow();
}