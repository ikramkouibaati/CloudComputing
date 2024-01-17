<?php

namespace App\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class StatutEnumType extends Type
{
    public const TYPE_NAME = 'statut_enum';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        $values = ['en attente de confirmation', 'en cours', 'expedie', 'livre', 'annule', 'retour'];

        return sprintf(
            "ENUM('%s') COMMENT '(DC2Type:%s)'",
            implode("','", $values),
            self::TYPE_NAME
        );
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    public function getName()
    {
        return self::TYPE_NAME;
    }
}
