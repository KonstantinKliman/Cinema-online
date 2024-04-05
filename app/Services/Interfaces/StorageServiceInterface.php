<?php


namespace App\Services\Interfaces;


use App\Models\Movie;
use Illuminate\Foundation\Http\FormRequest;

interface StorageServiceInterface
{
    public function move(string $from, string $to): void;

    public function delete(array|string $directory): void;

    public function deleteDirectory(string $directory): void;

    public function storeFilesForMovie(FormRequest $request, string $requestKey, Movie $movie): string;

    public function storeFileForProfile(FormRequest $request, string $requestKey): string;

    public function getStoragePath(): string;

    public function getDefaultAvatarPath(): string;
}
