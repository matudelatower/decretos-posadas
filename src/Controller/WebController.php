<?php

namespace App\Controller;

use App\Entity\Decreto;
use App\Form\BuscarDecretoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WebController extends AbstractController {
	/**
	 * @Route("/", name="web_index")
	 */
	public function index( Request $request ) {
		$em = $this->getDoctrine();

		$decretos           = [];
		$decretosDestacados = $em->getRepository( Decreto::class )->findBy( [ 'destacado' => true ] );

		$form = $this->createForm( BuscarDecretoType::class,
			[],
			[ 'method' => 'GET', 'attr' => [ 'role' => 'search' ] ] );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() ) {
			$data = $form->getData();


			$resultados = $em->getRepository( Decreto::class )->buscarDecretos( $data );

			$decretos = $resultados->getQuery()
			                       ->getResult();
		}

		return $this->render( 'web/index.html.twig',
			[
				'titulo'             => 'Inicio',
				'form'               => $form->createView(),
				'decretos'           => $decretos,
				'decretosDestacados' => $decretosDestacados,
			] );
	}

	/**
	 * @Route("/ver_decreto/{decreto}", name="web_ver_decreto")
	 */
	public function verDecreto( Decreto $decreto ) {

		$titulo = 'Decreto Nº ' . $decreto->getNumero();

		return $this->render( 'web/ver_decreto.html.twig',
			[
				'titulo'  => $titulo,
				'decreto' => $decreto
			] );
	}

}
