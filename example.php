<?php 

/**
 *
 * @author 		Sp3ciaL2X <Sp3ciaL2X@gmail.com>
 * @since 		2019
 * @license		We live in a free world
 * @copyright		By Sp3ciaL2X
 * @version		1.0.0
 *
 **/

require_once "cronjobs.php";

$cron = new Cron;

function exampleCron( $value ) {

	return $value." is running";

}

$cron->addPermCronJob( "cronJob" , "1" , "m" , "exampleCron" ,  array( "cronjob" ) );
$cron->addTempCronJob( "cronJob_2" , "1" , "m" , "exampleCron" ,  array( "cronjob2" ) );

print_r( $cron->listAllCronJob() );

while( True ) {

	$cron->executeCronJob();

}

?>
