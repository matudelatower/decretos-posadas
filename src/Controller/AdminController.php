<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Gedmo\Loggable\Entity\LogEntry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends EasyAdminController {

	private $passwordEncoder;

	public function __construct( UserPasswordEncoderInterface $passwordEncoder ) {
		$this->passwordEncoder = $passwordEncoder;
	}

	public function persistUserEntity( $user ) {
		$user->setPassword( $this->passwordEncoder->encodePassword(
			$user,
			$this->request->get( 'user' )['plainPassword']
		) );
		parent::persistEntity( $user );
	}

//
	public function updateUserEntity( $user ) {
		if ( $this->request->get( 'user' ) && $this->request->get( 'user' )['plainPassword'] ) {
			$user->setPassword( $this->passwordEncoder->encodePassword(
				$user,
				$this->request->get( 'user' )['plainPassword']
			) );
		}
		parent::updateEntity( $user );

	}

	public function verCambiosAction() {

		dump( $this->request );
		$entity    = $this->request->query->get( 'entity' );
		$id        = $this->request->query->get( 'id' );
		$className = 'App:' . $entity;
//		dump( $className );
//		exit;
		$cambios = [];

		$em = $this->getDoctrine()->getManager();

		$repo = $em->getRepository( LogEntry::class ); // we use default log entry class

		$object = $em->find( $className, $id );
		$logs   = $repo->getLogEntries( $object );

		return $this->render( 'default/historial_cambios.html.twig',
			[
				'entity'  => $entity,
				'object'  => $object,
				'cambios' => $logs,
				'referer'=> urldecode($this->request->query->get('referer'))
			] );
	}
}
