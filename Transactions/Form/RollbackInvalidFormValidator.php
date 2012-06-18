<?php
/**
 * SimpleThings TransactionalBundle
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace SimpleThings\TransactionalBundle\Transactions\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

/**
 * "Missusing" the FormValidator to set transactions to rollback only when the validation failed.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 */
class RollbackInvalidFormValidator implements EventSubscriberInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     */
    static public function getSubscribedEvents()
    {
        return array(FormEvents::POST_BIND => array('validate', -32));
    }

    public function validate(FormEvent $event)
    {
        if (!$this->container->has('request')) {
            return;
        }

        $form = $event->getForm();
        $request = $this->container->get('request');
        if ( ! $form->isValid() && $request->attributes->has('_transaction') ) {
            $request->attributes->get('_transaction')->setRollBackOnly(true);
        }
    }
}

