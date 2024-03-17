<?php

namespace App\Enums;

enum FilterType: string {
    case minYear = 'min_year';
    case maxYear = 'max_year';
    case genres = 'genres';
    case minRating = 'min_rating';
    case maxRating = 'max_rating';
    case country = 'country';
    case productionStudio = 'production_studio';
}
