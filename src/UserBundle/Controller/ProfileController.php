<?php

namespace UserBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\Paginator;
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

        $rReserva = $em->getRepository('AlmoxarifadoBundle:CalendarEvent');
        $rProjeto = $em->getRepository('RealizacaoBundle:Projeto');
        $rCopiaFinal = $em->getRepository('RealizacaoBundle:CopiaFinal');

        $qbReserva = $rReserva->list($this->get('security.authorization_checker'), 'reserva');
        $qbProjeto = $rProjeto->list($this->get('security.authorization_checker'), 'projeto');
        $qbCopiaFinal = $rCopiaFinal->list($this->get('security.authorization_checker'), 'copiaFinal');

        $qbReserva = $rReserva->listWhereUserIs($qbReserva, $obj->getId(), 'reserva');
        $qbProjeto = $rProjeto->listWhereUserIs($qbProjeto, $obj->getId(), 'projeto');
        $qbCopiaFinal = $rCopiaFinal->listWhereUserIs($qbCopiaFinal, $obj->getId(), 'copiaFinal');

        $paginationReserva = $this->createPagination($request, $this->get('knp_paginator'), $qbReserva, 'Reserva');
        $paginationProjeto = $this->createPagination($request, $this->get('knp_paginator'), $qbProjeto, 'Projeto');
        $paginationCopiaFinal = $this->createPagination($request, $this->get('knp_paginator'), $qbCopiaFinal, 'CopiaFinal');

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $obj,
            'paginationReserva' => $paginationReserva,
            'paginationProjeto' => $paginationProjeto,
            'paginationCopiaFinal' => $paginationCopiaFinal
        ));
    }

    protected function createPagination(Request $request, Paginator $paginator, $qb, $var = null)
    {
        if($request->query->get('numResultados'.$var)) {
            $numResults = $request->query->get('numResultados'.$var);
        } else {
            $numResults = 10;
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $numResults,
            array(
                'pageParameterName' => 'pagina'.$var,
                'sortFieldParameterName' => 'classificacao'.$var,
                'sortDirectionParameterName' => 'direcao'.$var
            )
        );

        return $pagination;
    }
}
