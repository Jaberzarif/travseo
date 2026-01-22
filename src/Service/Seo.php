<?php

namespace App\Service;

use App\Entity\Destination;
use Symfony\Component\HttpFoundation\RequestStack;

class Seo
{
    private RequestStack $requestStack;

    public string $title = '';
    public string $description = '';
    public string $canonical = '';
    public string $ogTitle = '';
    public string $ogDescription = '';
    public string $ogUrl = '';
    public string $ogType = 'website';
    public string $ogImage = '';
    public string $author = 'Dream Tours';
    public string $keywords = 'Tunisia, tours, travel, Sahara, Djerba, cultural tours, desert, beaches';

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    // Home page
    public function home(): self
    {
        $this->title = 'Dream Tours – Explore Tunisia from Djerba';
        $this->description = 'Explore Tunisia with Dream Tours, a travel agency based in Djerba. Sahara tours, desert adventures, cultural sites, and beach holidays.';
        $this->canonical = 'https://www.dream-tours.com/';

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;
        $this->ogType = 'website';
        $this->ogImage = '/images/hero.jpg'; // default homepage image

        return $this;
    }

    // Destinations listing
    public function destinations(): self
    {
        $this->title = 'Destinations in Tunisia | Dream Tours – Djerba';
        $this->description = 'Discover the most beautiful destinations in Tunisia with Dream Tours. Sahara, oases, beaches, cultural sites, and custom tours.';
        $this->canonical = 'https://www.dream-tours.com/destinations';

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;
        $this->ogType = 'website';
        $this->ogImage = '/images/destinations.jpg';

        return $this;
    }

    // Single destination page
    public function singlePost(Destination $destination): self
    {
        $this->title = $destination->getName() . ' | Dream Tours';
        $this->description = substr(strip_tags($destination->getDescription() ?? ''), 0, 160);
        $this->canonical = 'https://www.dream-tours.com/destinations/' . $destination->getSlug();

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;
        $this->ogType = 'article';
        $this->ogImage = $destination->getImage();
        $this->author = 'Dream Tours';
        $this->keywords = $destination->getName() . ', Tunisia, tours, travel';

        return $this;
    }

    // Contact page
    public function contact(): self
    {
        $this->title = 'Contact Dream Tours | Djerba, Tunisia';
        $this->description = 'Get in touch with Dream Tours to plan your trips across Tunisia. Sahara, oases, beaches, and tailor-made travel.';
        $this->canonical = 'https://www.dream-tours.com/contact';

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;
        $this->ogType = 'website';
        $this->ogImage = '/images/contact.jpg';

        return $this;
    }

    // Helper: Get current URL
    public function getCurrentUrl(): string
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) return '';
        return $request->getSchemeAndHttpHost() . $request->getRequestUri();
    }
}
