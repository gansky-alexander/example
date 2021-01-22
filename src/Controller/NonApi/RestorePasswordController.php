<?php

namespace App\Controller\NonApi;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RestorePasswordController extends AbstractController
{
    /**
     * @Route("/password-restore/{token}", name="password_restore_redirect", methods={"GET"})
     */
    public function restore(Request $request)
    {
        return new RedirectResponse('fyneapp://reset_password/' . $request->get('token'));
    }
}
