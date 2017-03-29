#!/bin/bash

#程序的名字
	queue_command='nohup php /home/wwwroot/order_center/cli.php Task/Queue/index';
	keyWord="Task/Queue/index"
	DTTERM=`ps -ef | grep $keyWord | wc -l`
	#echo $DTTERM
#检查进程实例是否已经存在
	if [ $DTTERM -lt 2 ]
	then
	   echo "restart process: $name and date is: `date`"
#进程的路径要注意一下
	   $queue_command >> /home/wwwroot/order_center/shell/log.log 2>&1 &
	fi
