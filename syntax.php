<?php
/**
 * Plugin hiddenSwitch: Enable to hide details
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author   Guillaume Turri <guillaume.turri@gmail.com>
 */

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

class syntax_plugin_hiddenSwitch extends DokuWiki_Syntax_Plugin {

  function getType(){ return 'substition'; }
  function getSort(){
    //Make sure it's lower than the one of the plugin hidden, to avoid confusion between "<hidden.*" and <hiddenSwitch.*"
    return 188;
  }

  function connectTo($mode) {
    $this->Lexer->addSpecialPattern('<hiddenSwitch[^>]*>', $mode,'plugin_hiddenSwitch');
  }

  function handle($match, $state, $pos, Doku_Handler $handler) {
      $return = array('text' => $this->getLang('default'));
      $match = trim(utf8_substr($match, 14, -1)); //14 = strlen("<hiddenSwitch ")
      if ( $match !== '' ){
          $return['text'] = $match;
      }
      $return['text'] = htmlspecialchars($return['text']);
      return $return;
  } // handle()

  function render($mode, Doku_Renderer $renderer, $data) {
    if($mode == 'xhtml'){
        $renderer->doc .= '<input type="button" class="button hiddenSwitch" value="' . $data['text'] . '" />';
      return true;
    }

    return false;
  } // render()

} // class syntax_plugin_nspages
