<?php

namespace Cinevi\AdminBundle\Form\Transformer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EntityToIdObjectTransformer implements DataTransformerInterface
{
    private $em;
    private $entityName;

    public function __construct(EntityManager $em, $entityName)
    {
        $this->em = $em;
        $this->entityName = $entityName;
    }

    public function transform($object)
    {
        if (null === $object) {
            return '';
        }

        return $object->getId();
    }

    public function reverseTransform($idObject)
    {
        if (!$idObject) {
            return;
        }

        $object = $this->em
            ->getRepository($this->entityName)
            ->find($idObject)
        ;

        if (null === $object) {
            throw new TransformationFailedException(sprintf(
                'O objeto de id "%s" não existe!',
                $idObject
            ));
        }

        return $object;
    }
}
