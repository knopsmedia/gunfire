<?php declare(strict_types=1);

namespace Knops\Gunfire;

use Knops\Gunfire\Model\Product;
use Knops\Gunfire\Model\ProductPrice;
use Knops\Gunfire\Serializer\ProductPriceXmlDeserializer;
use Knops\Gunfire\Serializer\ProductXmlDeserializer;
use Sabre\Xml\Reader;
use function Sabre\Xml\Deserializer\repeatingElements;

final class GunfireService
{
    private string $productsXmlFile;
    private string $pricesXmlFile;

    public function __construct(string $productsXmlFile, string $pricesXmlFile)
    {
        $this->productsXmlFile = $productsXmlFile;
        $this->pricesXmlFile = $pricesXmlFile;
    }

    /**
     * @return Product[]
     * @throws \Sabre\Xml\LibXMLException
     */
    public function getProducts(): array
    {
        $reader = new Reader();
        $reader->elementMap = [
            '{}offer'    => function (Reader $reader) {
                $products = $reader->parseGetElements();

                return $products[0]['value'];
            },
            '{}products' => function (Reader $reader) {
                $reader->elementMap['{}product'] = ProductXmlDeserializer::class;

                return repeatingElements($reader, '{}product');
            },
        ];

        $reader->open($this->productsXmlFile);

        return $reader->parse()['value'];
    }

    /**
     * @return ProductPrice[]
     * @throws \Sabre\Xml\LibXMLException
     */
    public function getPrices(): array
    {
        $reader = new Reader();
        $reader->elementMap = [
            '{}offer'   => function (Reader $reader) {
                $elements = $reader->parseGetElements([
                    '{}products' => function(Reader $reader) {
                        $attributes = $reader->parseAttributes();
                        ProductPriceXmlDeserializer::setCurrency($attributes['currency']);

                        $elements = $reader->parseGetElements(['{}product' => ProductPriceXmlDeserializer::class]);
                        $prices = [];

                        foreach ($elements as $price) {
                            $prices[] = $price['value'];
                        }

                        return $prices;
                    },
                ]);

                return $elements[0]['value'];
            },
        ];

        $reader->open($this->pricesXmlFile);

        return $reader->parse()['value'];
    }
}