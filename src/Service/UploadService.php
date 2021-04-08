<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;

class UploadService
{
    private $uploadImageDirectory;
    private $uploadMusicDirectory;
    
    public function __construct(
        string $uploadImageDirectory,
        string $uploadMusicDirectory
    )
    {
        $this->uploadImageDirectory = $uploadImageDirectory;
        $this->uploadMusicDirectory = $uploadMusicDirectory;
    }

    public function uploadImage(UploadedFile $image, object $entity)
    {
        $fileName = $this->createFileName($image);

        $path = $this->uploadImageDirectory . '/' . $entity->getImageDirectory();
        $image->move($path, $fileName);

        return $fileName;
    }

    public function uploadMusic(UploadedFile $music, object $entity)
    {
        $fileName = $this->createFileName($music);

        $path = $this->uploadMusicDirectory;
        $music->move($path, $fileName);

        return $fileName;
    }

    private function createFileName(UploadedFile $file): string
    {
        $slugger = new AsciiSlugger();
        $fileName = $slugger->slug($file->getClientOriginalName())->lower();
        $fileName = explode('-', $fileName);
        $fileName = array_slice($fileName, 0, -1);
        $fileName = join('-', $fileName);
        $fileName .= '.' . uniqid() . '.' . $file->guessExtension();

        return $fileName;
    }
}