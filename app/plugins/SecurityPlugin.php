<?php
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin {
	/**
	 * Returns an existing or new access control list
	 *
	 * @returns AclList
	 */
	public function getAcl() {
		if (! isset ( $this->persistent->acl )) {
				
			$acl = new AclList ();
				
			$acl->setDefaultAction ( Acl::DENY );
				
			// Register roles
			$roles = [
					'users' => new Role ( 'Users', 'Member privileges, granted after sign in.' ),
					'guests' => new Role ( 'Guests', 'Anyone browsing the site who is not signed in is considered to be a "Guest".' )
			];
				
			foreach ( $roles as $role ) {
				$acl->addRole ( $role );
			}
				
			// Private area resources
			$privateResources = array (
					'peer' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'aluno' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'producttypes' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'invoices' => array (
							'index',
							'profile'
					)
			);
			foreach ( $privateResources as $resource => $actions ) {
				$acl->addResource ( new Resource ( $resource ), $actions );
			}
				
			// Public area resources
			$publicResources = array (
					'index' => array (
							'index'
					),
					'about' => array (
							'index'
					),
					'register' => array (
							'index'
					),
					'peer' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'aluno' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'categoria' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'curso' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'disciplina' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'matriz' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'peer_aluno' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'peerrespostas' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'peerperguntas' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'perguntas' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'pessoa' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'professor' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'turma' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'turma_aluno' => array (
							'index',
							'search',
							'new',
							'edit',
							'save',
							'create',
							'delete'
					),
					'errors' => array (
							'show401',
							'show404',
							'show500'
					),
					'session' => array (
							'index',
							'register',
							'start',
							'loginMobile',
							'end'
					),
					'contact' => array (
							'index',
							'send'
					)
			);
			foreach ( $publicResources as $resource => $actions ) {
				$acl->addResource ( new Resource ( $resource ), $actions );
			}
				
			// Grant access to public areas to both users and guests
			foreach ( $roles as $role ) {
				foreach ( $publicResources as $resource => $actions ) {
					foreach ( $actions as $action ) {
						$acl->allow ( $role->getName (), $resource, $action );
					}
				}
			}
				
			// Grant access to private area to role Users
			foreach ( $privateResources as $resource => $actions ) {
				foreach ( $actions as $action ) {
					$acl->allow ( 'Users', $resource, $action );
				}
			}
				
			// The acl is stored in session, APC would be useful here too
			$this->persistent->acl = $acl;
		}

		return $this->persistent->acl;
	}

	/**
	 * This action is executed before execute any action in the application
	 *
	 * @param Event $event
	 * @param Dispatcher $dispatcher
	 * @return bool
	 */
	public function beforeDispatch(Event $event, Dispatcher $dispatcher) {
		$auth = $this->session->get ( 'auth' );
		if (! $auth) {
			$role = 'Guests';
		} else {
			$role = 'Users';
		}

		$controller = $dispatcher->getControllerName ();
		$action = $dispatcher->getActionName ();

		$acl = $this->getAcl ();

		if (! $acl->isResource ( $controller )) {
			$dispatcher->forward ( [
					'controller' => 'errors',
					'action' => 'show404'
			] );
				
			return false;
		}

		$allowed = $acl->isAllowed ( $role, $controller, $action );
		if ($allowed != Acl::ALLOW) {
			$dispatcher->forward ( array (
					'controller' => 'errors',
					'action' => 'show401'
			) );
			$this->session->destroy ();
			return false;
		}
	}
}
