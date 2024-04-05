<?php

namespace App\Enums;

enum SortType: string
{
    case asc = 'asc';
    case desc = 'desc';
    case newestUpload = 'newest_upload';
    case oldestUpload = 'oldest_upload';
    case bestRating = 'best_rating';
    case worstRating = 'worst_rating';
    case newestReleaseYear = 'newest_release_year';
    case oldestReleaseYear = 'oldest_release_year';
}

