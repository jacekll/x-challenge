<?php
namespace AppBundle\Dto;

class UrlCollection implements \IteratorAggregate, \Countable
{
    /** @var Url[] */
    private $elements;

    public function __construct(array $elements)
    {
        $this->elements = array_map(array($this, 'toUrl'), $elements);

    }

    public function count()
    {
        return count($this->elements);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }

    public function toUrl($item)
    {
        if (!is_string($item) && !$item instanceof Url) {
            throw new \InvalidArgumentException("Expected a Url instance or a string");
        }

        return $item instanceof Url ? $item : new Url($item);
    }
}
