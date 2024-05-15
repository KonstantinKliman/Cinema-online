<?php

namespace App\Enums;

enum ReviewType: int
{
    case positive = 1;
    case neutral = 2;
    case negative = 3;
}
