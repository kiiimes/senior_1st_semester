#!/bin/bash
echo date
nowTime = $(date +%H).":".$(date +%M).":".$(date +%S)
echo $nowTime
mysql --user="root" --password="ngn787178" --database="smartHome" --execute="select * from push where pushTime='".$nowTime."'"
