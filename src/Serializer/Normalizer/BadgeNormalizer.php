<?php

namespace App\Serializer\Normalizer;

use App\Entity\Badge;
use App\Entity\HairColor;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BadgeNormalizer implements ContextAwareNormalizerInterface
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
     * @param Badge $topic
     * @param null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|mixed|string|null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize($topic, $format = null, array $context = [])
    {
        $request = $this->requestStack->getCurrentRequest();
        $data = $this->normalizer->normalize($topic, $format, $context);

        $data['name'] = $topic->translate($request->getLocale())->getName();

        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Badge;
    }
}
