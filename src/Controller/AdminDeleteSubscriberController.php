<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDeleteSubscriberController extends AbstractController
{
    /**
     * @Route("/admin/subscription/delete/{email}", name="admin_delete_subscriber")
     */
    public function delete($email)
    {
	    $filename = getcwd().'/../data/Registrations.json';
	    $registrations = json_decode(file_get_contents($filename), true);
	    unset($registrations[$email]);
	    $data = json_encode($registrations);
	    file_put_contents($filename, $data);
	    $this->addFlash(
		    'notice',
		    'Subscription was deleted'
	    );
	    return $this->redirectToRoute( 'admin_subscribers_list' );
    }
}
