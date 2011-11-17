<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
  /**
   * @Route("/")
   * @Method("GET")
   */
  public function indexAction()
  {
    if (!$this->validateKey())
      return new Response('Wrong API key', 403);

    $em = $this->getDoctrine()->getEntityManager();
    $users = $em->getRepository('ClubUserBundle:User')->findAll();

    $res = array();
    foreach ($users as $user) {
      $res[] = $user->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;
  }

  /**
  /**
   * @Route("/teams", defaults={"start" = null, "end" = null})
   * @Route("/teams/{start}", defaults={"end" = null})
   * @Route("/teams/{start}/{end}")
   * @Method("GET")
   * @Secure(roles="ROLE_USER")
   */
  public function teamsAction($start, $end)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $start = ($start == null) ? new \DateTime(date('Y-m-d 00:00:00')) : new \DateTime($start.' 00:00:00');
    $end = ($end == null) ? new \DateTime(date('Y-m-d 23:59:59', strtotime('+7 day'))) : new \DateTime($end.' 23:59:59');

    $res = array();
    foreach ($this->get('security.context')->getToken()->getUser()->getSchedules() as $schedule) {
      if ($schedule->getFirstDate()->getTimestamp() >= $start->getTimestamp() && $schedule->getFirstDate()->getTimestamp() <= $end->getTimestamp())
        $res[] = $schedule->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));
    $response->headers->set('Access-Control-Allow-Origin', '*');

    return $response;
  }

  /**
   * @Route("/{id}")
   * @Method("GET")
   */
  public function getAction($id)
  {
    return;
    if (!$this->validateKey())
      return new Response('Wrong API key', 403);

    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User', $id);

    $response = new Response($this->get('club_api.encode')->encode($user->toArray()));
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;
  }
}
