import MySQLdb
import datetime
import notify
from datetime import date
from zang.exceptions.zang_exception import ZangException
from zang.configuration.configuration import Configuration
from zang.connectors.connector_factory import ConnectorFactory
from docs.examples.credetnials import sid, authToken
import calendar
import time
#current time
def main():
    my_date = date.today()
    currtime = datetime.datetime.now().time()
    currday = calendar.day_name[my_date.weekday()]
    #creates database
    db = MySQLdb.connect(host="localhost",    # your host, usually localhost
                         user="root",         # your username
                         passwd="",  # your password
                         db="dyspense")       #CHANGE THESE
    #cursor for database
    cur = db.cursor()
    #create a notify object
    contactHandler = notify.notify()
    #gets the table from database
    cur.execute("SELECT * FROM patients")
    numberlist = list()
    currtime = str(currtime).split(':')
    multiplier = 3600
    currInt = 0
    for things in currtime:
        currInt = float(things) * multiplier + currInt
        multiplier = multiplier / 60
    for row in cur.fetchall():
        dosetime = str(row[4]).split(':')
        multiplier = 3600
        doseInt = 0
        for things in dosetime:
            doseInt = float(things) * multiplier + doseInt
            multiplier = multiplier / 60
        if int(currInt) == int(doseInt) and currday == row[3]:
            if row[7] == 1:
                contactHandler.call(row[6])
                contactHandler.sendText(row[6], "Time for your medicine")
            elif row[7] == 2:
                contactHandler.call(row[6])
            elif row[7] == 3:
                contactHandler.sendText(row[6], "Time for your medicine")


    db.close()

    print(int(currInt))
    time.sleep(1)
while True:
    main()
