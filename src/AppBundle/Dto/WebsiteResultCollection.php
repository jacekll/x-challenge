<?php

namespace AppBundle\Dto;

class WebsiteResultCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var WebsiteResult[]
     */
    private $elements;

    public function __construct(array $elements = [])
    {
        $this->elements = array_map(array($this, 'checkType'), $elements);
    }

    public function count()
    {
        return count($this->elements);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }

    public function add(WebsiteResult $element)
    {
        $this->elements[] = $element;
    }

    public function checkType(int $index, $item)
    {
        if (!$item instanceof WebsiteResult) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected WebsiteResult, got %s at index %d',
                    is_object($item) ? get_class($item) : gettype($item),
                    $index
                )
            );
        }
    }

}
