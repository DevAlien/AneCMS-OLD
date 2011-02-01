<?php
/**
 * Driver MySQL for database transaction
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
define( 'SQL_CACHE_DIRECTORY', dirname(__FILE__).'/../../tmp/cache/sql' );
define('DRIVERNAME', 'MySQL');

global $nquery, $ncached_query, $sql_debug;
$nquery = 0;
$ncached_query = 0;
$sql_debug = true;

/**
 * Driver MySQL for database transaction
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class DBDriver {


	const QUERY = 'query';
	const ALIST = 'list';
	const AARRAY = 'array';
	const COUNT = 'count';
	const LASTID = 'lastid';
    /**
     * meter of functions
     *
     * @var integer
     */
    private $sql_function_level = 0;

    /**
     * Executed query
     *
     * @var string
     */
    private $queries = "<div style=\"background-color:#f8f8ff; border: 1px solid #aaaaff; padding:10px; text-align: left;\">";

    /**
     * Make a connection with the database
     *
     * @param string $hostname Server SQL
     * @param string $username Name of User SQL
     * @param string $password Password of User SQL
     * @param string $database Name of Database SQL
     * @return boolean
     */
    public function __construct( $hostname, $username, $password, $database, $persistent = false ) {
        if($persistent == true) {
            $this->db_link = mysql_pconnect( $hostname, $username, $password ) or die( mysql_error() );
            return mysql_select_db( $database ) or die ( mysql_error() );
        }
        else {
            $this->db_link = mysql_connect( $hostname, $username, $password ) or die( mysql_error() );
            return mysql_select_db( $database ) or die ( mysql_error() );
        }
    }
	
	public function query($query, $type = self::QUERY, $parameters = array(), $limit = array(), $cache = false) {
        foreach ($parameters as $param) {
            $param = '\'' . $this->sqlEscape($param) . '\'';
            $query = substr_replace(
                $query, $param, strpos($query, '?'), 1
            );
        }
	if(is_array($limit) && count($limit) > 0){
		$c = 0;
		foreach ($limit as $limits){
			if($c == 0)
				$query	.= ' LIMIT '. $limits;
			else
				$query .= ', '.$limits;
			$c++;	
		}
	}
		switch ($type) {
			case self::QUERY:
				return $this->queryExecute($query);
				break;
			case self::ALIST:
				return $this->queryList($query, $cache);
				break;
			case self::AARRAY:
				return $this->queryArray($query, $cache);
				break;
			case self::COUNT:
				return $this->queryCount($query);
				break;
			case self::LASTID:
				return $this->queryLastId($query);
				break;
			default:
				return 'ERROR';
		}
    }
    /**
     * Make a query
     *
     * @param string $query Query to make
     * @return mixed|trigger_error
     */
    private function queryExecute( $query ) {
        global $nquery, $sql_debug, $debug;
        $this->queries .= "<font style=\"color: orange;\" size=\"-1\">Query: </font><i>$query</i><br>";
        $this->sql_function_level++;
        $nquery++;
        if( $this->result = mysql_query( $query ) or die(mysql_error() . '<br>'. $query) ) {
            $this->sql_function_level = 0;
            return $this->result;
        }
        else if($debug){
            echo $this->trace_error( $query );
            include_once dirname(__FILE__).'/../errors.class.php';
            Errors::saveError(nl2br($this->trace_error( $query ), true), 'query');
        }
        else {
            include_once dirname(__FILE__).'/../errors.class.php';
            Errors::saveError(nl2br($this->trace_error( $query ), true), 'query');
        }

        $this->sql_function_level = 0;
        return false;
    }

    /**
     * Make a query and return an array, example: array( 'name of  field 1' => 'value of field 1', 'name of  field 2' => 'value of field 2' ... 'name of  field n' => 'value of field n' )
     *
     * @param string $query Query to Make
     * @return array
     */
    private function queryArray( $query, $cache = FALSE ) {
        if( $cache AND file_exists( $file_cache = ( SQL_CACHE_DIRECTORY . "/sql_" . ( $hash = md5( $query ) ) . ".php" ) ) ) {
            $this->queries .= "<font style=\"color: green;\" size=\"-1\">Cached Query: </font><i>{$query}</i><br>";
            include_once( $file_cache );
            $GLOBALS[ 'ncached_query' ]++;
            return $GLOBALS[ 'sql_' . $hash ];
        }

        $this->sql_function_level++;
		$result = $this->queryExecute( $query );
        if( $result != false ) {
            $query_array = mysql_fetch_array( $result, MYSQL_ASSOC);

            if( $cache && is_writable(SQL_CACHE_DIRECTORY) ) {
                $fp = fopen ( $file_cache, 'w' );
                fwrite( $fp, $query_array_string = "<?php" . "\n" . "\$GLOBALS['sql_" . $hash . "'] = " . var_export( $query_array, TRUE ) . ";" . "\n?>", strlen( $query_array_string ) );
                fclose( $fp );
                $GLOBALS[ 'ncached_query' ]++;
            }
		return $query_array;
        }
        return false;
    }

    /**
     * Make a query and return an array list, example: array( array row 1, array row 2 ... array row n )
     * Use this function for get n rows, n>1
     *
     * @param string $query Query to Make
     * @return array
     */
    private function queryList( $query, $cache = false ) {

        if( $cache AND file_exists( $file_cache = ( SQL_CACHE_DIRECTORY . "/sql_" . ( $hash = md5( $query ) ) . ".php" ) ) ) {
            $this->queries .= "<font style=\"color: green;\" size=\"-1\">Cached Query: </font><i>{$query}</i><br>";
            include_once( $file_cache );
            $GLOBALS[ 'ncached_query' ]++;
            return $GLOBALS[ 'sql_' . $hash ];
        }

        $this->sql_function_level++;
        if( $result = $this->queryExecute( $query ) ) {
            $query_list = array( );
            while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
                $query_list[ ] = $row;

            if( $cache && is_writable(SQL_CACHE_DIRECTORY) ) {

                $fp = fopen ( $file_cache, 'w' );
                fwrite( $fp, $query_array_string = "<?php" . "\n" . "\$GLOBALS['sql_" . $hash . "'] = " . var_export( $query_list, TRUE ) . ";" . "\n?>", strlen( $query_array_string ) );
                fclose( $fp );
                $GLOBALS[ 'ncached_query' ]++;
            }
            return $query_list;
        }
    }

    /**
     * Make a query and return a number of rows
     *
     * @param string $query Query to Make
     * @return integer
     */
    private function queryCount( $query ) {
        $this->sql_function_level++;
        return mysql_num_rows( mysql_query( $query ) );
    }
    
    private function queryLastId( $query ){
      $this->sql_function_level++;
      $this->queryExecute($query);
      return mysql_insert_id( $this->db_link );
    }

    /**
     * Return the number of Queries
     *
     * @return integer
     */
    public function nQuery( ) {
        return $GLOBALS[ 'nquery' ];
    }

    /**
     * Return the number of Cached queries
     *
     * @return integer
     */
    public function nCachedQuery( ) {
        return $GLOBALS[ 'ncached_query' ];
    }

    /**
     * If the parameter is set delete the cache of the query, else is null delete all cache
     *
     * @param string $query Query to remove from cache
     */
    public function delete_cache( $query = null ) {
        if( $query )
            unlink( SQL_CACHE_DIRECTORY . "/sql_" . ( $hash = md5( $query ) ) . ".php" );
        else if( $cache_files = glob( SQL_CACHE_DIRECTORY . "/*.php" ) )
            foreach( $cache_files as $file_name )
                unlink( $file_name );
    }

    public function executeSqlFile($sql) {
        $query = explode( ";\n", $sql );
		if(count($query) <= 1)
			$query = explode( ";\r", $sql );
        $html = '<div>';
        for( $i=0; $i<count($query);$i++) {
            if( !mysql_query( $query[$i] ) )
                $html .= $query[$i]. ' - <font color="red">ERROR</font><br />';
            else
                $html .= $query[$i] . ' - OK<br />';
            $html .= '</div>';
        }
        return $html;
    }

    /**
     * Get the number of the rows affected on the last query
     * 
     * @return int
     */
    public function affectedRows() {
        return mysql_affected_rows();
    }
    /**
     * Close the connection with the database
     *
     * @return boolean
     */
    public function disconnect( ) {
        return mysql_close( $this->db_link );
    }

    public function sqlEscape($msg) {
        if(get_magic_quotes_gpc())
            return $msg;
        else
            return mysql_real_escape_string($msg);
    }

    public function getQueries(){
        return $this->queries.'</div>';
    }
    
    /**
     * This function make a div with the error
     *
     * @param string $query Query who are the error.
     * @return string
     */
    private function trace_error( $query ) {
        $sql_error = mysql_error();
        $debug_array = debug_backtrace();

        $error_html = "<div style=\"background-color:#f8f8ff; border: 1px solid #aaaaff; padding:10px;\">".
                "<font size=\"-1\">error: </font><font color=red>{$sql_error}</font><br>" . 
                "<font size=\"-1\">query: </font><i>{$query}</i><br><br>" . 
                "<font size=\"-1\">backtrace: </font><br>" .
                "<div style=\"background-color:#ffffff; border: 1px dotted #9999ee; padding: 10px;\">";

        for( $i = $this->sql_function_level; $i < count( $debug_array ); $i++ ) {
            $error_html .= "<font size=\"-1\">file: </font>" . str_replace( $_SERVER[ 'DOCUMENT_ROOT' ], "", $debug_array[ $i ][ 'file' ] ) . "<br>" ;
            if( isset( $debug_array[ $i ][ 'function' ] ) )
                $error_html .= "<font size=\"-1\">function: </font>{$debug_array[ $i ][ 'function' ]}<br>";
            $error_html .= "<font size=\"-1\">line:</font> {$debug_array[ $i ][ 'line' ]}<br><br>";
        }
        $error_html .= "</div></div><br>";
        return $error_html;
    }
	
}
?>
