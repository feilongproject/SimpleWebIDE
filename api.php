<?php

ini_set('display_errors',1);            //错误信息
ini_set('display_startup_errors',1);    //php启动错误信息
error_reporting(-1);                    //打印出所有的 错误信息
global $rID;
global $result;
$debug_mode=0;

//echo system("g++ /tmp/ide/t.cpp -o /tmp/ide/t");
//echo passthru("gcc /tmp/ide/t.cpp -o /tmp/ide/t -lstdc++ 2>&1");
//exit();
if($debug_mode==0){
    $rID = rand();//为用户的代码取一个随机数作为唯一码
    $codef = fopen("/tmp/ide/".$rID.".cpp", "w");
    $cinf = fopen("/tmp/ide/".$rID.".in", "w");
    fwrite($codef,$_GET['code']);
    fclose($codef);
    fwrite($cinf,$_GET['cin']);
    fclose($cinf);
    $result=passthru("sudo g++ /tmp/ide/".$rID.".cpp -o /tmp/ide/".$rID." 2>&1");
}else{
    $rID="t";
    $result=1;
}
if($result==""){
    $cin = passthru("sudo /tmp/ide/".$rID." 2>&1 </tmp/ide/".$rID.".in");
    echo str_replace("\n","<br>",$cin); //把换行转为html
}else{
    echo "start".$result."end";
    echo "no";
    echo str_replace("\n","<br>",$result); //把换行转为html
}

passthru("sudo rm -rf /tmp/ide/*");
//unlink("/tmp/usrcode".$randint.".cpp"); //删除用户代码，以免造成tmp目>录拥挤
