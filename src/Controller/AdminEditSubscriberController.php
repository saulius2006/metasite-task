<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Registration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AdminEditSubscriberController extends AbstractController
{
    /**
     * @Route("/admin/subscription/edit/{email}", name="admin_edit_subscriber")
     */
    public function edit($email, Request $request, ValidatorInterface $validator)
    {
	    $registration = new Registration();
		$registration->loadByEmail($email);
	    $category = new Category();
	    $form = $this->createFormBuilder( $registration )
	                 ->add( 'name', TextType::class )
	                 ->add( 'email', EmailType::class )
	                 ->add( 'category', ChoiceType::class, [
		                 'choices' => $category->getCategories(),
		                 'multiple' => true,
		                 'expanded' => true,
	                 ] )
	                 ->add( 'save', SubmitType::class, [ 'label' => 'Save' ] )
	                 ->getForm();
	    $form->handleRequest( $request );

	    if ( $form->isSubmitted() && $form->isValid() ) {
		    $registration->save();
		    $this->addFlash(
			    'notice',
			    'Subscription has been updated'
		    );
		    return $this->redirectToRoute( 'admin_subscribers_list' );
	    }

	    return $this->render( 'admin/edit_subscriber.html.twig', [
		    'form' => $form->createView(),
	    ] );
    }
}
