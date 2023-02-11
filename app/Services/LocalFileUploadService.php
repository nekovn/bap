<?php

namespace App\Services;

use App\Helpers\SystemHelper;
use Illuminate\Http\UploadedFile;

class LocalFileUploadService
{
    private $file, $fileName;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    public function save($path, $disk, $oldImage = null)
    {
        //元ファイルを削除する
        SystemHelper::deleteOldFile($path, $disk, $oldImage);
        //新規ファイルを作成る
        $this->file->storeAs($path, $this->generateFileName(), $disk);
        return $this;
    }

    protected function generateFileName(): string
    {
        return $this->fileName = $this->file->hashName(null, 5);
    }

    public function getFileName($path): string
    {
        return $this->fileName ? "$path$this->fileName" : '';
    }


}
