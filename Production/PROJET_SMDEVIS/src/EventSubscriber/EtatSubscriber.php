<?php

namespace App\EventSubscriber;

use App\Entity\Partners;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EtatSubscriber implements EventSubscriberInterface
{
    public function onPrePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        
        // Check if the entity is an instance of Partners
        if (!$entity instanceof Partners) {
            return;
        }
        
        // Get the current date
        $currentDate = new \DateTime();
        
        // Get the datePartSub value and subscription value
        $datePartSub = $entity->getDatePartSub();
        $subscription = $entity->getSubscription();
        
        // Add the subscription value in months to the datePartSub
        $expirationDate = clone $datePartSub;
        $expirationDate->modify('+' . $subscription . ' month');
        
        // Check if the current date is beyond the expiration date
        if ($currentDate > $expirationDate) {
            $entity->setEtat('Inactive');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist => 'onPrePersist',
        ];
    }
}
