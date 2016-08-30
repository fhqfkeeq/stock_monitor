<?php
/**
 * Created by PhpStorm.
 * User: zhaojipeng
 * Date: 16/8/26
 * Time: 17:07
 */

/**
 * Class MyDB
 * $db = new MyDB();
 * $data = [
 *   'id' => '1',
 *   'name' => "'廊坊发展'",
 *   'code' => "'sh600149'",
 *   'price' => '13.00',
 *   'number' => '100',
 * ];
 * $db->add($data);
 * $info = $db->get();
 * print_r($info);exit;
 * var_dump($db->update($data,'id = 1'));
 * $db->close();
 */

class MyDB extends SQLite3
{
    private $db_file = '/stock.db';  //必须使用绝对路径
    function __construct()
    {
        $is_create_tab = false;
        if(!file_exists($this->db_file)){
            $is_create_tab = true;
        }
        parent::__construct($this->db_file);

        if($is_create_tab){
            $this->create_tab();
        }
    }

    public function create_tab(){
        $sql = <<<EOF
CREATE TABLE stock (id INT PRIMARY KEY  NOT NULL,
name    VARCHAR(50) NOT NULL,
code    VARCHAR(20) NOT NULL,
price   DECIMAL(10,2) ,
number  INT(11) );
EOF;
        $ret = $this->exec($sql);

        if(!$ret){
            return $this->lastErrorCode();
        }else{
            return "Table created successfully".PHP_EOL;
        }
    }

    public function add($data){
        $field_str = '';
        $val_str = '';
        $sql = 'insert into stock (';
        foreach ($data as $key => $val){
            $field_str .= $key.',';
            $val_str .= $val.',';
        }
        $sql .= rtrim($field_str, ',').') values ('.rtrim($val_str, ',').');';

        $ret = $this->exec($sql);

        return $ret;
    }

    public function get($where = '', $field = '*'){
        $reData = [];

        if(is_array($field) === true){
            $field = implode(',', $field);
        }

        if(empty($where) === false){
            $where = ' where '.$where;
        }

        $sql = "select ".$field.' from stock '.$where;
        $ret = $this->query($sql);

        while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
            $reData[] = $row;
        }

        return $reData;
    }

    public function update($data, $where = ''){
        $set_str = '';

        if(empty($where) === false){
            $where = ' where '.$where;
        }

        foreach ($data as $item => $val) {
            $set_str .= $item." = ".$val.", ";
        }

        $sql = "update stock set ".rtrim($set_str, ', ').$where;

        $ret = $this->exec($sql);

        return $ret;
    }
}