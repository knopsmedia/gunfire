<?php declare(strict_types=1);

namespace Knops\GunfireClient\Serializer;

use Knops\GunfireClient\Model\Manufacturer;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

final class ManufacturerXmlDeserializer implements XmlDeserializable
{
    public static function xmlDeserialize(Reader $reader)
    {
        $attributes = $reader->parseAttributes();
        $reader->next();

        return new Manufacturer((int)$attributes['id'], $attributes['name']);
    }
}