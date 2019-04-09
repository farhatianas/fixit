<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;

class RoleController extends Controller
{
    public function showAction()
    {
        // Fetching Objects (users) from the Database
        $users =$this->getDoctrine()->getRepository(User::class)->findAll();
        //add the list of users to the render function as input to be sent to the view
        return $this->render('@Forum/Roles/ShowForumRoles.html.twig', array(
            'users' => $users
        ));
    }

    public function addRoleSpectatorAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userManager = $this->get('fos_user.user_manager');
        $user->addRole('ROLE_SPECTATOR');
        $userManager->updateUser($user);
        return $this->showAction();
    }

    public function removeRoleSpectatorAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userManager = $this->get('fos_user.user_manager');
        $user->removeRole('ROLE_SPECTATOR');
        $userManager->updateUser($user);
        return $this->showAction();
    }


    public function addRoleParticipantAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userManager = $this->get('fos_user.user_manager');
        $user->addRole('ROLE_PARTICIPANT');
        $userManager->updateUser($user);
        return $this->showAction();
    }

    public function removeRoleParticipantAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userManager = $this->get('fos_user.user_manager');
        $user->removeRole('ROLE_PARTICIPANT');
        $userManager->updateUser($user);
        return $this->showAction();
    }


    public function addRoleModeratorAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userManager = $this->get('fos_user.user_manager');
        $user->addRole('ROLE_MODERATOR');
        $userManager->updateUser($user);
        return $this->showAction();
    }

    public function removeRoleModeratorAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userManager = $this->get('fos_user.user_manager');
        $user->removeRole('ROLE_MODERATOR');
        $userManager->updateUser($user);
        return $this->showAction();
    }


    public function addRoleKeyMasterAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userManager = $this->get('fos_user.user_manager');
        $user->addRole('ROLE_KEYMASTER');
        $userManager->updateUser($user);
        return $this->showAction();
    }

    public function removeRoleKeyMasterAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userManager = $this->get('fos_user.user_manager');
        $user->removeRole('ROLE_KEYMASTER');
        $userManager->updateUser($user);
        return $this->showAction();
    }
}
