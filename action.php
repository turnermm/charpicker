<?php
/**
 * @author: Myron Turner <turnermm03@shaw.ca>  
 * @license GPLv2 (http://www.gnu.org/licenses/gpl2.html)
 * @adds and/or deletes characters in the Special Chars picker  
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

require_once DOKU_PLUGIN.'action.php';

class action_plugin_charpicker extends DokuWiki_Action_Plugin {
     public function register(Doku_Event_Handler $controller) {
      $controller->register_hook('TOOLBAR_DEFINE', 'AFTER', $this, 'check_toolbar');        
    }

     
     public function check_toolbar( &$event, $param) {
       global $lang;
       $title = $lang['qb_chars'];
       $test= array('À','à','Á','á','Â','â','Ã','ã','Ä','ä','A','a','A','a','Å','å','A','a','A','a','Æ','æ','C','c','Ç','ç','C','c','Ò','ò','Ó','ó','Ô','¢','£','¤','¥','€','¦','§','µ','¶','†','‡','·','•','º');
                    
         $add_chars = $this->getConf('chars');  
         if(!$add_chars) {
             $add_chars = '‰';
         }
         $add_chars = str_replace(' ',"",$add_chars);
         $add_chars = explode(',',$add_chars); 
         $del_chars = $this->getConf('del_chars');
         if(!$del_chars) {
             $del_chars = '‰';
         }
         $del_chars = str_replace(' ',"",$del_chars);
         $del_chars = explode(',',$del_chars); 
         
        for($i=0;$i<count($event->data); $i++) {         
            if($event->data[$i]['type']=='picker') { 
                if(preg_match("/$title/i", $event->data[$i]['title'])){               
                     if($this->getConf('del_all')) {
                         $event->data[$i]['list'] =  array();
                      }   
                     else {
                       $event->data[$i]['list'] = array_diff($event->data[$i]['list'],$del_chars);
                     }   
                    $event->data[$i]['list'] = array_merge($event->data[$i]['list'],$add_chars);           
                    break;
                   }
            }
        }
         
     }
    

}

// vim:ts=4:sw=4:et:
