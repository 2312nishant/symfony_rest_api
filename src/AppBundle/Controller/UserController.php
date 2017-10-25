<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get("/user")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/user/{id}")
     */
    public function idAction($id)
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Post("/user")
     */
    public function postAction(Request $request)
    {
        $data = new User();
        $name = $request->get('name');
        $role = $request->get('role');
        if(empty($name) && empty($role)){
            return new View("User and role cannot be empty", Response::HTTP_NOT_FOUND);
        }
        $data->setName($name);
        $data->setRole($role);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("User added Sucessfully ", Response::HTTP_OK);
    }


    /**
     * @Rest\Put("/user/{id}")
     */
    public function updateAction($id,Request $request)
    {
        $data = new User();
        $name = $request->get('name');
        $role = $request->get('role');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if(empty($user))
        {
            return new View("Unable to find record", Response::HTTP_NOT_FOUND);
        }
        elseif(!empty($name) && !empty($role))
        {
            $data->setName($name);
            $data->setRole($role);
            $em->flush();
            return new View("User Updated Successfully", Response::HTTP_OK);
        }
        elseif(empty($name) && !empty($role))
        {
            $data->setRole($role);
            $em->flush();
            return new View("User Updated Successfully", Response::HTTP_OK);
        }
        elseif(!empty($name) && empty($role))
        {
            $data->setName($name);
            $em->flush();
            return new View("User Updated Successfully", Response::HTTP_OK);
        }
        else
        {
            return new View("User and role cannot be Empty", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Rest\Delete("/user/{id}")
     */
    public function deleteAction($id)
    {
        $data = new User();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if ($user === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }else{
            $em->remove($data);
            $em->flush();
            return new View("User Deleted Successfully", Response::HTTP_OK);    
        }

    }



}