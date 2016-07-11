<?php

namespace tyler36\phpunitTraits;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PrepareFileUploadTrait
 *
 * @package tyler36\phpunitTraits
 */
trait PrepareFileUploadTrait
{
    /**
     * Prepare file upload
     *
     * @param $path
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function prepareUpload($path)
    {
        // ASSERT:      File Exists
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertFileExists($path);

        // GET:         File
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        // GET:         MIME info
        $mime = finfo_file($finfo, $path);

        // RETURN:      UploadedFile
        return new UploadedFile($path, null, $mime, null, null, true);
    }
}
