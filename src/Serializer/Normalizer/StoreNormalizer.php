<?php

namespace App\Serializer\Normalizer;

use App\Entity\Store;
use App\Helper\ServerHostData;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class StoreNormalizer implements ContextAwareNormalizerInterface
{
    protected $router;
    protected $normalizer;
    protected $serverHostData;

    public function __construct(
        UrlGeneratorInterface $router,
        ObjectNormalizer $normalizer,
        ServerHostData $serverHostData)
    {
        $this->router = $router;
        $this->normalizer = $normalizer;
        $this->serverHostData = $serverHostData;
    }

    public function normalize($topic, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($topic, $format, $context);

        if($data['image'] != '') {
            $data['image'] = $this->serverHostData->getServerUrl() . $data['image'];
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Store;
    }
}
