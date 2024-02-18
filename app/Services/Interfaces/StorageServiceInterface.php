<?php


namespace App\Services\Interfaces;


interface StorageServiceInterface
{
    public function move(string $from, string $to): void;
    public function delete(array|string $directory): void;
    public function deleteDirectory(string $directory): void;
}
