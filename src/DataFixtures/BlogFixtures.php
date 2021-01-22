<?php


namespace App\DataFixtures;


use App\Entity\Blog;
use App\Entity\BlogTag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tags = [
            [
                'name' => [
                    'en' => 'Trending',
                    'ru' => 'Тренды',
                ],
            ],
            [
                'name' => [
                    'en' => 'New',
                    'ru' => 'Новые',
                ],
            ],
            [
                'name' => [
                    'en' => 'Celebrity',
                    'ru' => 'Звезды',
                ],
            ],
        ];

        foreach ($tags as $data) {
            $tag = new BlogTag();

            foreach ($data['name'] as $locale => $name) {
                $tag->translate($locale)->setName($name);
            }
            $tag->mergeNewTranslations();
            $this->addReference('blog_tag_' . $data['name']['en'], $tag);

            $manager->persist($tag);
        }

        $blogs = [
            [
                'title' => 'New mascara #1',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => true,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-01-01'),
                'tags' => [
                    $this->getReference('blog_tag_Trending'),
                    $this->getReference('blog_tag_New'),
                ]
            ],
            [
                'title' => 'New mascara #2',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => true,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-01'),
                'tags' => [
                    $this->getReference('blog_tag_Trending'),
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #3',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => false,
                'popular' => false,
                'is_published' => false,
                'publish_date' => new \DateTime('2020-10-01'),
                'tags' => [
                    $this->getReference('blog_tag_New'),
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #4',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => false,
                'popular' => true,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-02'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #5',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #6',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #7',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #8',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #9',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #10',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #11',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #12',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #13',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #14',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #15',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #16',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
            [
                'title' => 'New mascara #17',
                'text' => <<<BLOG
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
pariatur.</p><p> Excepteur sint occaecat cupidatat non proident, sunt 
in culpa qui officia deserunt mollit anim id est laborum.</p>
BLOG,
                'image' => '/images/blog/test/blog.jpg',
                'is_for_you' => true,
                'popular' => false,
                'is_published' => true,
                'publish_date' => new \DateTime('2020-10-03'),
                'tags' => [
                    $this->getReference('blog_tag_Celebrity'),
                ]
            ],
        ];

        foreach ($blogs as $data) {
            $blog = new Blog();
            $blog->setTitle($data['title']);
            $blog->setImage($data['image']);
            $blog->setText($data['text']);
            $blog->setIsForYou($data['is_for_you']);
            $blog->setIsPopular($data['popular']);
            $blog->setIsPublished($data['is_published']);
            $blog->setPublishDate($data['publish_date']);
            $blog->setContentFormatter('richhtml');
            $blog->setRawContent($data['text']);

            foreach($data['tags'] as $tagData) {
                $blog->addTag($tagData);
            }

            $this->addReference('blog_' . $data['title'], $blog);

            $manager->persist($blog);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
