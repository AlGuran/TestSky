<?php

class Query {
    protected $_data;
    protected $_query;
    public function __construct ($sQuery, array $data = array ())
    {
        $this->_query = $sQuery;
        $this->_data = $data;
    }

    public static function instance ($sQuery, array $data = array ())
    {
        return new self ($sQuery, $data);
    }

    public function getData ()
    {
        return $this->_data;
    }

    public function getQuery ()
    {
        return $this->_query;
    }

    public function translate ()
    {
        foreach ($this->_data as $key => $value){
            $this->_query = str_replace('?'.$key, $this->_quote($value), $this->_query);
        }
        return $this->_query;
    }
    
    protected function _quote ($value)
    {
        if (is_null ($value)){
            return 'NULL';
        }
        if(is_string ($value)){
            return "'". \pg_escape_string ($value) . "'";
        }
        if (is_int ($value) || is_float ($value)){
            return $value;
        }
        return '';

    }

    function __toString() {
        return $this->translate ();
    }
}
