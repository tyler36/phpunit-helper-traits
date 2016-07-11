<?php

/**
 * Class CheckAssetExistsTraitTest
 *
 * @test
 * @group trait
 * @group checkAssetExists
 */
class CheckAssetExistsTraitTest extends TestCase
{
    use tyler36\phpunitTraits\CheckAssetExistsTrait;

    /**
     * @var string
     */
    protected $remoteFile;


    /**
     * @before
     */
    public function setRemoteTestFile()
    {
        $this->remoteFile = 'https://fonts.googleapis.com/css?family=Lato:100';
    }

    /**
     * TEST:        Trait without arguments
     */
    public function testTraitParameterElementError()
    {
        try {
            /** @noinspection PhpParamsInspection */
            $this->checkAssetExists();
        } catch (Exception $err) {
            $this->assertContains('Missing argument 1', $err->getMessage());
        }
    }


    /**
     * TEST:        Error Message
     */
    public function testAssetNotFoundMessage()
    {
        // Fake file
        $filename = 'fakeFile.php';

        // CHECK:       Message warning
        try {
            $this->checkAssetExists($filename);
        } catch (Exception $err) {
            $this->assertContains('Failed asserting that file', $err->getMessage());
            $this->assertContains($filename, $err->getMessage());
        }
    }


    /**
     * TEST:        Local resource exists
     */
    public function testLocalResourceExist()
    {
        $this->checkAssetExists('/robots.txt');
    }


    /**
     * TEST:        Remote resource exists
     */
    public function testRemoteResourceExist()
    {
        $this->checkAssetExists($this->remoteFile);
    }


    /**
     * TEST:        Array of resources
     */
    public function testArrayOfResourcesExist()
    {
        $this->checkAssetExists(['/robots.txt', $this->remoteFile]);
    }


    /**
     * TEST:        Chain command on native Laravel PHPUNIT
     */
    public function testChainAssetCheckOnLaravelPhpunitCall()
    {
        $this->visit('/')
            ->checkAssetExists($this->remoteFile);
    }
}
