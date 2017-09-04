<?php

namespace AppBundle\Dto;

class WebsiteResultCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var WebsiteResult[]
     */
    private $elements;

    /**
     * @param WebsiteResult[] $elements
     */
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
        return new \ArrayIterator($this->elements);
    }

    public function add(WebsiteResult $element)
    {
        $this->elements[] = $element;
    }

    public function checkType($item)
    {
        if (!$item instanceof WebsiteResult) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected WebsiteResult, got %s',
                    is_object($item) ? get_class($item) : gettype($item)
                )
            );
        }

        return $item;
    }

    public function getByUrl(Url $url)
    {
        $itemsByUrl = array_filter($this->elements, function(WebsiteResult $item) use ($url) {
            return $item->getUrl()->getUrl() === $url->getUrl();
        });

        return array_shift($itemsByUrl);
    }

}
