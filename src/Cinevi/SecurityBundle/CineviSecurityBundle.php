<?php

namespace Cinevi\SecurityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CineviSecurityBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
