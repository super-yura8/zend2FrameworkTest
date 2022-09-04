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
                $em = $this->getEntityManager();
                $data = $form->getData();
                $repository = $em->getRepository(Client::class);
                if(!is_null($check = $repository->findOneBy(['email' => $data['email']]))) {
                    if($check->getEvent()->getId() == $data['event']) {
                        $this->flashMessenger()->addErrorMessage("There's already a user with this email");
                        return $this->redirect()->toRoute('home');
                    }
                }
                $client->setName($data['name']);
                $client->setEmail($data['email']);
                $event = $em->find(Event::class, $data['event']);

                $client->setEvent($event);
                $em->persist($client);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('The client has been successfully registered');
            } else {
                $this->flashMessenger()->addErrorMessage('The form is not valid');
            }
        } else {
            $em = $this->getEntityManager()->getRepository(Client::class);
            $clients = $em->findAll();
            return new ViewModel(['clients' => $clients]);
        }
        return $this->redirect()->toRoute('home');
    }
}