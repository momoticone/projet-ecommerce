<?php
namespace App\Controller\Admin\User;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ShowUserController extends AbstractController 
{
    /**
     * @Route("/admin/user/show/{id}", name="show_user")
     */
    public function show(int $id,UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        return $this->render('admin/user/show_user.html.twig', [
            'user' => $user
        ]);
    }
}