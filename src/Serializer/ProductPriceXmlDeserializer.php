<?php declare(strict_types=1);

namespace Knops\Gunfire\Serializer;

use Knops\Gunfire\Model\ProductPrice;
use Sabre\Xml\Reader;
use Sabre\Xml\XmlDeserializable;

final class ProductPriceXmlDeserializer implements XmlDeserializable
{
    private static string $currency = 'EUR';

    public static function setCurrency(string $currency): void
    {
        self::$currency = $currency;
    }

    public static function xmlDeserialize(Reader $reader)
    {
        $attributes = $reader->parseAttributes();
        $prices = $reader->parseGetElements([
            '{}srp' => function(Reader $reader) {
                $attributes = $reader->parseAttributes();
                $reader->next();

                return (float)$attributes['gross'];
            },
            '{}sizes' => function(Reader $reader) {
                $arr = $reader->parseInnerTree();
                if (!is_array($arr)) {
                    return $arr;
                }

                return $arr[0]['value'];
            },
            '{}size' => function(Reader $reader) {
                $arr = $reader->parseInnerTree();
                if (!is_array($arr)) {
                    return $arr;
                }

                return $arr[0]['value'];
            },
            '{}stock' => function(Reader $reader) {
                $attributes = $reader->parseAttributes();
                $reader->next();

                return (int)$attributes['quantity'];
            },
        ]);

        return new ProductPrice((int)$attributes['id'], (int)$prices[3]['value'], $prices[1]['value'], self::$currency);
    }
}