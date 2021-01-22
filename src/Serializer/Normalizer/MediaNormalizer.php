<?php

namespace App\Serializer\Normalizer;

use App\Entity\Brand;
use App\Entity\SonataMediaMedia;
use App\Helper\ServerHostData;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sonata\MediaBundle\Provider\ImageProvider;

class MediaNormalizer implements ContextAwareNormalizerInterface
{
    protected $router;
    protected $normalizer;
    protected $serverHostData;
    protected $imageProvider;
    protected $requestStack;

    public function __construct(
        UrlGeneratorInterface $router,
        ObjectNormalizer $normalizer,
        ImageProvider $imageProvider,
        RequestStack $requestStack,
        ServerHostData $serverHostData
    )
    {
        $this->router = $router;
        $this->normalizer = $normalizer;
        $this->serverHostData = $serverHostData;
        $this->imageProvider = $imageProvider;
        $this->requestStack = $requestStack;
    }

    /**
     * @param SonataMediaMedia $topic
     * @param null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|mixed|string|null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize($topic, $format = null, array $context = [])
    {
        return $this->serverHostData->getServerUrl() . $this->imageProvider->generatePublicUrl($topic, MediaProviderInterface::FORMAT_REFERENCE);
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof SonataMediaMedia;
    }
}
