<?php
use Phalcon\Mvc\User\Component;

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */
class Elements extends Component {
	private $_headerMenu = array (
			'navbar-left' => array (
					'index' => array (
							'caption' => 'Home',
							'action' => 'index'
					),
					'invoices' => array (
							'caption' => 'Invoices',
							'action' => 'index'
					),
						
					'peer' => array (
							'caption' => 'Peer',
							'action' => 'index'
					),
					'D_cadastro' => array (
							array (
									'controller' => 'peer',
									'caption' => 'Cadastrar Peer',
									'action' => 'new'
							),
							array (
									'controller' => 'pessoa',
									'caption' => 'Cadastrar Pessoa',
									'action' => 'new'
							),
							array (
									'controller' => 'aluno',
									'caption' => 'Cadastar Aluno',
									'action' => 'new'
							),
							array (
									'controller' => 'professor',
									'caption' => 'Cadastar Profesor',
									'action' => 'new'
							),
							array (
									'controller' => 'turma',
									'caption' => 'Cadastar Turma',
									'action' => 'new'
							),
							array (
									'controller' => 'curso',
									'caption' => 'Cadastar Curso',
									'action' => 'new'
							)
					)
					,
					'D_pesquisar' => array (
							array (
									'controller' => 'peer',
									'caption' => 'Pesquisar Peer',
									'action' => 'search'
							),
							array (
									'controller' => 'pessoa',
									'caption' => 'Pesquisar Pessoa',
									'action' => 'search'
							),
							array (
									'controller' => 'aluno',
									'caption' => 'Pesquisar Aluno',
									'action' => 'search'
							),
							array (
									'controller' => 'professor',
									'caption' => 'Pesquisar Profesor',
									'action' => 'search'
							),
							array (
									'controller' => 'turma',
									'caption' => 'Pesquisar Turma',
									'action' => 'search'
							),
							array (
									'controller' => 'curso',
									'caption' => 'Pesquisar Curso',
									'action' => 'search'
							)
					),
					'about' => array (
							'caption' => 'Sobre',
							'action' => 'index'
					)
			),
			'navbar-right' => array (
					'session' => array (
							'caption' => 'Login',
							'action' => 'index'
					)
			)
	)
	;
	private $_tabs = array (
			'Invoices' => array (
					'controller' => 'invoices',
					'action' => 'index',
					'any' => false
			),
			'Companies' => array (
					'controller' => 'companies',
					'action' => 'index',
					'any' => true
			),
			'Products' => array (
					'controller' => 'products',
					'action' => 'index',
					'any' => true
			),
			'Product Types' => array (
					'controller' => 'producttypes',
					'action' => 'index',
					'any' => true
			),
			'Your Profile' => array (
					'controller' => 'invoices',
					'action' => 'profile',
					'any' => false
			)
	);

	/**
	 * Builds header menu with left and right items
	 *
	 * @return string
	 */
	public function getMenu() {
		$auth = $this->session->get ( 'auth' );
		if ($auth) {
			$this->_headerMenu ['navbar-right'] ['session'] = array (
					'caption' => 'Log Out',
					'action' => 'end'
			);
		} else {
			unset ( $this->_headerMenu ['navbar-left'] ['invoices'] );
		}

		$controllerName = $this->view->getControllerName ();
		foreach ( $this->_headerMenu as $position => $menu ) {
			echo '<div class="nav-collapse">';
			echo '<ul class="nav navbar-nav ', $position, '">';
			foreach ( $menu as $controller => $option ) {
				if (strpos ( $controller, 'D_' ) === false) {
					if ($controllerName == $controller) {
						echo '<li class="active">';
					} else {
						echo '<li>';
					}
					echo $this->tag->linkTo ( $controller . '/' . $option ['action'], $option ['caption'] );
					echo '</li>';
				} else {
					echo '<li class="dropdown">';
					echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $controller . ' <span class="caret"></span></a>';
					echo '<ul class="dropdown-menu">';
					foreach ($option as $opt) {
						echo '<li>'. $this->tag->linkTo ( $opt['controller'] . '/' . $opt ['action'], $opt ['caption'] ) . '</li>';
					}
					echo '</ul>';
					echo '</li>';
				}
			}
			echo '</ul>';
			echo '</div>';
		}
	}

	/**
	 * Returns menu tabs
	 */
	public function getTabs() {
		$controllerName = $this->view->getControllerName ();
		$actionName = $this->view->getActionName ();
		echo '<ul class="nav nav-tabs">';
		foreach ( $this->_tabs as $caption => $option ) {
			if ($option ['controller'] == $controllerName && ($option ['action'] == $actionName || $option ['any'])) {
				echo '<li class="active">';
			} else {
				echo '<li>';
			}
			echo $this->tag->linkTo ( $option ['controller'] . '/' . $option ['action'], $caption ), '</li>';
		}
		echo '</ul>';
	}
}

