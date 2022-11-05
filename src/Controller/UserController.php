<?php

namespace App\Controller;

use App\Form\HashType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/hash')]
    public function generateHash(Request $request): Response
    {
        $form = $this->createForm(HashType::class);
        $hash = NULL;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = hash('sha256', $form['password']->getData());
        }

        return $this->renderForm('hasher.html.twig',[
            'form' => $form,
            'hash' => $hash,
        ]);
    }
}