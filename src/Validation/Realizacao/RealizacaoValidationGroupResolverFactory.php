<?php

namespace App\Validation\Realizacao;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RealizacaoValidationGroupResolverFactory
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function create()
    {
        $realizacaoValidationGroupResolver = new RealizacaoValidationGroupResolver($this->tokenStorage);

        return $realizacaoValidationGroupResolver;
    }
}
