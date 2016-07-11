<?php

namespace tyler36\phpunitTraits;

use GuzzleHttp\Client;

/**
 * Class CheckAssetExistsTrait
 *
 * @requires guzzlehttp/guzzle
 * @package phpunit
 */
trait CheckAssetExistsTrait
{
    /**
     * Check item/s exist within PUBLIC directory or available on web
     *
     * @param string|array $items
     * @return $this
     */
    public function checkAssetExists($items)
    {
        // NORMALIZE:       To array
        if (gettype($items) !== 'array') {
            $items = [$items];
        }

        // LOOP:            Assets
        foreach ($items as $item) {
            // ASSERT:      Asset is accessible; External request or local file
            /** @noinspection PhpUndefinedMethodInspection */
            (substr($item, 0, 4) === 'http')
                ? $this->checkRequest($item)
                : $this->assertFileExists(app()->publicPath() . $item);

            // ASSERT:      Script location exists on page
            /** @noinspection PhpUndefinedFieldInspection */
            if ($this->crawler) {
                /** @noinspection PhpUndefinedMethodInspection */
                $this->see($item);
            }
        }

        return $this;
    }


    /**
     * Make a guzzle request and check status code
     *
     * @param $item
     */
    protected function checkRequest($item)
    {
        // CHECK:       Request to external asset is valid
        $client          = new Client();
        $externalRequest = $client->request('GET', $item);

        // CHECK:       Status code is OK
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->assertEquals(200, $externalRequest->getStatusCode());
    }
}
