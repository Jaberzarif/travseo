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
    public string $author = 'Verite Voyages';
    public string $keywords = '';
    public array $schema = [];

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    // Home page
    public function home(): self
    {
        $this->title = 'Verite Voyages – Explore Tunisia from Djerba';
        $this->description = 'Explore Tunisia with Verite Voyages, a travel agency based in Djerba. Sahara tours, desert adventures, cultural sites, and beach holidays.';
        $this->canonical = 'https://www.dream-tours.com/';

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;
        $this->ogType = 'website';
        $this->ogImage = '/images/hero.jpg';
        $this->keywords = 'agence de voyage Tunisie, tours en Tunisie, excursions Djerba, circuits Sahara Tunisie, séjours Tunisie, Verite Voyages';
        return $this;
    }

    // Destinations listing
    public function destinations(): self
    {
        $this->title = 'Destinations in Tunisia | Verite Voyages – Djerba';
        $this->description = 'Discover the most beautiful destinations in Tunisia with Verite Voyages. Sahara, oases, beaches, cultural sites, and custom tours.';
        $this->canonical = 'https://www.dream-tours.com/destinations';

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;
        $this->ogType = 'website';
        $this->ogImage = '/images/destinations.jpg';
        $this->keywords = 'destinations Tunisie, excursions Tunisie, circuits touristiques Tunisie, Sahara Tunisie, Djerba, Tozeur, Verite Voyages';

        return $this;
    }

    // Single destination page
    public function singlePost(Destination $destination): self
    {
        $this->title = $destination->getName() . ' | Verite Voyages';
        $this->description = substr(strip_tags($destination->getDescription() ?? ''), 0, 160);
        $this->canonical = 'https://www.dream-tours.com/destinations/' . $destination->getSlug();

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;
        $this->ogType = 'article';
        $this->ogImage = $destination->getImage();
        $this->author = 'Verite Voyages';
        $this->keywords = strtolower(
            $destination->getName()
                . ', excursion ' . $destination->getName()
                . ', circuit ' . $destination->getName()
                . ', voyage Tunisie, Verite Voyages'
        );

        $this->schema = [
            '@context' => 'https://schema.org',
            '@type' => 'TouristTrip',
            'name' => 'Excursion à ' . $destination->getName(),
            'description' => strip_tags($destination->getDescription()),
            'touristType' => 'Leisure',
            'itinerary' => [
                '@type' => 'Place',
                'name' => $destination->getName(),
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressCountry' => 'TN'
                ]
            ],
            'provider' => [
                '@type' => 'TravelAgency',
                'name' => 'Verite Voyages',
                'url' => 'https://verite-voyages.com'
            ]
        ];

        return $this;
    }

    // Contact page
    public function contact(): self
    {
        $this->title = 'Contact Verite Voyages | Djerba, Tunisia';
        $this->description = 'Get in touch with Verite Voyages to plan your trips across Tunisia. Sahara, oases, beaches, and tailor-made travel.';
        $this->canonical = 'https://www.dream-tours.com/contact';

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;
        $this->ogType = 'website';
        $this->ogImage = '/images/contact.jpg';
        $this->keywords = 'contact agence de voyage Tunisie, Verite Voyages Djerba, voyage Tunisie contact, excursions Tunisie';

        return $this;
    }


    // Contact page
    public function login(): self
    {
        $this->title = 'Login Verite Voyages | Djerba, Tunisia';
        $this->description = 'Login in Verite Voyages to plan your trips across Tunisia. Sahara, oases, beaches, and tailor-made travel.';
        $this->canonical = 'https://www.dream-tours.com/login';

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;
        $this->ogType = 'website';
        $this->ogImage = '/images/login.jpg';

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
