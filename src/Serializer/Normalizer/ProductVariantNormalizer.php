<?php

namespace App\Serializer\Normalizer;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductVariant;
use App\Entity\SonataMediaMedia;
use App\Helper\ServerHostData;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sonata\MediaBundle\Provider\ImageProvider;

class ProductVariantNormalizer implements ContextAwareNormalizerInterface
{
    protected $normalizer;
    protected $requestStack;

    public function __construct(
        ObjectNormalizer $normalizer,
        RequestStack $requestStack
    )
    {
        $this->normalizer = $normalizer;
        $this->requestStack = $requestStack;
    }

    /**
     * @param ProductVariant $topic
     * @param null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|mixed|string|null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize($topic, $format = null, array $context = [])
    {
        $request = $this->requestStack->getCurrentRequest();
        $data = $this->normalizer->normalize($topic, $format, $context);

        $data['color'] = $topic->getColor()->getColor();
        $data['size_type'] = $topic->getSizeType()->translate($request->getLocale())->getName();

        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof ProductVariant;
    }
}
