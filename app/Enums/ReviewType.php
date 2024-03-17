<?php

namespace App\Enums;

enum ReviewType: int
{
    case positive = 0;
    case neutral = 1;
    case negative = 2;
}
