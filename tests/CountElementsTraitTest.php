<?php


/**
 * Class CountElementsTraitTest
 *
 * @test
 * @group trait
 * @group countElements
 */
class CountElementsTraitTest extends TestCase
{
    use tyler36\phpunitTraits\CountElementsTrait;


    /**
     * TEST:        Trait without arguments
     */
    public function testTraitParameterElementError()
    {
        try {
            /** @noinspection PhpParamsInspection */
            $this->countElements();
        } catch (Exception $err) {
            $this->assertContains('Missing argument 1', $err->getMessage());
        }
    }


    /**
     * TEST:        Trait without 2nd argument
     */
    public function testTraitMissingCountError()
    {
        try {
            /** @noinspection PhpParamsInspection */
            $this->countElements('div');
        } catch (Exception $err) {
            $this->assertContains('Missing argument 2', $err->getMessage());
        }
    }


    /**
     * TEST:        Trait when there is no CRAWLER
     */
    public function testTraitWithoutCrawlerError()
    {
        try {
            $this->countElements('div', 2);
        } catch (Exception $err) {
            $this->assertContains('No page has been accessed', $err->getMessage());
        }
    }


    public function testElementNotFoundError()
    {
        // VISIT:       Page
        $this->visit('/');

        $this->countElements('html', 1);
    }
}
