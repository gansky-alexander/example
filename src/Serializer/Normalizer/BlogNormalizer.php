<?php

namespace App\Serializer\Normalizer;

use App\Entity\Blog;
use App\Helper\ServerHostData;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BlogNormalizer implements ContextAwareNormalizerInterface
{
    protected $router;
    protected $normalizer;
    protected $serverHostData;
    protected $requestStack;

    public function __construct(
        UrlGeneratorInterface $router,
        ObjectNormalizer $normalizer,
        RequestStack $requestStack,
        ServerHostData $serverHostData)
    {
        $this->router = $router;
        $this->normalizer = $normalizer;
        $this->serverHostData = $serverHostData;
        $this->requestStack = $requestStack;
    }

    /**
     * @param Blog $topic
     * @param null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|mixed|string|null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize($topic, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($topic, $format, $context);

        if ($topic->getImage() != '') {
            $data['image'] = $this->serverHostData->getServerUrl() . $topic->getImage();
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Blog;
    }
}
