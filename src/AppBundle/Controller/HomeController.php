<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function homeAction()
    {
        // return new Response("Hola");
        return $this->render("AppBundle:home:index.html.twig");
    }
    /*
    public function getUsersAction()
    {
        $objHomeService = $this->get("app.service_home");
        $objUsers = $objHomeService->getUsers();
        
        // Convertir los objetos de usuario a un array asociativo
        $usersArray = [];
        foreach ($objUsers as $user) {
            $usersArray[] = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                // Agrega más propiedades según tu entidad User
            ];
        }

        // Convertir el array asociativo a JSON y devolverlo como respuesta
        return new JsonResponse($usersArray);
    }*/

    // Método con serialize en la entidad
    public function getUsersAction()
    {
        $objHomeService = $this->get("app.service_home");

        $objUsers = $objHomeService->getUsers();

        // Convertir el array asociativo a JSON y retornarlo como respuesta
        return new JsonResponse($objUsers);
    }
    public function getUsersByQBAction()
    {
        $objHomeService = $this->get("app.service_home");

        $objUsers = $objHomeService->getUsersByQueryBuilder();

        // Convertir el array asociativo a JSON y retornarlo como respuesta
        return new JsonResponse($objUsers);
    }

    public function getUsersByNQAction()
    {
        $objHomeService = $this->get("app.service_home");

        $objUsers = $objHomeService->getUsersByNativeQuery();

        // Convertir el array asociativo a JSON y retornarlo como respuesta
        return new JsonResponse($objUsers);
    }
    public function getUsersByDQLAction()
    {
        $objHomeService = $this->get("app.service_home");

        $objUsers = $objHomeService->getUsersByDQL();

        // Convertir el array asociativo a JSON y retornarlo como respuesta
        return new JsonResponse($objUsers);
    }

    public function createUserAction(Request $request)
    {
        $postData = json_decode($request->getContent(), true);

        $objHomeService = $this->get("app.service_home");
        $objHomeService->createUser($postData);

        $objUsers = $objHomeService->getUsers();

        // Convertir el array asociativo a JSON y retornarlo como respuesta
        return new JsonResponse($objUsers);
    }

    public function updateUserAction(Request $request, $id)
    {
        // Recuperar los datos enviados en la solicitud
        $data = json_decode($request->getContent(), true);
        $objHomeService = $this->get("app.service_home");
        // Llamar al método en el servicio para actualizar el post
        $updatedPost = $objHomeService->updateUser($id, $data);

        return new JsonResponse($updatedPost);
    }


    public function deleteUserAction($id)
    {
        $objHomeService = $this->get("app.service_home");
        try {
            $objHomeService->deleteUser($id);
            return new Response('User eliminado.', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    public function softDeleteUserAction($id)
    {
        $objHomeService = $this->get("app.service_home");

        try {
            $objHomeService->softDeleteUser($id);
            return new Response('User eliminado logicamente.', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
