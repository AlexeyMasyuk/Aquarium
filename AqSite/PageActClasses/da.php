<?php
// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
    Page for setting aquarium alarms limits to default
    --------------------------------------------------------------
	Using 'Wrapper' that contains all needed  
	includes, session name, headers to move to,
    strings and rules.
	** On lines 16-17 unwrapping stored data to variables for 
       more simpler use.
	--------------------------------------------------------------
*/
require_once('Wrapper.php');
class DefaultAlarms extends WrappingClass{

    // Function setting default aquarium alarms limits,
    public function DefaultAlarmsSet(){
        $tm=$this->tagMap;
        $t=$this->T;
        $sql=new dbClass($tm[$t['sA']][$t['u']]);
        foreach ($tm[$t['r']] as $key=>$val){      // changing the settings.
            $sql->change($val,$key);
        }
        $this->MoveTo($tm[$t['h']][$t['mn']]);
    }
}

// DefaultAlarms Activation.
$defaultAlarms=new DefaultAlarms(basename(__FILE__,".php"));
$defaultAlarms->DefaultAlarmsSet();


?>