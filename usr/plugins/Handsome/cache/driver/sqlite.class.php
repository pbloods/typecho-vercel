<?php
class HandsomeCache extends HandsomeCacheBase
{
    public function __construct($option)
    {
        parent::__construct();
    }

    public function install()
    {
        $sql = '
DROP TABLE IF EXISTS `%dbnsame%`;
CREATE TABLE `%dbname%` (
  `key` varchar(32) NOT NULL PRIMARY KEY,
  `data` text,
  `time` int(20) DEFAULT NULL,
  `type` varchar(10)
);';
        $dbname = $this->db->getPrefix() .$this->cache_db_name;
        $search = array('%dbname%');
        $replace = array($dbname);

        $sql = str_replace($search, $replace, $sql);
        $sqls = explode(';', $sql);
        foreach ($sqls as $sql) {
            if (trim($sql) != ""){
                $this->db->query($sql);
            }
        }
    }

    public function is_exist_table()
    {
        $this->db = Typecho_Db::get();
        $dbname = $this->db->getPrefix() . $this->cache_db_name;
        $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name= '" . $dbname . "'";
        if (count($this->db->fetchAll($sql)) == 0) {
            return false;
        }else{
            return true;
        }
    }

}
