<?php declare(strict_types=1);

namespace Knops\Gunfire\Serializer;

use Knops\Gunfire\Model\ProductAttribute;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

final class ProductAttributeXmlDeserializer implements XmlDeserializable
{
    public static function xmlDeserialize(Reader $reader)
    {
        $attributes = $reader->parseAttributes();

        $children = $reader->parseInnerTree([
            '{}value' => function (Reader $reader) {
                $attrs = $reader->parseAttributes();
                $reader->next();

                return $attrs['name'];
            },
        ]);

        return new ProductAttribute($attributes['name'], $children[0]['value']);
    }
}