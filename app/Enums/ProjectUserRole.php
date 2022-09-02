<?php

declare(strict_types=1);

namespace App\Enums;

enum ProjectUserRole: string
{
    case Director = 'director';
    case Producer = 'producer';
    case PhotographyDirector = 'photography-director';
    case SoundDirector = 'sound-director';
    case ArtDirector = 'art-director';
}
