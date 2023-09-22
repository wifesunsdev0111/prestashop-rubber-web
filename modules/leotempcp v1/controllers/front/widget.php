<?php 

	class leotempcpwidgetModuleFrontController extends ModuleFrontController
	{
		public function init() {
			parent::init();

			  require_once( $this->module->getLocalPath().'leotempcp.php' );
		}

		public function initContent()
		{
			parent::initContent();
	 		$module = new Leotempcp();
	 		echo $module->renderwidget();
			die;
		}
	}
?>