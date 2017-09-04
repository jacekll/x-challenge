<?php


namespace AppBundle\Table;


interface Formatter
{
    public function addCell(string $content);

    public function finishRow();
}