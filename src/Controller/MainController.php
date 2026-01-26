<?php

namespace App\Controller;



use App\Service\Seo;
use App\Entity\Destination;
use App\Entity\Booking;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $em, Seo $seo, Request $request): Response
    {
        $limit = 6;
        $offset = $request->query->getInt('offset', 0); // used for "Load more"

        $destinations = $em->getRepository(Destination::class)->findBy(
            [],
            ['id' => 'ASC'],
            $limit,
            $offset
        );

        // Detect AJAX request
        if ($request->isXmlHttpRequest()) {
            return $this->render('partials/_destinations_grid.html.twig', [
                'destinations' => $destinations
            ]);
        }

        return $this->render('home/index.html.twig', [
            'destinations' => $destinations,
            'seo' => $seo->home()
        ]);
    }


    #[Route('/destinations', name: 'destinations')]
    public function destinations(EntityManagerInterface $em, Seo $seo, Request $request): Response
    {
        $limit = 9;
        $offset = $request->query->getInt('offset', 0); // used for "Load more"

        $destinations = $em->getRepository(Destination::class)->findBy(
            [],
            ['id' => 'ASC'],
            $limit,
            $offset
        );

        // Detect AJAX request
        if ($request->isXmlHttpRequest()) {
            return $this->render('partials/_destinations_grid.html.twig', [
                'destinations' => $destinations
            ]);
        }
        return $this->render('destinations/destinations.html.twig', [
            'destinations' => $destinations,
            'seo' => $seo->destinations(),
        ]);
    }

    #[Route('/tours', name: 'tours')]
    public function tours(Seo $seo): Response
    {
        return $this->render('tours/tours.html.twig', ['seo' => $seo->home()]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Seo $seo): Response
    {
        return $this->render('contact/contact.html.twig', ['seo' => $seo->contact()]);
    }

    // #[Route('/destinations/{slug}', name: 'destination_show')]
    // public function show(string $slug, EntityManagerInterface $em, Seo $seo): Response
    // {
    //     $destination = $em->getRepository(Destination::class)->findOneBy([
    //         'slug' => $slug
    //     ]);

    //     if (!$destination) {
    //         throw $this->createNotFoundException('Destination not found');
    //     }

    //     return $this->render('destinations/show.html.twig', [
    //         'destination' => $destination,
    //         'seo' => $seo->singlePost($destination),
    //     ]);
    // }


    #[Route('/login', name: 'app_login')]
    public function login(Seo $seo): Response
    {
        return $this->render('security/login.html.twig', [
            'seo' => $seo->login(),
        ]);
    }



    #[Route('/destinations/{slug}', name: 'destination_show')]
    public function show(
        string $slug,
        EntityManagerInterface $em,
        Request $request,
        Seo $seo
    ): Response {
        // Fetch the destination by slug
        $destination = $em->getRepository(Destination::class)->findOneBy(['slug' => $slug]);

        if (!$destination) {
            throw $this->createNotFoundException('Destination not found');
        }

        $user = $this->getUser(); // Get current logged-in user

        // Create a new booking object
        $booking = new Booking();
        $booking->setDestination($destination);

        // Build the booking form
        $form = $this->createFormBuilder($booking)
            ->add('people', IntegerType::class, [
                'label' => 'Number of People',
                'attr' => ['min' => 1]
            ])
            ->add('date', DateType::class, ['widget' => 'single_text'])
            ->add('message', TextareaType::class, ['required' => false])
            ->getForm();

        $form->handleRequest($request);

        // Form submission
        if ($form->isSubmitted() && $form->isValid()) {
            // Check if user is logged in
            if (!$user) {
                $this->addFlash('warning', 'You must be logged in to make a booking.');
                return $this->redirectToRoute('app_login');
            }

            // Set booking details
            $booking->setUser($user); // Assign current user
            $booking->setPrice($destination->getPrice() * $booking->getPeople());

            $em->persist($booking);
            $em->flush();

            $this->addFlash('success', 'Booking successful!');
            return $this->redirectToRoute('destination_show', ['slug' => $slug]);
        }

        return $this->render('destinations/show.html.twig', [
            'destination' => $destination,
            'form' => $form->createView(),
            'seo' => $seo->singlePost($destination),
        ]);
    }
}
