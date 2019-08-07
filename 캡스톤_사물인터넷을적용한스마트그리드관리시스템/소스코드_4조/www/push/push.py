import pymysql as mysql
from datetime import datetime
from pyfcm import FCMNotification

db = mysql.connect(host="203.250.148.23", user="root", password="ngn787178", db="smartHome", charset="utf8")

cursor = db.cursor()

now = datetime.now()

sql = "select * from push where pushTime like "

time = ('%s:%s' % ((str(now.hour)).zfill(2), str(now.minute).zfill(2)))

time = "'"+time+"%'"

#sql =sql+time

#print(time)

sql = "select * from push where pushTime = '01:00:00'"
print(sql)

cursor.execute(sql)
result = cursor.fetchall()

userList=[]
print(result)
for row_data in result:
	row_data = list(row_data)
	print(row_data)
	user = row_data[1]
	#api key 설정
	push_service = FCMNotification(api_key = conf["fcm"]["key"])
	

	#db에서 사용자 push_token 가져와야함
	result = push_service.notifiy_single_device(registration_id=push_tokens, message_title=message_title, message_body=message_body)

		

