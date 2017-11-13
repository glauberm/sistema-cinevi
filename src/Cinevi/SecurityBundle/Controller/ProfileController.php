<?php

namespace Cinevi\SecurityBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Model\UserInterface;

class ProfileController extends BaseController
{
    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request  = $this->getRequest();

        $obj = $this->getUser();
        if (!is_object($obj) || !$obj instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $rReserva = $em->getRepository('CineviAlmoxarifadoBundle:CalendarEvent');
        $rProjeto = $em->getRepository('CineviRealizacaoBundle:Projeto');
        $rCopiaFinal = $em->getRepository('CineviRealizacaoBundle:CopiaFinal');

        $qbReserva = $rReserva->list('reserva');
        $qbReserva = $this->list($request, $em, $qbReserva, 'reserva');
        $qbProjeto = $rProjeto->list('projeto');
        $qbProjeto = $this->list($request, $em, $qbProjeto, 'projeto');
        $qbCopiaFinal = $rCopiaFinal->list('copiaFinal');
        $qbCopiaFinal = $this->list($request, $em, $qbCopiaFinal, 'copiaFinal');

        $qbReserva = $rReserva->listWhereUserIs($qbReserva, $obj->getId(), 'reserva');
        $qbProjeto = $rProjeto->listWhereUserIs($qbProjeto, $obj->getId(), 'projeto');
        $qbCopiaFinal = $rCopiaFinal->listWhereUserIs($qbCopiaFinal, $obj->getId(), 'copiaFinal');

        $paginationReserva = $this->getPagination($request, $qbReserva, 'Reserva');
        $paginationProjeto = $this->getPagination($request, $qbProjeto, 'Projeto');
        $paginationCopiaFinal = $this->getPagination($request, $qbCopiaFinal, 'CopiaFinal');

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $obj,
            'paginationReserva' => $paginationReserva,
            'paginationProjeto' => $paginationProjeto,
            'paginationCopiaFinal' => $paginationCopiaFinal
        ));
    }

    private function list(Request $request, EntityManager $em, $qb, $builderName = 'item')
    {
        $checker = $this->get('security.authorization_checker');

        foreach ($qb->getQuery()->getResult() as $result) {
            if ($checker->isGranted('view', $result) === false) {
                $qb->andWhere($builderName.'.id != '.$result->getId());
            }
        }

        return $qb;
    }

    private function getPagination(Request $request, $qb, $getVar = null)
    {
        $paginator = $this->get('knp_paginator');

        $numResults = $request->query->get('numResultados'.$getVar) ? $request->query->get('numResultados'.$getVar) : 10;

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $numResults,
            array(
                'wrap-queries' => true,
                'pageParameterName' => 'page'.$getVar,
                'sortFieldParameterName' => 'sort'.$getVar,
                'sortDirectionParameterName' => 'direction'.$getVar,
            )
        );

        return $pagination;
    }
}
