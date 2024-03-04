<?php
// src/Controller/CustomerController.php
namespace App\Controller\Home;

// ...
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function createCustomer(EntityManagerInterface $entityManager, Request $request): Response
    {
        return $this->render("home/home.html.twig");
    }

}