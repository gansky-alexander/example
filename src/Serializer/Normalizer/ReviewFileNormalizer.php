<?php

namespace App\Serializer\Normalizer;

use App\Entity\Category;
use App\Entity\Review;
use App\Entity\ReviewFile;
use App\Helper\ServerHostData;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ReviewFileNormalizer implements ContextAwareNormalizerInterface
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
     * @param ReviewFile $topic
     * @param null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|mixed|string|null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize($topic, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($topic, $format, $context);

        if ($topic->getPath() != '') {
            $data['path'] = $this->serverHostData->getServerUrl() . $topic->getPath();
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof ReviewFile;
    }
}
