<?php


namespace App\Services;


use App\Services\Interfaces\StorageServiceInterface;
use Illuminate\Support\Facades\Storage;

class StorageService implements StorageServiceInterface
{
    public function move(string $from, string $to): void
    {
        Storage::move($from, $to);
    }

    public function delete(array|string $directory): void
    {
        Storage::delete($directory);
    }

    public function deleteDirectory(string $directory): void
    {
        Storage::deleteDirectory($directory);
    }
}
