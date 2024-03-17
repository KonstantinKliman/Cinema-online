<?php

namespace App\Enums;

enum RoleType: int
{
    case administrator = 0;
    case uploader = 1;
    case moderator = 2;
    case subscriber = 3;
    case verified = 4;
    case user = 5;
}

