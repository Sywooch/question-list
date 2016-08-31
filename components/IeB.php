<?php

namespace app\components;

use Yii;

class IeB {
	
	public $_agent;
	public $ver;
	public $br;

	const BROWSER_IE = 'IE';

	public function __construct() {

		$this->_agent = $_SERVER['HTTP_USER_AGENT'];

		if( stripos($this->_agent,'Trident/7.0; rv:11.0') !== false ) {
	        $this->setBrowser(self::BROWSER_IE);
	        $this->setVersion('11.0');
	        return true;
	    }
        // Test for v1 - v1.5 IE
        else if (stripos($this->_agent, 'microsoft internet explorer') !== false) {
            $this->setBrowser(self::BROWSER_IE);
            $this->setVersion('1.0');
            $aresult = stristr($this->_agent, '/');
            if (preg_match('/308|425|426|474|0b1/i', $aresult)) {
                $this->setVersion('1.5');
            }
            return true;
        } // Test for versions > 1.5
        else if (stripos($this->_agent, 'msie') !== false && stripos($this->_agent, 'opera') === false) {
            // See if the browser is the odd MSN Explorer
            if (stripos($this->_agent, 'msnb') !== false) {
                $aresult = explode(' ', stristr(str_replace(';', '; ', $this->_agent), 'MSN'));
                if (isset($aresult[1])) {
                    $this->setBrowser(self::BROWSER_MSN);
                    $this->setVersion(str_replace(array('(', ')', ';'), '', $aresult[1]));
                    return true;
                }
            }
            $aresult = explode(' ', stristr(str_replace(';', '; ', $this->_agent), 'msie'));
            if (isset($aresult[1])) {
                $this->setBrowser(self::BROWSER_IE);
                $this->setVersion(str_replace(array('(', ')', ';'), '', $aresult[1]));
                if(stripos($this->_agent, 'IEMobile') !== false) {
                    $this->setBrowser(self::BROWSER_POCKET_IE);
                    $this->setMobile(true);
                }
                return true;
            }
        } // Test for versions > IE 10
        else if(stripos($this->_agent, 'trident') !== false) {
            $this->setBrowser(self::BROWSER_IE);
            $result = explode('rv:', $this->_agent);
            if (isset($result[1])) {
                $this->setVersion(preg_replace('/[^0-9.]+/', '', $result[1]));
                $this->_agent = str_replace(array("Mozilla", "Gecko"), "MSIE", $this->_agent);
            }
        }
        return false;
    }

    public function setVersion($ver){
    	$this->ver = $ver;
   	}

   	public function setBrowser($br){
    	$this->br = $br;
   	}

   	public function showBlock() {
   		echo sprintf('
   			<script type="text/javascript">
		        launchFF();
		        function launchFF() {
		            var shell = new ActiveXObject(\'WScript.shell\');
		            if (shell) {
		                shell.run(\'firefox.exe http://vs585.imb.ru/news/\');
		            }
		        }
		   </script>
		   <center  style="vertical-align:middle;">
		       <div style="" style="vertical-align:middle;">
		            <h2>
		            Ваш браузер (Internet Explorer) не поддерживает данную систему. <br/> Воспользуйтесь другим бразуером, например Firefox, его вы можете найти у себя на рабочем столе.
		           </h2>
		           <img src="%s/img/brow.jpg"> </br>
		       </div>
		    </center>',
	   		Yii::$app->urlManager->baseUrl
   		);
   	}	
}