<?php
/*
'+--------------------------------------------------------------------------
'| Frontmedia Kernel
'| 3.2B1
'| =================================================
'| @copyright 2004-2009 Frontmedia Softwares
'| @author Sven Lwyrn Front
'| http://www.frontmedia.it/products/fmk/
'| =================================================
'| @link http://www.frontmedia.it
'| @mail services@frontmedia.it
'+--------------------------------------------------------------------------
'|
'|  - Designed for php 4.x
'|  - @package fm.kernel
'|  - @class   kernel_errors
'|  - @version 1.0
'|  - @since   06/14/2004 10:30PM
'|
'+--------------------------------------------------------------------------
*/

class SystemErrors
{
    public static $ERROR_STRING_DEPENDENCE_RECURSION = 'A driver can\'t depend by itself. Driver: %s; declared dependence: %s' ;
    public static $ERROR_STRING_DEPENDENCE_NOT_FONUD = 'Dpendence not foud <strong>%s</strong> for %s Driver' ;
    public static $ERROR_STRING_INCOMPATIBLE_VERSION = 'The Driver <strong>%s</strong> is not compatible with this version of kernel. Kernel version: %s; Max backward compatibility: %s; Driver Kernel Version: %s; Driver Version: %s' ;
    public static $ERROR_STRING_FILE_NOT_APPEAR_LIKE_A_CLASS = 'File <strong>%s</strong> don\'t appear like a class' ;
    public static $ERROR_STRING_FILE_NOT_FOUND = 'File <strong>%s</strong> not found';
    public static $ERROR_STRING_CANT_RELOAD_CLASS = 'The Driver <strong>%s</strong> is already loaded; Can\'t duplicate it. <em>ALLOW_NUMERIC: %s</em>' ;
    
    public static $ERROR_STRING_CANT_LOAD_LIB = 'Lib Loading Error: Can not load <strong>%s</strong> library' ;
    
    public static $ERROR_CODE_DEPENDENCE_RECURSION = 0x606 ;
    public static $ERROR_CODE_DEPENDENCE_NOT_FONUD = 0x605 ;
    public static $ERROR_CODE_INCOMPATIBLE_VERSION = 0x604 ;
    public static $ERROR_CODE_FILE_NOT_APPEAR_LIKE_A_CLASS = 0x603 ;
    public static $ERROR_CODE_FILE_NOT_FOUND = 0x601 ;
    public static $ERROR_CODE_CANT_RELOAD_CLASS = 0x602 ;
    
    public static $ERROR_CODE_CANT_LOAD_LIB = 0x611 ;
    /**
     * Error code snippets adding lines
     * @access private
     * @var int
     */
    private $snippets_adding_lines = 8 ;
    
    /**
     * PHP Vars Highligt CSS-Class
     * @access public
     * @var int
     */
    public $php_highlight_variables_class = 'php-highlight-variables' ;
    
    /**
     * PHP Strings Highligt CSS-Class
     * @access public
     * @var int
     */
    public $php_highlight_strings_class = 'php-highlight-strings' ;
    
    /**
     * PHP Numbers Highligt CSS-Class
     * @access public
     * @var int
     */
    public $php_highlight_number_class = 'php-highlight-number' ;
    
    /**
     * PHP Keywords Highligt CSS-Class
     * @access public
     * @var int
     */
    public $php_highlight_keywords_class = 'php-highlight-keywords' ;
    
    /**
     * PHP Open/Close Tag Highligt CSS-Class
     * @access public
     * @var int
     */
    public $php_highlight_openclose_class = 'php-highlight-openclose' ;
    /**
     * Error Type IDs
     * @access public
     * @var int
     */
    private $errors_ids = array ( ) ;
    
    /**
     * Return Only
     * @access private
     * @var bool
     */
     private $return_only = false ;
     
     private $is_eval_error = false ;
     private $block_eval_code = false ;
     
     public $last_eval_code ;
    
    /*-------------------------------------------------------------------------*/
    // fmkernel constructor
    /*-------------------------------------------------------------------------*/

   /**
    * Kernel Errors Constructor
    *
    * @since  v 1.0
    * @access public
    *
    * @return self
    */

    public function __construct( )
    {
        $this->errors_ids = array
        (
            E_WARNING       => 'Parse Error',
            E_NOTICE        => 'Notice',
            E_ERROR         => 'Fatal Error',
            E_COMPILE_ERROR => 'Compile Fatal Error',
            E_PARSE         => 'Parse Error'
        ) ;
    }
    
    /*-------------------------------------------------------------------------*/
    // fmkernel constructor
    /*-------------------------------------------------------------------------*/

   /**
    * Kernel Errors Constructor
    *
    * @since  v 1.0
    * @access public
    *
    * @return self
    */
    
    public function onDriverLoadingError ( KernelEvents $event )
    {
        if ( ! $event->forceError )
            return $this->warning ( $event->errorCode, $event->errorString, 'Kernel', 'undefined' ) ;
        else
            return $this->fatal ( $event->errorCode, $event->errorString, 'Kernel', 'undefined' ) ;
    }
    
    public function onGlobalError ( $error_code, $error_string, $error_file, $error_line, $return_only = false )
    {
        $this->return_only = $return_only ;
        
        $eval_line_number = 0 ;
        
        $this->check_eval_error ( $error_file ) ;
        
        switch ( $error_code )
        {
          
            case E_WARNING:
                return $this->fatal ( $error_code, $error_string, $error_file, $error_line ) ;
            break;
            
            case E_NOTICE:
                return $this->warning ( $error_code, $error_string, $error_file, $error_line ) ;
            break;
            
            case E_ERROR:
                return $this->fatal ( $error_code, $error_string, $error_file, $error_line ) ;
            break;
            
            case E_COMPILE_ERROR:
                return $this->fatal ( $error_code, $error_string, $error_file, $error_line ) ;
            break;
            
            default:
                return $this->fatal ( $error_code, $error_string, $error_file, $error_line ) ;
            break ;
        }
    }
    
    private function check_eval_error ( $error_string )
    {
        $match_data = array ( ) ;
        if ( preg_match ( '/\([0-9]+\)\ \:\ eval\(\)\'d code$/i', $error_string, $match_data ) )
        {
            $this->is_eval_error = true ;
            $this->block_eval_code = true ;
        }
    }
    
    private function warning ( $error_code, $error_string, $error_file, $error_line )
    {
        $errorstring  = '<div id="php-fmk-error">' ;
        $errorstring .= '<strong>AneCMS Error</strong> ' ;
        $errorstring .= '[' . $error_code . '] ' ;
        $errorstring .= 'in the file <strong>' . $error_file . '</strong> ' ;
        $errorstring .= 'on line <strong>' . $error_line . '</strong> ' ;
        $errorstring .= '<br />' . $error_string ;
        $errorstring .= "</div>\n" ;
        $errorstring .= $this->get_error_lines ( $error_file, $error_line ) ;
        $this->spawn_error ( $errorstring ) ;
    }
    
    private function fatal ( $error_code, $error_string, $error_file, $error_line )
    {
      global $debug;
        $code_snippets = $this->get_error_lines ( $error_file, $error_line ) ;
        $error_type = isset ( $this->errors_ids[$error_code] ) ? $this->errors_ids[$error_code] : 'Unknown Error' ;
        $ERRORDATA = '
         <style type="text/css">
          body
          {
              background-color: #fafafa;
              font-family: Verdana, Arial, Georgia, sans-serif;
              font-size: 12px;
              text-align: center ;
              margin:0;
              padding:0;
          }
          a,
          a:link,
          a:visited
          {
              color: #286d23;
              text-decoration: none;
          }
          a:hover
          {
              text-decoration: underline ;
          }
          #errorwrap
          {
              margin: 30px auto 30px auto ;
              width: 90%;
              border: 4px solid #dfdfdf;
              background-color:#ffffff ;
              padding:0;
          }
          h1
          {
              font-weight: normal ;
              border-bottom: 2px solid #dfdfdf;
              font-size: 16px;
              margin: 0 ;
              padding: 12px ;
              text-align: left ;
              font-weight:bold;
              background-color:#ffffff;
          }
          #errorwrap #error-message
          {
              font-weight: normal;
              font-size: 10px;
              color: #ba140c;
              text-align:left;
              padding: 8px;
          }
          #errorwrap h2
          {
              background-color:#eee;
              width: 100%;
              margin:0;
              padding: 10px 0 10px 0;
              font-size: 10px;
              text-align:center;
              border-top: 4px solid #dfdfdf;
              border-bottom: 4px solid #dfdfdf;
              font-weight:normal;
              color:#a0a0a0;
          }
          #code-lines
          {
              text-align:left;
              margin: 10px;
          }
          #code-lines ul
          {
              list-style: none;
              margin:0;
              padding:0;
          }
          #code-lines li
          {
              font-family: Courier, Serif;
              padding: 3px 6px 3px 6px;
              font-size: 12px;
          }
          #code-lines .line-a
          {
              background-color: #f5f5f5 ;
          }
          #code-lines .line-b
          {
              background-color: #fff ;
          }
          #code-lines .marked
          {
              background-color: #fefad2 ;
              color: #f49c10;
              font-weight: bold;
          }
          #footer-copyright
          {
              color: #666666 ;
          }
          .php-highlight-variables
          {
              color: #800c80;
          }
          .php-highlight-strings
          {
              color: #1001f0;
          }
          .php-highlight-number
          {
              color: #f91c10;
          }
          .php-highlight-keywords
          {
              font-weight: bold ;
          }
          .php-highlight-openclose
          {
              color: #f91c10;
              font-weight: bold;
          }
         </style>
          <h1>AneCMS has generated an error: </h1>
          <div id="errorwrap">
           <div id="error-message">' . $error_type . ' [' . $error_code . ']: ' . $error_string . '</div>
           <h2>The error was occurred on line <strong>' . $error_line . '</strong> in file <strong>'. $error_file . '</strong></h2>
           ' . $code_snippets . '
          </div>
        ';
        
        if ( !$debug )
        {
            //$this->spawn_error ( $ERRORDATA ) ;
            return $ERRORDATA ;
        }
        else
            $this->spawn_error ( $ERRORDATA ) ;
       
        die ( ) ;
    }
    
    private function spawn_error ( $code )
    {
        echo $code ;
    }
    
    private function get_error_lines ( $file, $line )
    {
        $std = '' ;
        $lines = array ( ) ;
        
        if ( ! $this->is_eval_error )
        {
            $filename = array_reverse ( explode ( '/', $file ) ) ;
        
            if ( ! file_exists ( $file ) or $filename[0] == 'config.php' ) return $std ;
        
            $lines = file ( $file ) ;
        }
        else
        {
            $lines = explode ( "\n", $this->last_eval_code ) ;
            $this->block_eval_code = false ;
        }
        
        $startline = min ( count ( $lines ), max ( 1, $line - $this->snippets_adding_lines ) ) ;
        $endline = min ( count ( $lines ), $line + $this->snippets_adding_lines ) ;
        
        $line_highlight_class = 'line-a' ;

        for ( $i = $startline; $i < $endline+1 ; $i++ )
        {
            $line_code = @rtrim ( htmlentities ( $lines[$i-1] ) ) ;
            $line_code = str_replace ( ' ',  '&nbsp;', $line_code ) ;
            $line_code = str_replace ( "\t", '&nbsp;', $line_code ) ;
            $line_code = $this->php_code_highlight ( $line_code ) ;
            
            $line_number = sprintf('%04d', $i) ;
            
            if ( $i != $line )
                $std .= '<li class="' . $line_highlight_class . '"><span class="code-line-number">' . $line_number . '</span> ' . $line_code . '</li>' ;
            else
                $std .= '<li class="marked"><span class="code-line-number">' . $line_number . '</span> ' . $line_code . '</li>' ;
            
            $line_highlight_class = $line_highlight_class == 'line-a' ? 'line-b' : 'line-a' ;
        }
        
        return "<div id=\"code-lines\">\n<ul>\n" . $std . "</ul>\n</div>\n" ;
    }
    
    private function php_code_highlight ( $phpcode )
    {
        $single_quote_string_opened = false ;
        $double_quote_string_opened = false ;
        $in_string = false ;
        $is_keyword = false ;
        $current_keyword = '' ;
        $next_char = '' ;
        $code_length = strlen ( $phpcode ) ;
        
        $newcode = '' ;
        
        $backward_char = '' ;
        
        $keywords = 'interface|implements|extends|if|else|elseif|as|require|require_once|include|include_once|for|foreach|while|do|endwhile|endif' ;
        $keywords .= '|switch|case|default|break|endswitch|return|continue|false|true|function|public|protected|static|const|private' ;
        $keywords .= '|print|echo|array|null' ;
        
        for ( $i = 0 ; $i < $code_length ; $i++ )
        {
            $currentchar = $phpcode{$i} ;
            
            if ( $i < $code_length-1 ) $next_char = $phpcode{$i+1} ;
            
            if ( $currentchar == '"' and ! $double_quote_string_opened and $backward_char != '\\' and ! $single_quote_string_opened )
            {
                $newcode .= "<span class=\"{$this->php_highlight_strings_class}\">" ;
                $newcode .= $currentchar ;
                $double_quote_string_opened = true ;
                $in_string = true ;
            }
            elseif ( $currentchar == '"' and $double_quote_string_opened  and $backward_char != '\\' and ! $single_quote_string_opened )
            {
                $newcode .= $currentchar ;
                $newcode .= '</span>' ;
                $double_quote_string_opened = false ;
                $in_string = false ;
            }
            elseif ( $currentchar == "'" and ! $single_quote_string_opened and $backward_char != '\\' and ! $double_quote_string_opened )
            {
                $newcode .= "<span class=\"{$this->php_highlight_strings_class}\">" ;
                $newcode .= $currentchar ;
                $single_quote_string_opened = true ;
                $in_string = true ;
            }
            elseif ( $currentchar == "'" and $single_quote_string_opened  and $backward_char != '\\' and ! $double_quote_string_opened )
            {
                $newcode .= $currentchar ;
                $newcode .= '</span>' ;
                $single_quote_string_opened = false ;
                $in_string = false ;
            }
            elseif ( ! $in_string and is_numeric ( $currentchar ) )
            {
                $newcode .= "<span class=\"{$this->php_highlight_number_class}\">$currentchar</span>" ;
            }
            elseif ( ! $in_string and $currentchar == '.' and is_numeric ( $backward_char ) and is_numeric ( $next_char ) )
            {
                $newcode .= "<span class=\"{$this->php_highlight_number_class}\">$currentchar</span>" ;
            }
            else
            {
                $newcode .= $currentchar ;
            }
            
            $backward_char = $currentchar ;
        }

        $newcode = preg_replace ( '/(\&nbsp\;)(' . $keywords . ')/i', "<span class=\"{$this->php_highlight_keywords_class}\">$0</span>", $newcode ) ;
        $newcode = preg_replace ( '/^(' . $keywords . ')/i', "<span class=\"{$this->php_highlight_keywords_class}\">$0</span>", $newcode ) ;
        $newcode = preg_replace ( '/\&lt\;\?(php)?/i', "<span class=\"{$this->php_highlight_openclose_class}\">$0</span>", $newcode ) ;
        $newcode = preg_replace ( '/\?&gt;/i', "<span class=\"{$this->php_highlight_openclose_class}\">$0</span>", $newcode ) ;
        $newcode = preg_replace ( '/([\\$]{1,2}[a-zA-Z_][a-zA-Z0-9_]*)/', "<span class=\"{$this->php_highlight_variables_class}\">$0</span>", $newcode ) ;
        
        return $newcode ;
    }
    
    public function setEvalCode ( $evalcode )
    {
        if ( ! $this->block_eval_code )
        {
            $this->last_eval_code = $evalcode ;
        }
        return true ;
    }
}

?>