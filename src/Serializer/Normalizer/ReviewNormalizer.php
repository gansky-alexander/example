<?php

namespace App\Serializer\Normalizer;

use App\Entity\Category;
use App\Entity\Review;
use App\Entity\ReviewFile;
use App\Helper\ServerHostData;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ReviewNormalizer implements ContextAwareNormalizerInterface
{
    protected $router;
    protected $normalizer;
    protected $serverHostData;
    protected $requestStack;
    protected $security;

    public function __construct(
        UrlGeneratorInterface $router,
        ObjectNormalizer $normalizer,
        RequestStack $requestStack,
        ServerHostData $serverHostData,
        Security $security
    )
    {
        $this->router = $router;
        $this->normalizer = $normalizer;
        $this->serverHostData = $serverHostData;
        $this->requestStack = $requestStack;
        $this->security = $security;
    }

    /**
     * @param Review $topic
     * @param null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|mixed|string|null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize($topic, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($topic, $format, $context);

        $wasLiked = false;
        foreach ($topic->getLikes() as $like) {
            if ($like->getCustomer()->getId() == $this->security->getUser()->getId()) {
                $wasLiked = true;
            }
        }

        $data['was_liked'] = $wasLiked;
        $data['likes_count'] = $topic->getLikes()->count();

        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Review;
    }
}
