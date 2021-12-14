<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Shared\Infra\Repository\DoctrineObjectPersister;
use Shared\Infra\Repository\ObjectPersisterInterface;

use function DI\autowire;

return static function (ContainerBuilder $containerBuilder): void {
    $containerBuilder->addDefinitions([
        ObjectPersisterInterface::class => autowire(DoctrineObjectPersister::class),
    ]);
};
