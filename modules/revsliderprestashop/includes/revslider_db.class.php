<?php
/**
* 2016 Revolution Slider
*
*  @author    SmatDataSoft <support@smartdatasoft.com>
*  @copyright 2016 SmatDataSoft
*  @license   private
*  @version   5.1.3
*  International Registered Trademark & Property of SmatDataSoft
*/

class RevDbEngine
{

    public static $wpdb;
    public $mysqli;
    //$dbh;

    public $prefix;

    public function __construct()
    {
        $this->prefix = _DB_PREFIX_;
    }

    public function realEscape($string)
    {
        return Db::getInstance()->escape($string);
    }

    public function _escape($data)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                if (is_array($v)) {
                    $data[$k] = $this->_escape($v);
                } else {
                    $data[$k] = $this->realEscape($v);
                }
            }
        } else {
            $data = $this->realEscape($data);
        }



        return $data;
    }
    
   
public function prepare( $query, $args ) {
    if ( is_null( $query ) )
        return;
 
    // This is not meant to be foolproof -- but it will catch obviously incorrect usage.
     
 
    $args = func_get_args();
    array_shift( $args );
    // If args were passed as an array (as in vsprintf), move them up
    if ( isset( $args[0] ) && is_array($args[0]) )
        $args = $args[0];
    $query = str_replace( "'%s'", '%s', $query ); // in case someone mistakenly already singlequoted it
    $query = str_replace( '"%s"', '%s', $query ); // doublequote unquoting
    $query = preg_replace( '|(?<!%)%f|' , '%F', $query ); // Force floats to be locale unaware
    $query = preg_replace( '|(?<!%)%s|', "'%s'", $query ); // quote the strings, avoiding escaped strings like %%s
    array_walk( $args, array( $this, 'escape_by_ref' ) );
    return @vsprintf( $query, $args );
}
    public function query($sql)
    {

        //if($query = $this->mysqli->query($sql))
        $query = Db::getInstance()->execute($sql);
        if ($query) {
            return true;
        }

        return false;
    }

    public function update($table, $data, $where = '', $limit = 0, $null_values = false, $use_cache = true, $add_prefix = false)
    {
        $wherestr = '';
        $c = 0;

        $sql = "UPDATE {$table} SET ";

        if (!empty($data)) {
            foreach ($data as $k => $d) {
                if ($c > 0) {
                    $sql .= ', ';
                }

                if (is_string($d)) {
                    $sql .= "$k=\"" . addslashes($d) . "\"";
                } else {
                    $sql .= "$k=$d";
                }

                $c++;
            }
        }

        $sql .= " ";

        $c = 0;

        if (!empty($where) && is_array($where)) {
            $sql .= "WHERE ";

            foreach ($where as $k => $val) {
                if ($c > 0) {
                    $wherestr .= " AND ";
                }

                $wherestr .= "{$k}=";
                if (is_string($val)) {
                    $wherestr .= '"' . $this->_escape($val) . '"';
                } else {
                    $wherestr .= $val;
                }

                $c++;
            }
            $sql .= $wherestr;
        }

//        if(Db::getInstance()->update($table, $this->_escape($data), $wherestr , $limit, $null_values, $use_cache, $add_prefix))
//                return true;
        if (Db::getInstance()->execute($sql)) {
            return true;
        }

        return false;
    }
public function fetchSingle($tableName,$where="",$orderField="",$groupByField="",$sqlAddon=""){
		$response = $this->fetch($tableName, $where, $orderField, $groupByField, $sqlAddon);
		
		if(empty($response))
			$this->throwError("Record not found");
		$record = $response[0]; 
		return($record);
	}
    public function insert($table, $data, $null_values = false, $use_cache = true, $type = 1, $add_prefix = false)
    {
        $c = 0;

        $cols = '';
        $vals = '';

        $sql = "INSERT INTO {$table}";

        if (!empty($data)) {
            $cols .= '(';
            $vals .= ' VALUES(';
            foreach ($data as $k => $d) {
                if ($c > 0) {
                    $cols .= ', ';
                    $vals .= ', ';
                }
                $cols .= $k;

                if (is_string($d)) {
                    //                    $vals .= "\"".addslashes($d)."\"";
                    $vals .= "'" . addslashes($d) . "'";
                } else {
                    $vals .= $d;
                }

                $c++;
            }
            $cols .= ')';
            $vals .= ')';
        }

        $sql .= "{$cols} {$vals}";

        if (Db::getInstance()->execute($sql)) {
            return $this->Insert_ID();
        }

        return false;
    }

    public function Insert_ID()
    {
        return Db::getInstance()->Insert_ID();
    }

    public function get_var($sql, $assoc = false)
    {
        $query = Db::getInstance()->getValue($sql);

        if (!empty($query)) {
            return $query;
        }

        return false;
    }

    public function get_row($sql, $assoc = false)
    {
        $query = Db::getInstance()->getRow($sql);

        if ($query) {
            return $query;
        }

        return false;
    }

    public function getResults($sql, $assoc = false)
    {
        $query = Db::getInstance()->ExecuteS($sql, true, false);

        if (!empty($query)) {
            return $query;
        }

        if (empty($query) && $assoc == ARRAY_A) {
            return array();
        }


        return false;
    }
    public function escape_by_ref( &$string ) {
    if ( ! is_float( $string ) )
        $string = $this->realEscape( $string );
}
public function _real_escape( $string ) {
            return $this->realEscape($string);
    }
    public function delete($table,$where){
		//global $wpdb; 
		RevSliderFunctions::validateNotEmpty($table,"table name");
		RevSliderFunctions::validateNotEmpty($where,"where");
                $where_string="";
                if(!empty($where) && is_array($where)){
            $where_string .= " ";
            $wherestr = '';
        $c = 0; 
            foreach($where as $k => $val){
                if($c > 0)
                    $wherestr .= " AND ";
                
                $wherestr .= "{$k}=";                
                if(is_string($val))
                    $wherestr .= '"'.$this->_escape($val).'"';                    
                else
                    $wherestr .= $val;
                
                $c++;
            }
            $where_string .= $wherestr;
            
        }else{
            $where_string = $where;
        }
		$query = "delete from $table where $where_string";
		
		$this->query($query);
		
		$this->checkForErrors("Delete query error");
	}
    public function fetch($tableName,$where="",$orderField="",$groupByField="",$sqlAddon=""){
            
		//global $wpdb;
		$wpdb = self::rev_db_instance();
		$query = "select * from $tableName";
		if($where) $query .= " where $where";
		if($orderField) $query .= " order by $orderField";
		if($groupByField) $query .= " group by $groupByField";
		if($sqlAddon) $query .= " ".$sqlAddon;
		 
		$response = $this->get_results($query,ARRAY_A);
		
		$this->checkForErrors("fetch");
		
		return($response);
	}
public function get_results($sql, $assoc = false)
    { 
        return $this->getResults($sql,$assoc);
    }
    public function getLastInsertID(){
        return Db::getInstance()->Insert_ID();
    }
    
    public function runSql($query){
		//global $wpdb; 
		$this->query($query);			
		$this->checkForErrors("Regular query error");
	}
    private function checkForErrors($prefix = ""){

            $errno = '';
  
			if(!empty($errno)){

				$message = '';

				$message = '';

				$this->throwError($message);

			}

		}
                private function throwError($message,$code=-1){
		RevSliderFunctions::throwError($message,$code);
	}
    public static function rev_db_instance()
    {
        if (!self::$wpdb instanceof RevDbEngine) {
            return self::$wpdb = new RevDbEngine();
        }

        return self::$wpdb;
    }
}

// @codingStandardsIgnoreStart
class rev_db_class extends RevDbEngine
{
    // @codingStandardsIgnoreEnd
}
class RevSliderDB extends RevDbEngine{
    
}