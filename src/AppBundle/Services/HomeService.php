<?php

namespace AppBundle\Services;

use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomeService
{

    private $objEm;

    public function setDependencies(ContainerInterface $container)
    {
        $this->objEm = $container->get("doctrine.orm.entity_manager");
    }

    public function getUsers()
    {
        $objUserRepo = $this->objEm->getRepository('AppBundle:User');
        $arrUsers = $objUserRepo->findAll();

        return $arrUsers;
    }

    public function createUser($parametros)
    {
        $entityNewUser = new User();
        $entityNewUser->setName($parametros['name']);
        $entityNewUser->setUsername($parametros['username']);
        $entityNewUser->setPassword($parametros['password']);
        $entityNewUser->setAge($parametros["age"]);
        $entityNewUser->setStatus($parametros["status"]);

        $this->objEm->persist($entityNewUser);
        $this->objEm->flush();
    }

    public function updateUser($id, $parametros)
    {
        // Recuperar el repositorio de la entidad Post
        $objUserRepo = $this->objEm->getRepository('AppBundle:User');

        // Recuperar el post existente por su ID
        $entityUpdateUser = $objUserRepo->find($id);

        // Verificar si el post existe
        if (!$parametros) {
            throw new NotFoundHttpException('No se encontró el post con el ID proporcionado.');
        }

        // Actualizar los datos del post
        $entityUpdateUser->setName($parametros['name']);
        $entityUpdateUser->setUsername($parametros['username']);
        $entityUpdateUser->setPassword($parametros['password']);
        $entityUpdateUser->setAge($parametros["age"]);
        $entityUpdateUser->setStatus($parametros["status"]);

        // Guardar los cambios en la base de datos
        $this->objEm->flush();

        return $entityUpdateUser;
    }


    public function deleteUser($id)
    {
        $objUserRepo = $this->objEm->getRepository('AppBundle:User');

        $objUser = $objUserRepo->find($id);
        if (!$objUser) {
            throw new \Exception('User not found.');
        }

        $this->objEm->remove($objUser);
        $this->objEm->flush();

        return "se eliminó el registro"; // Opcional: puede devolver un indicador de éxito
    }

    public function softDeleteUser($id)
    {
        $objUserRepo = $this->objEm->getRepository(User::class);
        $objUser = $objUserRepo->find($id);

        if (!$objUser) {
            throw new \Exception('User not found.');
        }

        // Actualizar el estado del usuario a "I" (inactivo)
        $objUser->setStatus('I');
        $this->objEm->flush();

        return "eliminación lógica"; // Opcional: puede devolver un indicador de éxito
    }


    public function getUsersByQueryBuilder()
    {
        $objUserRepo = $this->objEm->getRepository('AppBundle:User');
        $arrUsers = $objUserRepo->getUsersByQueryBuilder();

        return $arrUsers;
    }


    public function getUsersByNativeQuery()
    {
        $objUserRepo = $this->objEm->getRepository('AppBundle:User');
        $arrUsers = $objUserRepo->getUsersByNativeQuery();

        return $arrUsers;
    }

    public function getUsersByDQL()
    {
        $objUserRepo = $this->objEm->getRepository('AppBundle:User');
        $arrUsers = $objUserRepo->getUsersByDQL();

        return $arrUsers;
    }
}
