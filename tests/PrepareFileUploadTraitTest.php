<?php


/**
 * Class CheckAssetExistsTraitTest
 *
 * @test
 * @group trait
 * @group checkAssetExists
 */
class PrepareFileUploadTraitTest extends TestCase
{
    use tyler36\phpunitTraits\PrepareFileUploadTrait;

    /**
     * @var string
     */
    protected $file;


    /**
     * SETUP
     */
    public function setUp()
    {
        // CALL:    parent setup
        parent::setUp();

        // SETUP:   default file to use
        $this->file = './src/PrepareFileUploadTrait.php';
    }


    /**
     * TEST:        Trait is used when file does not exist
     */
    public function testFileDoesNotExist()
    {
        // Upload
        $uploaded = $this->prepareUpload($this->file);

        // ASSERT:      Class type
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\File\UploadedFile', $uploaded);

        // ASSERT:      Known value
        $this->assertEquals($uploaded->getType(), 'file');
    }
}
