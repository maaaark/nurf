<?php

// INCLUDES
include 'system/tmpl_conditions.class.php';
include 'system/tmpl_operators.class.php';

class Template {
    private $template;
    private $assign_replace;
    private $assign_replacement;
    
    private $status_diplay;
    private $status_diplay_file;
    
    // $assigns zum Array machen
    public function __construct() {
        $this->assign_replace     = array();
        $this->assign_replacement = array();
        
        $this->loadBasics();
    }
    
    // Template-Datei laden und in $template speichern
    public function load($file, $global_template = false, $bbcode = false){
        $this->template = file_get_contents(ROOT."/templates/".$file.".tpl");
        
        if(defined("CURRENT_MODULE") && CURRENT_MODULE != "" && $global_template == false){
            $this->template = file_get_contents(ROOT."/parser/".CURRENT_MODULE."/templates/".$file.".tpl");
        } else {
            $this->template = file_get_contents(ROOT."/templates/".$file.".tpl");
        }

        if($bbcode){
           $system = new MediaBaseCore;
           $this->template = $system->bbcode(utf8_encode($this->template));
        }

        $array_inc = array();;
        $pattern = '~\{include (.*)\}~USs';
        preg_match_all($pattern, $this->template, $array_inc);
        
        for($i = 0; $i<count($array_inc[0]); $i++){
           if(isset($array_inc[0][$i])&&isset($array_inc[1][$i])){
              if(file_exists("templates/".$array_inc[1][$i].".tpl")){
                 $con = file_get_contents("templates/".$array_inc[1][$i].".tpl");
                 $this->template = str_replace($array_inc[0][$i], $con, $this->template);
              } else {
                 $this->template = str_replace($array_inc[0][$i], "Fehler: Template-Include nicht gefunden", $this->template);
              }
           }
        }
    }
    
    // Template-Funktionen zu $assigns hinzuf�gen
    public function assign($replace, $replacement){
        $count = count($this->assign_replace);
        if($count == 0){
            $count = 0;
        } elseif($count == 1){
            $count = 1;
        }
        
        $this->assign_replace[$count]       = $replace;
        $this->assign_replacement[$count]   = $replacement;
    }
    
    // Operatoren-Liste
    public function operators(){
        $tmpl = $this->template;
        //$tmpl = $this->load_operators($tmpl, "news");
        return $tmpl;
    }
    
    // Template-Operatoren zu $assign_operatoren hinzuf�gen
    public function load_operators($template, $modul){
        $operator_class = new tmpl_operators;
        $operator = $operator_class->load_data($template, $modul);
        return $operator;
    }
    
    // Ersetzen Funktion aufrufen + Ergebnis ausgeben
    public function display($content = false, $file = false){
        $this->status_diplay = $content;
        $this->status_diplay_file = $file;
        
        if($content == true){
            if($file == false){
               $file = "design";
            }
            $design_data = file_get_contents("templates/".$file.".tpl");
            $this->template = str_replace("{CONTENT}", $this->template, $design_data);
            
            $this->replace_assigns();
            $this->conditions();
            return $this->template;
        } else {
            $this->replace_assigns();
            $this->conditions();
            return $this->template;
        }
    }
    
    // In $template nach Funktionen suchen und diese ersetzen
    public function replace_assigns(){
        $count = count($this->assign_replace);
        for($i=0; $i<=$count; $i++){
            @$this->template = str_replace("{".$this->assign_replace[$i]."}", $this->assign_replacement[$i], $this->template);
        }
    }
    
    public function conditions(){
        $conditions_class = new template_conditions;
        $conditions_load = $conditions_class->load_data($this->template, $this->assign_replace, $this->assign_replacement);
        $this->template = $conditions_load;
    }
    
    public function loadBasics(){
        $this->assign("ROOT", ROOT);
        $this->assign("DOMAIN", DOMAIN);
    }
}
?>