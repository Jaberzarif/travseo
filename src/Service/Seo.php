<?php

namespace App\Service;

class Seo
{
    public string $title = '';
    public string $description = '';
    public string $canonical = '';

    public string $ogTitle = '';
    public string $ogDescription = '';
    public string $ogUrl = '';

    public function home(): self
    {
        $this->title = 'Vérité Voyages';
        $this->description = 'Découvrez la Tunisie avec Vérité Voyages, agence de voyages basée à Djerba. Nous proposons des excursions dans le désert, des circuits au Sahara, des visites culturelles, des séjours balnéaires et des voyages sur mesure pour des expériences inoubliables.';
        $this->canonical = 'https://www.verite-voyages.com/';


        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;

        return $this;
    }

    public function destinations(): self
    {
        $this->title = 'Destinations en Tunisie | Vérité Voyages – Djerba';
        $this->description = 'Découvrez les plus belles destinations en Tunisie avec Vérité Voyages, agence de voyages basée à Djerba. Sahara, oasis, plages, sites culturels et circuits sur mesure pour une expérience inoubliable.';
        $this->canonical = 'https://www.verite-voyages.com/destinations';

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;

        return $this;
    }

    public function tours(): self
    {
        $this->title = 'Tours en Tunisie | Vérité Voyages';
        $this->description = 'Découvrez les meilleurs circuits en Tunisie avec Vérité Voyages : désert, culture, plages et voyages sur mesure depuis Djerba.';
        $this->canonical = 'https://www.verite-voyages.com/tours';

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;

        return $this;
    }

    public function contact(): self
    {
        $this->title = 'Contactez Vérité Voyages | Djerba, Tunisie';
        $this->description = 'Contactez Vérité Voyages à Djerba pour planifier vos circuits en Tunisie. Sahara, oasis, plages et voyages sur mesure.';
        $this->canonical = 'https://www.verite-voyages.com/contact';

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;

        return $this;
    }
}
