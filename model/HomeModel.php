<?
namespace App\Model;

class HomeModel {
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }
    public function getAllObjects(){
        $sql = "SELECT name, HOUR(begintime) as bhour, MINUTE(begintime) as bminute, HOUR(endtime) as ehour, MINUTE(endtime) eminute, begintime, endtime FROM Obj";
        $resp = [];
        foreach ($this->container->db->query($sql) as $row) {
            
            $resp[] = array(
                "name"=>$row["name"],
                "bhour"=>$row["bhour"],
                "bminute"=>$row["bminute"],
                "ehour"=>$row["ehour"],
                "eminute"=>$row["eminute"],
                "isopen"=>$this->isOpen($row["endtime"]) == true ? "открыто" : "закрыто",
                "when"=>$this->whenEndorOpen($row["begintime"], $row["endtime"]),
            );
            
        }
        return $resp;
    }
    protected function isOpen($time){

        $t = date('Y-m-d') . " " .$time;
        $c = date("Y-m-d H:i:s");

        return strtotime($c) >= strtotime($t) ? false : true;
    }

    protected function whenEndorOpen($btime, $etime){
        $str = "";
        $t = date('Y-m-d') . " " .$etime;
        $t2 = date('Y-m-d') . " " .$btime;
        $c = date("Y-m-d H:i:s");
        
        if ($this->isOpen($etime)){ 
            $str = "До закрытия: ". date("H:i", strtotime($t . "-".date("H")." hours, -".date("i")." minutes"));

        }else{
            $str = "До открытия: " . date("H:i", strtotime($t2 . " +1 days, - ".date("H")." hours, - ".date("i")." minutes" ));
        }
        return $str;
    }
}