<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\ProductVariant;
use App\Entity\SonataMediaMedia;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\File;

class ProductFixtures extends Fixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $mediaManager = $this->getMediaManager();

        $products = [
            'a' => [
                'categories' => [
                    $this->getReference('category_Eyeshadow'),
                    $this->getReference('category_Eyes'),
                    $this->getReference('category_Neutrals'),
                ],
                'rating' => 4.8,
                'amountOfReviews' => 142,
                'price' => 12.5,
                'isActive' => true,
                'usedForBox' => true,
                'brand' => $this->getReference('brand_Clarins'),
                'name' => [
                    'en' => 'Lipstick',
                    'ru' => 'Губная помада',
                ],
                'shortDescription' => [
                    'en' => 'Short description for Lipstick',
                    'ru' => 'Краткое описание к губной помаде',
                ],
                'description' => [
                    'en' => '<p>Description for Lipstick<p/>',
                    'ru' => '<p>Описание к губной помаде</p>',
                ],
                'ingredients' => [
                    'en' => '<p>Ingredients for Lipstick</p>',
                    'ru' => '<p>Ингредиенты для губной помады</p>',
                ],
                'ingredients_content_formatter' => 'richhtml',
                'ingredients_raw' => [
                    'en' => '<p>Ingredients for Lipstick</p>',
                    'ru' => '<p>Ингредиенты для губной помады</p>',
                ],
                'description_content_formatter' => 'richhtml',
                'description_raw' => [
                    'en' => '<p>Ingredients for Lipstick</p>',
                    'ru' => '<p>Ингредиенты для губной помады</p>',
                ],
                'badges' => [
                    $this->getReference('badge_Sale'),
                    $this->getReference('badge_New arrivals'),
                ],
                'hairColor' => $this->getReference('hairColor_Black'),
                'productImages' => [
                    [
                        'imageName' => '1.jpg',
                        'isMain' => true,
                    ],
                    [
                        'imageName' => '2.jpg',
                    ],
                    [
                        'imageName' => '3.jpg',
                    ],
                    [
                        'imageName' => '4.jpg',
                    ],
                    [
                        'imageName' => '5.jpg',
                    ],
                    [
                        'imageName' => '6.jpg',
                    ],
                ],
                'variants' => [
                    [
                        'price' => 12.5,
                        'oldPrice' => 15,
                        'stockAmount' => 20,
                        'sku' => 'A001',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#FFE4C6'),
                    ],
                    [
                        'price' => 12.5,
                        'oldPrice' => 15,
                        'stockAmount' => 20,
                        'sku' => 'A002',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#FFF7EE'),
                    ],
                    [
                        'price' => 12.5,
                        'oldPrice' => 15,
                        'stockAmount' => 20,
                        'sku' => 'A003',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#FFE9DE'),
                    ],
                    [
                        'price' => 12.5,
                        'oldPrice' => 15,
                        'stockAmount' => 20,
                        'sku' => 'A004',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#E7C4B9'),
                    ],
                    [
                        'price' => 12.5,
                        'oldPrice' => 15,
                        'stockAmount' => 20,
                        'sku' => 'A005',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#A25840'),
                    ],
                    [
                        'price' => 12.5,
                        'oldPrice' => 15,
                        'stockAmount' => 20,
                        'sku' => 'A006',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#5D3629'),
                    ],
                ],
            ],
            'b' => [
                'categories' => [
                    $this->getReference('category_Eyeshadow'),
                    $this->getReference('category_Eyes'),
                    $this->getReference('category_Neutrals'),
                ],
                'rating' => 4.3,
                'amountOfReviews' => 12,
                'price' => 14.5,
                'isActive' => true,
                'usedForBox' => false,
                'brand' => $this->getReference('brand_Clarins'),
                'name' => [
                    'en' => 'Lip+chick',
                    'ru' => 'Губы+щеки',
                ],
                'shortDescription' => [
                    'en' => 'Short description for Lip+chick',
                    'ru' => 'Краткое описание к Губы+щеки',
                ],
                'description' => [
                    'en' => '<p>Description for Lip+chick</p>',
                    'ru' => '<p>Описание к Губы+щеки</p>',
                ],
                'ingredients' => [
                    'en' => '<p>Ingredients for Lip+chick</p>',
                    'ru' => '<p>Ингредиенты для Губы+щеки</p>',
                ],
                'ingredients_content_formatter' => 'richhtml',
                'ingredients_raw' => [
                    'en' => '<p>Ingredients for Lip+chick</p>',
                    'ru' => '<p>Ингредиенты для Губы+щеки</p>',
                ],
                'description_content_formatter' => 'richhtml',
                'description_raw' => [
                    'en' => '<p>Ingredients for Lip+chick</p>',
                    'ru' => '<p>Ингредиенты для Губы+щеки</p>',
                ],
                'badges' => [
                    $this->getReference('badge_Sale'),
                    $this->getReference('badge_New arrivals'),
                ],
                'skinTone' => $this->getReference('skinTone_Light'),
                'hairColor' => $this->getReference('hairColor_Dark Brown'),
                'productImages' => [
                    [
                        'imageName' => '1.jpg',
                        'isMain' => true,
                    ],
                ],
                'variants' => [
                    [
                        'price' => 14.5,
                        'oldPrice' => 18,
                        'stockAmount' => 20,
                        'sku' => 'B001',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#FFE4C6'),
                    ],
                    [
                        'price' => 14.5,
                        'oldPrice' => 18,
                        'stockAmount' => 20,
                        'sku' => 'B002',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#FFF7EE'),
                    ],
                    [
                        'price' => 14.5,
                        'oldPrice' => 18,
                        'stockAmount' => 20,
                        'sku' => 'B003',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#FFE9DE'),
                    ],
                    [
                        'price' => 14.5,
                        'oldPrice' => 18,
                        'stockAmount' => 20,
                        'sku' => 'B004',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#E7C4B9'),
                    ],
                    [
                        'price' => 14.5,
                        'oldPrice' => 18,
                        'stockAmount' => 20,
                        'sku' => 'B005',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#A25840'),
                    ],
                    [
                        'price' => 14.5,
                        'oldPrice' => 18,
                        'stockAmount' => 20,
                        'sku' => 'B006',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#5D3629'),
                    ],
                ],
            ],
            'c' => [
                'categories' => [
                    $this->getReference('category_Eyeshadow'),
                    $this->getReference('category_Eyes'),
                    $this->getReference('category_Neutrals'),
                ],
                'rating' => 4.2,
                'amountOfReviews' => 45,
                'price' => 17.5,
                'isActive' => false,
                'usedForBox' => false,
                'brand' => $this->getReference('brand_Clarins'),
                'name' => [
                    'en' => 'Baked powder',
                    'ru' => 'Печеная пудра',
                ],
                'shortDescription' => [
                    'en' => 'Short description for Baked powder',
                    'ru' => 'Краткое описание к Печеная пудра',
                ],
                'description' => [
                    'en' => '<p>Description for Baked powder</p>',
                    'ru' => '<p>Описание к Печеная пудра</p>',
                ],
                'ingredients' => [
                    'en' => '<p>Ingredients for Baked powder</p>',
                    'ru' => '<p>Ингредиенты для Печеная пудра</p>',
                ],
                'ingredients_content_formatter' => 'richhtml',
                'ingredients_raw' => [
                    'en' => '<p>Ingredients for Baked powder</p>',
                    'ru' => '<p>Ингредиенты для Печеная пудра</p>',
                ],
                'description_content_formatter' => 'richhtml',
                'description_raw' => [
                    'en' => '<p>Ingredients for Baked powder</p>',
                    'ru' => '<p>Ингредиенты для Печеная пудра</p>',
                ],
                'skinTone' => $this->getReference('skinTone_Medium'),
                'hairColor' => $this->getReference('hairColor_Blonde'),
                'productImages' => [
                    [
                        'imageName' => '1.jpg',
                        'isMain' => true,
                    ],
                ],
                'variants' => [
                    [
                        'price' => 17.5,
                        'oldPrice' => 19,
                        'stockAmount' => 20,
                        'sku' => 'C001',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#FFE4C6'),
                    ],
                    [
                        'price' => 17.5,
                        'oldPrice' => 19,
                        'stockAmount' => 20,
                        'sku' => 'C002',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#FFF7EE'),
                    ],
                    [
                        'price' => 17.5,
                        'oldPrice' => 19,
                        'stockAmount' => 20,
                        'sku' => 'C003',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#FFE9DE'),
                    ],
                    [
                        'price' => 17.5,
                        'oldPrice' => 19,
                        'stockAmount' => 20,
                        'sku' => 'C004',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#E7C4B9'),
                    ],
                    [
                        'price' => 17.5,
                        'oldPrice' => 19,
                        'stockAmount' => 20,
                        'sku' => 'C005',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#A25840'),
                    ],
                    [
                        'price' => 17.5,
                        'oldPrice' => 19,
                        'stockAmount' => 20,
                        'sku' => 'C006',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#5D3629'),
                    ],
                ],
            ],
            'd' => [
                'categories' => [
                    $this->getReference('category_Eyeshadow'),
                    $this->getReference('category_Eyes'),
                    $this->getReference('category_Neutrals'),
                ],
                'rating' => 4.1,
                'amountOfReviews' => 23,
                'price' => 19,
                'isActive' => false,
                'usedForBox' => true,
                'brand' => $this->getReference('brand_Clarins'),
                'name' => [
                    'en' => 'Consealer',
                    'ru' => 'Тональный крем',
                ],
                'shortDescription' => [
                    'en' => 'Short description for Consealer',
                    'ru' => 'Краткое описание к Тональный крем',
                ],
                'description' => [
                    'en' => '<p>Description for Consealer</p>',
                    'ru' => '<p>Описание к Тональный крем</p>',
                ],
                'ingredients' => [
                    'en' => '<p>Ingredients for Consealer</p>',
                    'ru' => '<p>Ингредиенты для Тональный крем</p>',
                ],
                'ingredients_content_formatter' => 'richhtml',
                'ingredients_raw' => [
                    'en' => '<p>Ingredients for Consealer</p>',
                    'ru' => '<p>Ингредиенты для Тональный крем</p>',
                ],
                'description_content_formatter' => 'richhtml',
                'description_raw' => [
                    'en' => '<p>Ingredients for Consealer</p>',
                    'ru' => '<p>Ингредиенты для Тональный крем</p>',
                ],
                'skinTone' => $this->getReference('skinTone_Tan'),
                'hairColor' => $this->getReference('hairColor_Light Brown'),
                'productImages' => [
                    [
                        'imageName' => '1.jpg',
                        'isMain' => true,
                    ],
                ],
                'variants' => [
                    [
                        'price' => 19,
                        'oldPrice' => 21,
                        'stockAmount' => 20,
                        'sku' => 'D001',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#FFE4C6'),
                    ],
                    [
                        'price' => 19,
                        'oldPrice' => 21,
                        'stockAmount' => 20,
                        'sku' => 'D002',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#FFF7EE'),
                    ],
                    [
                        'price' => 19,
                        'oldPrice' => 21,
                        'stockAmount' => 20,
                        'sku' => 'D003',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#FFE9DE'),
                    ],
                    [
                        'price' => 19,
                        'oldPrice' => 21,
                        'stockAmount' => 20,
                        'sku' => 'D004',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#E7C4B9'),
                    ],
                    [
                        'price' => 19,
                        'oldPrice' => 21,
                        'stockAmount' => 20,
                        'sku' => 'D005',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#A25840'),
                    ],
                    [
                        'price' => 19,
                        'oldPrice' => 21,
                        'stockAmount' => 20,
                        'sku' => 'D006',
                        'size' => 20,
                        'sizeType' => $this->getReference('sizeType_g'),
                        'color' => $this->getReference('color_#5D3629'),
                    ],
                ],
            ],
        ];

        // add more products for test
        for ($i = 1; $i <= 15; $i++) {
            $products[$i] = $products['b'];

            foreach (['ru', 'en'] as $locale) {
                $products[$i]['name'][$locale] = $products[$i]['name'][$locale] . " #$i";
                $products[$i]['shortDescription'][$locale] = $products[$i]['shortDescription'][$locale] . " #$i";
                $products[$i]['description'][$locale] = "<h1>Text #$i/</h1>" . $products[$i]['description'][$locale];
                $products[$i]['ingredients'][$locale] = "<h1>Text #$i/</h1>" . $products[$i]['ingredients'][$locale];
                $products[$i]['ingredients_raw'][$locale] = "<h1>Text #$i/</h1>" . $products[$i]['ingredients_raw'][$locale];
                $products[$i]['description_raw'][$locale] = "<h1>Text #$i/</h1>" . $products[$i]['description_raw'][$locale];
            }

            foreach ($products[$i]['variants'] as $key => $variant) {
                $products[$i]['variants'][$key]['sku'] = 'Z00' . $i . $key;
            }
        }

        foreach ($products as $key => $data) {
            $product = new Product();
            $product->setRating($data['rating']);
            $product->setAmountOfReviews($data['amountOfReviews']);
            $product->setIsActive($data['isActive']);
            $product->setUsedForBox($data['usedForBox']);
            $product->setBrand($data['brand']);
            $product->setPrice($data['price']);
            $product->setHairColor($data['hairColor']);
            foreach ($data['categories'] as $category) {
                $product->addCategory($category);
            }

            if (isset($data['badges'])) {
                foreach ($data['badges'] as $badge) {
                    $product->addBadge($badge);
                }
            }

            foreach ($data['name'] as $locale => $name) {
                $product->translate($locale)->setName($name);
            }
            foreach ($data['shortDescription'] as $locale => $shortDescription) {
                $product->translate($locale)->setShortDescription($shortDescription);
            }
            foreach ($data['description'] as $locale => $description) {
                $product->translate($locale)->setDescription($description);
            }
            foreach ($data['description_raw'] as $locale => $descriptionRaw) {
                $product->translate($locale)->setDescriptionRaw($descriptionRaw);
            }
            foreach ($data['ingredients'] as $locale => $ingredients) {
                $product->translate($locale)->setIngredients($ingredients);
            }
            foreach ($data['ingredients_raw'] as $locale => $ingredientsRaw) {
                $product->translate($locale)->setIngredientsRaw($ingredientsRaw);
            }

            $product->mergeNewTranslations();

            foreach ($data['productImages'] as $imageData) {
                $imageFile = new File(__DIR__ . '/images/' . $imageData['imageName']);

                /** @var SonataMediaMedia $image */
                $image = $mediaManager->create();
                $image->setBinaryContent($imageFile);
                $image->setEnabled(true);
                $image->setName($imageData['imageName']);
                $image->setContext('default');
                $image->setProviderName('sonata.media.provider.image');
                $mediaManager->save($image);

                $productImage = new ProductImage();
                if (isset($imageData['isMain'])) {
                    $productImage->setIsMain($imageData['isMain']);
                }
                $productImage->setProduct($product);
                $productImage->setMediaImage($image);

                $manager->persist($productImage);
            }

            foreach ($data['variants'] as $variantData) {
                $variant = new ProductVariant();
                $variant->setProduct($product);
                $variant->setStockAmount($variantData['stockAmount']);
                $variant->setOldPrice($variantData['oldPrice']);
                $variant->setPrice($variantData['price']);
                $variant->setSku($variantData['sku']);
                $variant->setSize($variantData['size']);
                $variant->setSizeType($variantData['sizeType']);
                $variant->setColor($variantData['color']);

                $this->addReference('product_variant_' . $variantData['sku'], $variant);

                $manager->persist($variant);
            }

            $this->addReference('product_' . $key, $product);

            $manager->persist($product);
        }

        $manager->flush();
    }

    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    public function getMediaManager()
    {
        return $this->container->get('sonata.media.manager.media');
    }

    public function getOrder()
    {
        return 2;
    }
}
