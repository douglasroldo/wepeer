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
 * Este é o plugin de segurança que controla que os usuários tenham apenas acesso aos módulos aos quais são atribuídos
 */
class SecurityPlugin extends Plugin {
	/**
	 * Retorna uma lista de controle de acesso existente ou nova
	 *
	 * @returns AclList
	 */
	public function getAcl() {
		if (! isset ( $this->persistent->acl )) {
				
			$acl = new AclList ();
				
			$acl->setDefaultAction ( Acl::DENY );
				
			// Register roles
			$roles = [
					'administradores' => new Role ( 'Administradores', 'Privilégios de membro, concedidos após o login.' ),
					'visitantes' => new Role ( 'Visitantes', 'Qualquer pessoa que navegue no site que não tenha sessão iniciada é considerada uma "Convidado".' )
			];
				
			foreach ( $roles as $role ) {
				$acl->addRole ( $role );
			}
				
			// Recursos da área privada
			$privateResources = array (
					'peer' => array (
							'index','search','new','edit','save','create','delete','reponder'
					),
					'aluno' => array (
							'index','search','new','edit','save','create','delete'
					),
                                        'categoria' => array (
							'index','search','new','edit','save','create','delete'
					),
					'curso' => array (
							'index','search','new','edit','save','create','delete'
					),
					'disciplina' => array (
							'index','search','new','edit','save','create','delete'
					),
					'matriz' => array (
							'index','search','new','edit','save','create','delete'
					),
					'peeraluno' => array (
							'index','search','new','edit','save','create','delete','responder'
					),
					'peerrespostas' => array (
							'index','search','new','edit','save','create','delete'
					),
					'peerperguntas' => array (
							'index','search','new','edit','save','create','delete'
					),
					'perguntas' => array (
							'index','search','new','edit','save','create','delete'
					),
					'pessoa' => array (
							'index','search','new','edit','save','create','delete'
					),
					'professor' => array (
							'index','search','new','edit','save','create','delete'
					),
					'turma' => array (
							'index','search','new','edit','save','create','delete'
					),
					'turma_aluno' => array (
							'index','search','new','edit','save','create','delete'
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
					'errors' => array (
							'show401','show404','show500'
					),
					'session' => array (
							'index','register','start','loginMobile','end'
					),
					'contact' => array (
							'index','send'
					)
			);
			foreach ( $publicResources as $resource => $actions ) {
				$acl->addResource ( new Resource ( $resource ), $actions );
			}
				
			// Conceder acesso a áreas públicas para usuários e convidados
			foreach ( $roles as $role ) {
				foreach ( $publicResources as $resource => $actions ) {
					foreach ( $actions as $action ) {
						$acl->allow ( $role->getName (), $resource, $action );
					}
				}
			}
				
			// Conceder acesso a área privada para usuários
			foreach ( $privateResources as $resource => $actions ) {
				foreach ( $actions as $action ) {
					$acl->allow ( 'Administradores', $resource, $action );
				}
			}
				
			// O acl é armazenado na sessão, APC seria útil aqui também
			$this->persistent->acl = $acl;
		}

		return $this->persistent->acl;
	}

	/**
	 * Esta ação é executada antes de executar qualquer ação na aplicação
	 *
	 * @param Event $event
	 * @param Dispatcher $dispatcher
	 * @return bool
	 */
	public function beforeDispatch(Event $event, Dispatcher $dispatcher) {
		$auth = $this->session->get ( 'auth' );
		if (! $auth) {
			$role = 'Visitantes';
		} else {
			$role = 'Administradores';
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
