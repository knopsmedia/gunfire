<?php declare(strict_types=1);

namespace Knops\GunfireClient\Serializer;

use Knops\GunfireClient\Model\ProductImage;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

final class ProductImageXmlDeserializer implements XmlDeserializable
{
    public static function xmlDeserialize(Reader $reader)
    {
        $attributes = $reader->parseAttributes();
        $reader->next();

        return new ProductImage($attributes['url']);
    }
}