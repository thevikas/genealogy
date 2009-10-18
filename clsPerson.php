<?php
class clsPerson
{
    public $id;
    function load($id)
    {
        $sql="select firstname,lastname,gender from persons where cid={$id}";
        $r = doquery($sql);
        $rs = mysql_fetch_array($r);
        if($rs)
        {
            $this->firstname = $rs[0];
            $this->lastname = $rs[1];
            $this->gender = $rs[2];
            $this->id = $id;
        }
        else
        {
            die("error! EOF at $id, $sql");
        }
    }
    
    function getArray()
    {
        $arr = array();
        $carr = array();

        $name1 = trim($this->firstname . " " . $this->lastname) . " ";
        $sc = strpos($name1," ");
        //print "sc=$sc, [$name1] ";
        $name1 = substr($name1,0,$sc);
        //print ", result=[$name1]\n";
        if($name1 == "NoName")
            $name1 = "?";
        $arr['name'] = $name1;

        $md = 0;
        
        $sql = "select cid from persons where {$this->id} in (father_cid,mother_cid)";
        $r = doquery($sql);
        while($rs = mysql_fetch_array($r))
        {
            $child = new clsPerson();
            $child->load($rs[0]);
            $child_array = $child->getArray();
            $carr[] = $child_array;
            $md = $md < $child_array['depth'] ? $child_array['depth'] : $md;
        }
        $arr['children'] = $carr;
        $arr['depth'] = 1 + $md;
        return $arr;
    }
}
?>
