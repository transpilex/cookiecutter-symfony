<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class PagesController extends AbstractController
{

    public function __construct(private readonly Environment $twig) {}


    #[Route('/', name: 'app_root')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

  
    #[Route('/{path}', name: 'app_static_page', requirements: ['path' => '.+'])]
    public function staticPage(string $path): Response
    {
        $path = str_replace(['..', '//'], '', $path);
        
        $templateName = $path . '.html.twig';

        if (!$this->twig->getLoader()->exists($templateName)) {
            throw $this->createNotFoundException('The static page "' . $path . '" does not exist.');
        }

        return $this->render($templateName);
    }
}