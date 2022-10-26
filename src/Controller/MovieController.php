<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    private array $faker = [
        ['title' => 'Alien', 'releasedAt' => '1997-09-22', 'genres' => ['SF', 'Violent']],
        ['title' => 'Chucky', 'releasedAt' => '1997-09-22', 'genres' => ['Horreur', 'Violent', 'Dorothée']],
        ['title' => 'Predator', 'releasedAt' => '1997-09-22', 'genres' => ['SF', 'Violent']]
    ];

    #[Route('/movie', name: 'app_movie')]
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
            'movies' => $this->faker
        ]);
    }

    #[Route('/movie_details/{title<\w+>}', name: 'app_movie_details')]
    public function movie_details(string $title): Response
    {
        $selected = [];
        foreach ($this->faker as $movie) {
            if (str_replace(' ', '-', strtolower($movie['title'])) === $title) {
                $selected = $movie;
            }
        }

        if (empty($selected)) {
            throw $this->createNotFoundException('The movie "' . $title . '" does not exist.');
        }

        return $this->render('movie/movie.html.twig', [
            'movie' => $selected
        ]);
    }
}
