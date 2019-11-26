## CronJobs

> Cronjob is a simple class to set.This class includes four methods;

- addTempCronJob( string $cronName , string $cronTime , string $timeType , callable $callable , array $param );
- addPermCronJob( string $cronName , string $cronTime , string $timeType , callable $callable , array $param );
- listAllCronJob();
- executeCronJob();

**cronName** = CronJob name

**cronTime** = CronJob time to run at one time/time to run continuously

**timeType** = Time type, any of the following values

**callable** = Callable function to be executed as a result of this cronjob function

**param** = Parameters to be passed to the function to be executed

> 'timeType' = "m or minute" , "h or hour" , "d or day" any of these values

## 'addTempCronJob' Method

> Runs the added cronjob one time and then removes it after it has finished running

> This function returns 'False' if the value in the '$cronName' parameter is present, otherwise returns 'True'

```php
function cronFunc( string $value ) : string {
	
	return $value." is runing";

}

$cron->addTempCronJob( "firstCron" , "1" , "minute" , "cronFunc" , [ "firstCron" ] );

while( True ){
	
	$cron->executeCronJob();

	# The specified function is executed after 1 minute and then removed

}
```
## 'addPermCronJob' Method

> Runs the added cronjob continuously according to the specified time

> This function returns 'False' if the value in the '$cronName' parameter is present, otherwise returns 'True'

```php
function cronFunc( string $value ) : string {
	
	return $value." is runing";

}

$cron->addPermCronJob( "firstCron" , "1" , "minute" , "cronFunc" , [ "firstCron" ] );

while( True ){
	
	$cron->executeCronJob();

	# The specified recall function runs continuously with 1 minute interval

}
```

## 'executeCronJob' Method

> A method to run all added cronjobs

> This function returns 'False' if it does not find a cronjob to execute, otherwise returns 'True'

```php
function cronFunc( string $value ) : string {
	
	return $value." is runing";

}

$cron->addPermCronJob( "firstCron" , "1" , "minute" , "cronFunc" , [ "firstCron" ] );

while( True ){
	
	$cron->executeCronJob();

}
```

## 'listAllCronJob' Method

> Returns all added cronjobs as an array

> Returns an empty array if no cronjob is added

```php
$cron->addPermCronJob( "firstCron" , "1" , "minute" , "cronFunc_1" , [ "firstCron" ] );
$cron->addTempCronJob( "tempCron" , "5" , "day" , "cronFunc_2" , [ "tempCron" ] );
$cron->addPermCronJob( "lastCron" , "3" , "hour" , "cronFunc_3" , [ "lastCron" ] );

print_r( $cron->listAllCronJob() );
```
