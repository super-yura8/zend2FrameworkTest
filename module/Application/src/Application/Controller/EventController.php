<?php

namespace Application\Controller;

use Application\Model\Entity\Event;
use Doctrine\Common\Collections\Criteria;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorInterface;
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
}