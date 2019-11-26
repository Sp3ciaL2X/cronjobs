<?php 

/**
 *
 * @author 		Sp3ciaL2X <Sp3ciaL2X@gmail.com>
 * @since 		2019
 * @license 		We live in a free world
 * @copyright 		By Sp3ciaL2X
 * @version 		1.0.0
 *
 **/

namespace Cron;

interface CronInterface {

	/**
	 *
	 * @final 		True
	 * @access		Public
	 * @method 		Interface Method Cron::addPermCronJob
	 * @param 		[ String ]	 $cronName 		= Name of new cron job to add.
	 * @param 		[ String ]	 $cronTime 		= Time to run the cron job.
	 * @param 		[ string ]	 $timeType 		= Time abbreviation or full name.Allowed abbreviations [ m , minute ] , [ h , hour ] , [ d , day ]
	 * @param 		[ Callable ] $callable 		= Function to run the cron job.
	 * @param 		[ Array ]	 $param 		= Parameters that the function will take.
	 * @return 		[ Boolean ]
	 * @example		Cron::addPermCronJob( "myCron" , "3" , "minute" , [ $this , "execute" ] , [ "Str" , True ] )
	 *
	 * This function is used to define a everytime run cron job.
	 *
	 */

	public function addPermCronJob( string $cronName , string $cronTime , string $timeType , callable $callable , array $param );

	/**
	 *
	 * @final 		True
	 * @access		Public
	 * @method 		Interface Method Cron::addTempCronJob
	 * @param 		[ String ]	 $cronName 		= Name of new cron job to add.
	 * @param 		[ String ]	 $cronTime 		= Time to run the cron job.
	 * @param 		[ string ]	 $timeType 		= Time abbreviation or full name.Allowed abbreviations [ m , minute ] , [ h , hour ] , [ d , day ]
	 * @param 		[ Callable ] $callable 		= Function to run the cron job.
	 * @param 		[ Array ]	 $param 		= Parameters that the function will take.
	 * @return 		[ Boolean ]
	 * @example		Cron::addTempCronJob( "myCron" , "3" , "minute" , [ $this , "execute" ] , [ "Str" , True ] )
	 *
	 * This function is used to define a cron job that runs one time.
	 *
	 */

	public function addTempCronJob( string $cronName , string $cronTime , string $timeType , callable $callable , array $param );

	/**
	 *
	 * @final 		True
	 * @access		Public
	 * @method 		Interface Method cron::executeCronJobs
	 * @param 		[ Void ]
	 * @return 		[ Boolean ]
	 * @example		Cron::executeCronJobs( )
	 *
	 * Run all cron jobs
	 *
	 */

	public function executeCronJob();

	/**
	 *
	 * @final 		True
	 * @access		Public
	 * @method 		Interface Method cron::listAllCronJob
	 * @param 		[ Void ]
	 * @return 		[ Array ]
	 * @example		Cron::listAllCronJob( )
	 *
	 * Lis all cron job
	 *
	 */

	public function listAllCronJob();

}

final class Cron implements CronInterface {

	/**
	 *
	 * @access  	Private
	 * @property 	[ Array ] $cronJobs = Cron Jobs storage
	 *
	 */

	private $cronJobs	= NULL;

	/**
	 *
	 * @access  	Private
	 * @constant	CRONJOB_TEMPORARY = returns "1" for a one-time cron job
	 *
	 */

	CONST CRONJOB_TEMPORARY		= 1;

	/**
	 *
	 * @access  	Private
	 * @constant	CRONJOB_PERMANENT = returns "2" for a everytime cron job
	 *
	 */

	CONST CRONJOB_PERMANENT		= 2;

	final public function addPermCronJob( string $cronName , string $cronTime , string $timeType , callable $callable , array $param ) : bool {

		if ( array_key_exists( $cronName , ( array ) $this->cronJobs ) != False ) return False;

		switch ( strtolower( $timeType ) ) {
			
			case "m" :
			case "minute" :

				$executeTime = $cronTime * 60;
				break;

			case "h" :
			case "hour" :

				$executeTime = $cronTime * 3600;
				break;

			case "d" :
			case "day" :

				$executeTime = $cronTime * 86400;
				break;

			default :

				$executeTime = $cronTime;
				break;

		}

		$this->cronJobs[ $cronName ] = array( "cronType" => self::CRONJOB_PERMANENT , "cronTime" => $cronTime , "timeType" => $timeType , "executeTime" => microtime( True ) + $executeTime , "callable" => $callable , "cronParam" => $param  );

		return True;

	}

	final public function addTempCronJob( string $cronName , string $cronTime , string $timeType , callable $callable , array $param ) : bool {

		if ( array_key_exists( $cronName , ( array ) $this->cronJobs ) != False ) return False;

		switch ( strtolower( $timeType ) ) {
			
			case "m" :
			case "minute" :

				$executeTime = $cronTime * 60;
				break;

			case "h" :
			case "hour" :

				$executeTime = $cronTime * 3600;
				break;

			case "d" :
			case "day" :

				$executeTime = $cronTime * 86400;
				break;

			default :

				$executeTime = $cronTime;
				break;

		}

		$this->cronJobs[ $cronName ] = array( "cronType" => self::CRONJOB_TEMPORARY , "cronTime" => $cronTime , "timeType" => $timeType , "executeTime" => microtime( True ) + $executeTime , "callable" => $callable , "cronParam" => $param );

		return True;

	}

	final public function executeCronJob() : bool {

		if ( is_array( $this->cronJobs ) != True ) return False;

		$microtime = microtime( True );

		foreach ( $this->cronJobs as $cronName => $value ) {
			
			if ( $this->cronJobs[ $cronName ][ "cronType" ] == self::CRONJOB_PERMANENT ) {
				
				if ( $this->cronJobs[ $cronName ][ "executeTime" ] < $microtime ) {
					
					call_user_func_array( $this->cronJobs[ $cronName ][ "callable" ] , $this->cronJobs[ $cronName ][ "cronParam" ] );

					switch ( strtolower( $this->cronJobs[ $cronName ][ "timeType" ] ) ) {
						
						case "m" :
						case "minute" :

							$executeTime = $this->cronJobs[ $cronName ][ "cronTime" ] * 60;
							break;

						case "h" :
						case "hour" :

							$executeTime = $this->cronJobs[ $cronName ][ "cronTime" ] * 3600;
							break;

						case "d" :
						case "day" :

							$executeTime = $this->cronJobs[ $cronName ][ "cronTime" ] * 86400;
							break;

						default :

							$executeTime = $this->cronJobs[ $cronName ][ "cronTime" ];
							break;

					}

					$this->cronJobs[ $cronName ][ "executeTime" ] = $executeTime + $microtime;

				}

			}

			if ( $this->cronJobs[ $cronName ][ "cronType" ] == self::CRONJOB_TEMPORARY ) {
					
				if ( $this->cronJobs[ $cronName ][ "executeTime" ] < $microtime ) {
						
					call_user_func_array( $this->cronJobs[ $cronName ][ "callable" ] , $this->cronJobs[ $cronName ][ "cronParam" ] );

					unset( $this->cronJobs[ $cronName ] );

				}

			}

		}

		return True;

	}

	final public function listAllCronJob() : array {

		return ( array ) $this->cronJobs;

	}

}

?>
