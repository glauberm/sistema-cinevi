<?php

namespace Cinevi\RealizacaoBundle\Validation;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProjetoValidationGroupResolverFactory
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function create()
    {
        $projetoValidationGroupResolver = new ProjetoValidationGroupResolver($this->tokenStorage);

        return $projetoValidationGroupResolver;
    }
}
