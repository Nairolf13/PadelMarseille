<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AdminRepository;

final class HomeController extends AbstractController
{
    public function __construct(
        private AdminRepository $adminRepository
    ) {}

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $admins = $this->adminRepository->findAll();
        
        $adminData = array_map(function($admin) {
            return [
                'id' => $admin->getId(),
                'username' => $admin->getUsername(),
                'createdAt' => $admin->getCreatedAt()->format('Y-m-d H:i:s')
            ];
        }, $admins);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'admins' => $adminData
        ]);
    }
}
