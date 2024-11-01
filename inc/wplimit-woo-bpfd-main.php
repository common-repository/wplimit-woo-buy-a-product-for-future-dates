<?php 

require_once( WPLIMIT_PLUG_PATH . 'inc/backend/wplimit-woo-bpfd-product-panel-tab.php');
require_once( WPLIMIT_PLUG_PATH . 'inc/frontend/wplimit-woo-bpfd-front-date-field.php');

class wplimitWooBpfdMain{
	
	public function done_execution(wplimitWooBpfdExecutor $execute){
		$execute->execute();
	}
}

$wplimitWooBpfdMain = new wplimitWooBpfdMain();
$wplimitWooBpfdMain->done_execution(new wplimitWooBpfdPanelTab);
$wplimitWooBpfdMain->done_execution(new wplimitWooBpfdFrontDateField);