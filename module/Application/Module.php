<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
//        return [
//          'factories' => [
//              'Application\Model\Db' => function ($serviceManager) {
//                    $entityManager =
//              }
//          ]
//        ];
        return [
            'factories' =>
                [
                    'doctrine.connection.orm_crawler' => new \DoctrineORMModule\Service\DBALConnectionFactory('orm_crawler'),
                    'doctrine.configuration.orm_crawler' => new \DoctrineORMModule\Service\ConfigurationFactory('orm_crawler'),
                    'doctrine.entitymanager.orm_crawler' => new \DoctrineORMModule\Service\EntityManagerFactory('orm_crawler'),

                    'doctrine.driver.orm_crawler' => new \DoctrineModule\Service\DriverFactory('orm_crawler'),
                    'doctrine.eventmanager.orm_crawler' => new \DoctrineModule\Service\EventManagerFactory('orm_crawler'),
                    'doctrine.entity_resolver.orm_crawler' => new \DoctrineORMModule\Service\EntityResolverFactory('orm_crawler'),
                    'doctrine.sql_logger_collector.orm_crawler' => new \DoctrineORMModule\Service\SQLLoggerCollectorFactory('orm_crawler'),
                    'DoctrineORMModule\Form\Annotation\AnnotationBuilder' => function (\Zend\ServiceManager\ServiceLocatorInterface $sl) {
                        return new \DoctrineORMModule\Form\Annotation\AnnotationBuilder($sl->get('doctrine.entitymanager.orm_crawler'));
                    },
                    ]
        ];
    }
}
