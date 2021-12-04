<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Doctrine\DBAL\Types\Type as DBALTypes;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Shared\Infra\Settings\SettingsInterface;

return static function (ContainerBuilder $containerBuilder): void {
    $containerBuilder->addDefinitions([
        EntityManagerInterface::class => DI\get(EntityManager::class),
        EntityManager::class => static function (ContainerInterface $c): EntityManager {
            $settings = $c->get(SettingsInterface::class);
            assert($settings instanceof SettingsInterface);

            $config = Setup::createAnnotationMetadataConfiguration(
                $settings->get('doctrine.metadata_dirs'),
                $settings->get('doctrine.dev_mode')
            );

            $config->setMetadataDriverImpl(
                new AttributeDriver($settings->get('doctrine.metadata_dirs'))
            );

            // TODO add explicit cache for metadata & query

            $entityManager = EntityManager::create(
                $settings->get('doctrine.connection'),
                $config
            );

            DBALTypes::addType('uuid_binary_ordered_time', UuidBinaryOrderedTimeType::class);
            $entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping(
                'uuid_binary_ordered_time',
                'binary'
            );

            return $entityManager;
        },
    ]);
};
