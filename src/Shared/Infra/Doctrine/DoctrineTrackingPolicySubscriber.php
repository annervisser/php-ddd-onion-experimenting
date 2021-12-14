<?php

declare(strict_types=1);

namespace Shared\Infra\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events as ORMEvents;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class DoctrineTrackingPolicySubscriber implements EventSubscriber
{
    /**
     * @return list<string>
     * @psalm-return list<ORMEvents::*>
     * @phpstan-return array<ORMEvents::*>
     */
    public function getSubscribedEvents(): array
    {
        return [
            ORMEvents::loadClassMetadata,
        ];
    }

    /** @noinspection PhpUnused */
    public function loadClassMetadata(LoadClassMetadataEventArgs $args): void
    {
        $classMetadata = $args->getClassMetadata();
        $classMetadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_EXPLICIT);
    }
}
