<?php

namespace App\Enums;

enum RoleType: int
{
    case Administrator = 1;
    case Moderator = 2;
    case Uploader = 3;
    case Verified = 4;
    case User = 5;
}

