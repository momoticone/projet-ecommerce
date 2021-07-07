<?php
namespace App\Controller\Admin\User;

use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListUserController extends AbstractController 
{
    /**
     * @Route("/admin/user/list", name="list_user")
     */
    public function show(UserRepository $userRepository,Request $request,
                            PaginatorInterface $paginatorInterface): Response
    {
        $data = $userRepository->findAll();

        $users = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('pages',1),10
        );
        return $this->render('admin/user/list_user.html.twig', [
            'users' => $users
        ]);
    }
}
