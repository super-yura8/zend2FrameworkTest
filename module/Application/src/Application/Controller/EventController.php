<?php

namespace Application\Controller;

use Application\Model\Entity\Event;
use Doctrine\Common\Collections\Criteria;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\View\Model\ViewModel;

class EventController extends AbstractActionController
{

    private function getEntityManager()
    {
        return $this->getServiceLocator()->get(\Doctrine\ORM\EntityManager::class);

    }

    public function indexAction()
    {
        $em = $this->getEntityManager();
        $em = $em->getRepository(Event::class);
        $sort = new Criteria(null, ['date' => 'ASC']);
        $events = $em->matching($sort);
        return new ViewModel(['events' => $events]);
    }

    public function getAction()
    {
        $id = intval($this->params()->fromRoute('id'));
        $em = $this->getEntityManager();
        $em = $em->getRepository(Event::class);
        $hydrator = new Reflection();
        $events = $em->find($id);
        $events = $hydrator->extract($events);
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
        $response->setContent(json_encode($events));
        return $response;
    }
}