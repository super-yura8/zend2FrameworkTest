<?php

namespace Application\Controller;

use Application\Form\ClientForm;
use Application\Model\Entity\Client;
use Application\Model\Entity\Event;
use Doctrine\Common\Collections\Criteria;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ClientController extends AbstractActionController
{
    private function getEntityManager()
    {
        return $this->getServiceLocator()->get(\Doctrine\ORM\EntityManager::class);
    }

    public function indexAction()
    {
        $form = new ClientForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $client = new Client();

            $form->setInputFilter($client->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em = $this->getEntityManager()->getRepository(Client::class);
                $data = $form->getData();
                if(!is_null($client = $em->findOneBy(['email' => $data['email']]))) {
                    if($client->getEvent()->getId() == $data['event']) {
                        return $this->redirect()->toRoute('home');
                    }
                }
                $client->setName($data['name']);
                $client->setEmail($data['email']);
                $event = $em->find(Event::class, $data['event']);

                $client->setEvent($event);
                $em->persist($client);
                $em->flush();
            }
        } else {
            $em = $this->getEntityManager()->getRepository(Client::class);
            $clients = $em->findAll();
            return new ViewModel(['clients' => $clients]);
        }
        return $this->redirect()->toRoute('home');
    }
}