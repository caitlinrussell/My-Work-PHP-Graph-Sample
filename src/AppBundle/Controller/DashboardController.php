<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\WorkItem;
use AppBundle\Entity\Request;

class DashboardController extends Controller
{
	/**
	* @Route("/dashboard")
	*/

	public function indexAction()
	{
		$user = $_SESSION['upn'];
		$em = $this->getDoctrine();

		$workItems = WorkManager::getWorkItems($user, $em);
		$avatar = PersonManager::getAvatar($user);
		$teamItems = WorkManager::getTeamWorkItems($user, $em);
		$docs = PersonManager::getRecentDocs();

		//$requests = PersonManager::getRequests($user, $em);

		return $this->render(
			'dashboard/dashboard.html.twig',
			array('name' => $_SESSION['given_name'], 'workItems' => $workItems, 'avatar' => $avatar, 'teamItems' => $teamItems, 'docs' => $docs)
		);
	}

	/**
	* @Route("/dashboard/callback")
	*/
	public function callbackAction()
	{
		//We store user name, id, and tokens in session variables
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}

		// Get the authorization code and other parameters from the query string
		// and store them in the session.
		if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['code'])) {
		    if (isset($_GET['admin_consent'])) {
		        $_SESSION['admin_consent'] = $_GET['admin_consent'];
		    }
		    if (isset($_GET['code'])) {
		        $_SESSION['code'] =  $_GET['code'];
		    }
		    if (isset($_GET['session_state'])) {
		        $_SESSION['session_state'] =  $_GET['session_state'];
		    }
		    if (isset($_GET['state'])) {
		        $_SESSION['state'] =  $_GET['state'];
		    }
		    
		    // With the authorization code, we can retrieve access tokens and other data.
		    try {
		        AuthenticationManager::acquireToken();
		        header('Location: /dashboard');
		        exit();
		    } catch (\RuntimeException $e) {
		        echo 'Something went wrong, couldn\'t get tokens: ' . $e->getMessage();
		    }
		}
		return $this->render('dashboard/callback.html.twig');
	}

	/**
	* @Route("/dashboard/create", name="create")
	*/
	public function createAction()
	{
		//Create a new work item in the database
		$workItem = new WorkItem();
		$workItem->setDescription($_POST['description']);
		$workItem->setStatus("active");
		$workItem->setUser($_SESSION['upn']);
		$workItem->setCreatedAt(new \DateTime('now'));

		$file = $_POST['file-addition'];
		$file = explode('.', $file);

		// Set the file title and type by separating the extension from the filename
		$workItem->setFileType($file[1]);
		$workItem->setDocTitle($file[0]);

		//Persist the object to the database
		$em = $this->getDoctrine()->getManager();
		$em->persist($workItem);
		$em->flush();

		//Return to the dashboard
		header('Location: /dashboard');
		exit();
	}

	/**
	* @Route("/dashboard/complete", name="close")
	*/
	public function completeAction()
	{
		$em = $this->getDoctrine()->getManager();

		//Find the selected work item
		$workItem = $this->getDoctrine()
					->getRepository('AppBundle:WorkItem')
					->find($_POST['id']);

		$workItem->setStatus('complete');

		//Save to the db
		$em->persist($workItem);
		$em->flush();

		//Return successful json response
		$response = array("code" => 100, "success" => true);
		return new Response(json_encode($response));
	}
}