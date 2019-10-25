<?php

namespace App\Controller;

use App\Service\TheSessionInfoService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 *
 */
class AdminController extends BaseAdminController
{
    /**
     * @var TheSessionInfoService
     */
    private $theSessionInfoService;

    /**
     * AdminController constructor.
     * @param TheSessionInfoService $theSessionInfoService
     */
    public function __construct(TheSessionInfoService $theSessionInfoService)
    {
        $this->theSessionInfoService = $theSessionInfoService;
    }

    /**
     * Récupérer l'ABC sur theSession.org
     * @return Response
     */
    public function getAbcAction()
    {
        // change the properties of the given entity and save the changes
        $id = $this->request->query->get('id');
        $tune = $this->em->getRepository('App:Tune')->find($id);

        $this->theSessionInfoService->updateTuneWithTheSessionInfos($tune);

        $this->em->flush();

        // redirect to the 'list' view of the given entity
        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));
    }
}
