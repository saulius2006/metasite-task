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

class NewsletterSubscribeController extends AbstractController {

	/**
	 * @Route("/", name="newsletter_subscribe")
	 */
	public function index( Request $request, ValidatorInterface $validator ) {
		$registration = new Registration();
		$category = new Category();
		$form = $this->createFormBuilder( $registration )
		             ->add( 'name', TextType::class )
		             ->add( 'email', EmailType::class )
		             ->add( 'category', ChoiceType::class, [
			             'choices' => $category->getCategories(),
			             'multiple' => true,
			             'expanded' => true,
		             ] )
		             ->add( 'save', SubmitType::class, [ 'label' => 'Subscribe to Newsletter' ] )
		             ->getForm();
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$registration->save();
			$this->addFlash(
				'notice',
				'You are subscribed to our Newsletter!'
			);
			return $this->redirectToRoute( 'newsletter_subscribe' );
		}

		return $this->render( 'newsletter_subscribe/index.html.twig', [
			'form' => $form->createView(),
		] );
	}
}
