<?php

namespace tyler36\phpunitTraits;

use Exception;

/**
 * Class CountElementsTrait
 *
 * @package phpunit
 */
trait CountElementsTrait
{
    /**
     * Verify the number of dom elements
     * http://blog.g-design.net/post/124707474740/counting-dom-elements-when-you-test-your-laravel
     *
     * @param  string $selector the dom selector (jquery style)
     * @param  int    $number   how many elements should be present in the dom
     * @return $this
     * @throws Exception
     */
    public function countElements($selector, $number)
    {
        if (is_null($this->crawler)) {
            throw new Exception('No page has been accessed. Please access a page through CALL or VISIT first.');
        }

        // Search for elements and assert count
        $this->assertCount($number, $this->crawler->filter($selector));

        return $this;
    }
}
