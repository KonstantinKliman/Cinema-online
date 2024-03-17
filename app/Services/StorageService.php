<?php


namespace App\Services;


use App\Models\Movie;
use App\Services\Interfaces\StorageServiceInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use function Laravel\Prompts\select;

class StorageService implements StorageServiceInterface
{
    private const STORAGE_PATH = 'storage/';
    private const MOVIE_PATH = 'movies/';
    private const PROFILE_PATH = 'profile/';
    private const DEFAULT_AVATAR_PATH = 'assets/img/img-profile.png';

    public function storeFilesForMovie(FormRequest $request, string $requestKey, Movie $movie): string
    {
        return self::STORAGE_PATH . $request->file($requestKey)->store(self::MOVIE_PATH . $movie->id);
    }

    public function storeFileForProfile(FormRequest $request, string $requestKey): string
    {
        return self::STORAGE_PATH . $request->file($requestKey)->store(self::PROFILE_PATH . $requestKey);
    }

    public function getStoragePath(): string
    {
        return self::STORAGE_PATH;
    }

    public function getDefaultAvatarPath(): string
    {
        return self::DEFAULT_AVATAR_PATH;
    }

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
