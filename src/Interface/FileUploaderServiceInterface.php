<?php

namespace App\Interface;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderServiceInterface
{
    public function upload(UploadedFile $file): string;
}
