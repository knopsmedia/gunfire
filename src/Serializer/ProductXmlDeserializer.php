<?php declare(strict_types=1);

namespace Knops\Gunfire\Serializer;

use Knops\Gunfire\Model\Product;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;
use function Sabre\Xml\Deserializer\keyValue;
use function Sabre\Xml\Deserializer\repeatingElements;

final class ProductXmlDeserializer implements XmlDeserializable
{
    public static function xmlDeserialize(Reader $reader)
    {
        $product = new Product();
        $attributes = $reader->parseAttributes();
        $product->setExternalId((int)$attributes['id']);
        $product->setExternalSku($attributes['code_producer']);

        $children = $reader->parseGetElements([
            '{}producer'    => ManufacturerXmlDeserializer::class,
            '{}category'    => CategoryXmlDeserializer::class,
            '{}card'        => function (Reader $reader) {
                $attrs = $reader->parseAttributes();
                $reader->next();

                return $attrs['url'];
            },
            '{}description' => function (Reader $reader) {
                return keyValue($reader, '');
            },
            '{}parameters'  => function (Reader $reader) {
                return repeatingElements($reader, '{}parameter');
            },
            '{}parameter' => ProductAttributeXmlDeserializer::class,
            '{}images'      => function (Reader $reader) {
                $elements = $reader->parseInnerTree();

                return $elements[0]['value'];
            },
            '{}large' => function (Reader $reader) {
                return repeatingElements($reader, '{}image');
            },
            '{}image' => ProductImageXmlDeserializer::class,
        ]);

        foreach ($children as $child) {
            switch ($child['name']) {
                case '{}producer':
                    $product->setManufacturer($child['value']);
                    break;
                case '{}category':
                    $product->setCategory($child['value']);
                    break;
                case '{}card':
                    $product->setExternalListingUrl($child['value']);
                    break;
                case '{}description':
                    $product->setName($child['value']['name']);
                    $product->setDescription($child['value']['long_desc']);
                    break;
                case '{}images':
                    $product->addImages($child['value']);
                    break;
                case '{}parameters':
                    $product->addAttributes($child['value']);
                    break;
            }
        }

        return $product;
    }
}