<?php
error_reporting(E_ALL ^ E_NOTICE);
class ModRewrite {

  /* V 1.0 
  copyright mac@homac.net
  *
  * This class simulates the work of apache's mod_rewrite function
  * It could be used for servers where the mod_rewrite function isn't enabled
  * The .htaccess or another mod_rewrite rules containing file will be parsed by this class
  * normaly SEO-friendly URLs will return a 404 when mod_rewrite isn't work - but this class works 
  * within the 404 target and simulates the friendly urls, so you don't have to correct your paths  
  *
  *    
  * Requirement: possibilty to set ErrorDocument 404 for your webserver      
  *      
  ****
   * Usage [+]
   ****
   include modrewrite.class.php from your error404.php page
   
    i.e.
    include("classes/modrewrite.class.php");
   
   add the the path to your error document in the .htaccess
   
    i.e.
    ErrorDocument 404 /error404.php
   
   Initialize class - Example
   
    Syntax
      $ModRewrite = new ModRewrite();
    Set Variables
      
      Path to Variable (by default: ./.htaccess)
      
        $ModRewrite->htaccess = "../.htaccess";       //or
        $ModRewrite->htaccess = "/absolute/server-path/to/your/.htaccess";      //...
      
      The Rewrite starts with (returns a needed array with filepath and variables)
      The retrieved Variables will be added by default to the $_REQUEST array
      If you need $_GET more infos can be found furher down 
      
        $todo = $ModRewrite->rewrite();
      
      now the correct pageoutput
      
        if ($todo["include"]) {
          header("HTTP/1.0 200 OK");
          include($todo["include"]);
          exit;
        }
        
      All together:
      
        <?php
          include("classes/modrewrite.class.php");
          $ModRewrite = new ModRewrite();
          $ModRewrite->htaccess = "./.htaccess";
          $todo = $ModRewrite->rewrite();
          if ($todo["include"]) {
            header("HTTP/1.0 200 OK");
            include($todo["include"]);
            exit;
          }
          
          //proceed with 404 message if no rule was found
          ...
          
          echo "404 - Not Found";
          
          ...
      
      Some usefull functions
      
        Debugging, to set before the $ModRewrite->rewrite()
          
          $ModRewrite->debug = true; 
      
        Some Info, after the $ModRewrite->rewrite()
        
          echo $ModRewrite->showInfos();
      
      More Information
      
        If you're using/needing $_GET variables within the redirected file pleas use the following lines for the pageoutput
        
        if ($todo["include"]) {
          header("HTTP/1.0 200 OK");
          $_GET = array_merge($todo["vars"],$_GET);
          include($todo["include"]);
          exit;
        }
      
  ****
   * Usage [-]
   ****/
  var $htaccess = "./.htaccess";
  var $RewriteBase;
  var $currentUrl;
  var $Rules = array();
  var $Redirects = array();
  var $debug = false;
  var $path2check;
  
  
  function ModRewrite() {
    $this->currentUrl = $_SERVER["REQUEST_URI"];
  }
  
  function showInfos() {
    $output = "Path to htaccess: <b>" . $this->htaccess . "</b><br />
      RewriteBase: <b>" . $this->RewriteBase . "</b><br />
      ThisUrl: <b>" . $this->currentUrl . "</b><br />
      Path2Check: <b>" . $this->path2check . "</b><br />
      Debug: <b>" . $this->debug . "</b><br />";
    
    $output .= "RewriteRules:<pre>" . print_r($this->Rules,true) . "</pre>";
    return $output;
  }

  function rewrite() {
    $this->parseHtaccess();
    if (!$this->RewriteBase || !$this->Rules) return false;
    //calculate path
    $this->path2check = str_replace($this->RewriteBase,"",$this->currentUrl);
    //replace ./
    $this->path2check = preg_replace('/^\.\//',"",$this->path2check);
    
    //go through the Rules
    $cntRules = count($this->Rules);
    for ($i=0;$i<$cntRules;$i++) {
      $thisRule = $this->Rules[$i];
      //matching any Rule to current Url??
      
      $onlythepath = parse_url($this->path2check,PHP_URL_PATH);
      if (preg_match('/' . str_replace('/', '\/', $thisRule["expr"]) . '/', $onlythepath)) {
        //parse redirect url
        $red2 = parse_url($thisRule["redirect"]);
	if(isset($red2["query"]))
        	parse_str($red2["query"],$redarr);
	if(isset($redarr) && is_array($redarr))
        	$redqs = array_keys($redarr);
  
  	$checkq = false;
        $tmpurl = preg_replace('/' . str_replace('/', '\/', $thisRule["expr"]) . '/', $thisRule["redirect"], $onlythepath);
        $tmpq = parse_url($tmpurl,PHP_URL_QUERY);
        $tmpp = parse_str($tmpq,$tarr);
        $tarr_k = array_keys($tarr);
        for ($j=0;$j<count($tarr);$j++) {
          if (preg_match("/%{QUERY_STRING}/",$tarr_k[$j])) {
            $checkq = true;
            if ($tarr_k[$j] != "%{QUERY_STRING}") $_REQUEST[str_replace("%{QUERY_STRING}?","",$tarr_k[$j])] = $tarr[$tarr_k[$j]];
          } else {
            $_REQUEST[$tarr_k[$j]] = $tarr[$tarr_k[$j]];
            $qvars[$tarr_k[$j]] = $tarr[$tarr_k[$j]];
          }
        }
        //adding query strings??
        if ($checkq) {
          $uriq = parse_url($this->path2check,PHP_URL_QUERY);
          parse_str($uriq,$uriarr);
          $uriqs = array_keys($uriarr);
          for ($j=0;$j<count($uriqs);$j++) {
            $_REQUEST[$uriqs[$j]] = $uriarr[$uriqs[$j]];
            $qvars[$uriqs[$j]] = $uriarr[$uriqs[$j]];
          }
        }
        if ($thisRule["additional"] == "[R]") {
          if ($red2["scheme"] && $red2["host"]) $target =  $red2["scheme"] . "://" . $red2["host"] . $red2["path"]. ($qvars ? "?" . http_build_query($qvars) : "");
          else $target = $this->RewriteBase . $red2["path"] . ($qvars ? "?" . http_build_query($qvars) : "");
        }
        
        if ($this->debug) {
          $output = "<pre>" . $this->currentUrl . " redirecting to " . $thisRule["redirect"] . "\n\nTrying to ";
          if ($thisRule["additional"] == "[R]") $output .= "redirect to " . $target;
          else $output .= " include " . $red2["path"] . " with these variables\n" . print_r($qvars,true);
          $output .= "</pre>";
          echo print_r($red2);
          echo $output;
        } else {
          if ($thisRule["additional"] == "[R]") header("location: " . $target);
          else {
            $output = array();
            chdir($_SERVER["DOCUMENT_ROOT"] . $this->RewriteBase);
            if (preg_match('/\//',$red2["path"])) {
              chdir($_SERVER["DOCUMENT_ROOT"] . $this->RewriteBase . dirname($red2["path"]));
            }
            return array("include" => $red2["path"],
                         "vars" => $qvars);
            
          }
        }
      }
    }
  }

  function parseHtaccess() {
    if (!file_exists($this->htaccess)) {
      echo "<div>" . $this->htaccess . " wasn't found</div>";
      return false;
    }
    $ha = file($this->htaccess);
		foreach ($ha as $line) {
		  if (preg_match('/^RewriteBase/i',$line)) {
		    $temparr = preg_split('/(\s)+/',$line);
		    $this->RewriteBase = $temparr[1];
		  }
      //increase Rules and Redirects
      if (preg_match('/^RewriteRule/i',$line)) {
        $temparr = preg_split('/(\s)+/',$line);
        //check necessary variables of redirect
        $this->Rules[] = array("expr" => $temparr[1],
                               "redirect" => $temparr[2],
                               "additional" => $temparr[3]);
      } 
    }
  }
}



 
?>
