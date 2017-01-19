from ConnectInfo import *
import  time


#in seconds
update = 0.25
date = 1


def dayreset():
    cur = sql()[0]
    cur.execute("TRUNCATE TABLE arrives")
    cur.commit()


def timefix(currenttime):
    if currenttime%4 == 0:
        return str(currenttime/4) + ":00"
    elif currenttime%4 == 1:
        return str(int(currenttime/4)) + ":15"
    elif currenttime%4 == 2:
        return str(int(currenttime/4)) + ":30"
    elif currenttime%4 == 3:
        return str(int(currenttime/4)) + ":45"


def updateTrain(date,train,currenttime,station):
    cur = sql()[0]
    cur.execute("INSERT INTO dbo.arrives (time, trainID, stationName) VALUES('2016-12-"+str(date)+" "+timefix(currenttime)+"','Train"+train+"','Station"+station+"')")
    cur.commit()
    print "Updated"


def daysimulator(date):
    currenttime = 0
    while currenttime < 96:
        if currenttime == 36:           #9
            updateTrain(date,"A",currenttime,"A")
            updateTrain(date,"B",currenttime,"A")
            updateTrain(date,"C",currenttime,"A")
            updateTrain(date,"D",currenttime,"A")
            updateTrain(date,"E",currenttime,"A")
            updateTrain(date,"F",currenttime,"A")
            updateTrain(date,"G",currenttime,"A")
    
        elif currenttime == 40:           #10
            updateTrain(date,"B",currenttime,"B")
            updateTrain(date,"C",currenttime,"B")
            updateTrain(date,"D",currenttime,"B")
            updateTrain(date,"E",currenttime,"B")
            updateTrain(date,"G",currenttime,"B")
    
        elif currenttime == 43:           #10:45
            updateTrain(date,"A",currenttime,"C")
            updateTrain(date,"F",currenttime,"C")
    
        elif currenttime == 44:           #11
            updateTrain(date,"B",currenttime,"C")
            updateTrain(date,"D",currenttime,"C")
            updateTrain(date,"G",currenttime,"C")
    
        elif currenttime == 47:           #11:45
            updateTrain(date,"C",currenttime,"D")
    
        elif currenttime == 48:           #12
            updateTrain(date,"B",currenttime,"D")
            updateTrain(date,"D",currenttime,"D")
            updateTrain(date,"G",currenttime,"D")
    
        elif currenttime == 50:           #12:30
            updateTrain(date,"E",currenttime,"E")
            updateTrain(date,"F",currenttime,"E")
    
        elif currenttime == 51:           #12:45
            updateTrain(date,"C",currenttime,"E")
    
        elif currenttime == 52:           #13
            updateTrain(date,"B",currenttime,"E")
            updateTrain(date,"D",currenttime,"E")
            updateTrain(date,"G",currenttime,"E")
    
        elif currenttime == 53:           #13:15
            updateTrain(date,"A",currenttime,"F")
    
        elif currenttime == 54:           #13:30
            updateTrain(date,"E",currenttime,"F")
    
        elif currenttime == 56:           #14
            updateTrain(date,"B",currenttime,"F")
            updateTrain(date,"D",currenttime,"F")
            updateTrain(date,"G",currenttime,"F")
    
        elif currenttime == 57:           #14:15
            updateTrain(date,"A",currenttime,"G")
            updateTrain(date,"F",currenttime,"G")
    
        elif currenttime == 58:           #14:30
            updateTrain(date,"C",currenttime,"G")
            updateTrain(date,"E",currenttime,"G")
    
        elif currenttime == 60:           #15
            updateTrain(date,"B",currenttime,"G")
            updateTrain(date,"D",currenttime,"G")
            updateTrain(date,"G",currenttime,"G")
    
        elif currenttime == 61:           #15:15
            updateTrain(date,"A",currenttime,"F")
    
        elif currenttime == 62:           #15:30
            updateTrain(date,"E",currenttime,"F")
    
        elif currenttime == 64:           #16
            updateTrain(date,"B",currenttime,"F")
            updateTrain(date,"D",currenttime,"F")
            updateTrain(date,"G",currenttime,"F")
    
            updateTrain(date,"F",currenttime,"E")
    
        elif currenttime == 65:           #16:15
            updateTrain(date,"C",currenttime,"E")
    
        elif currenttime == 66:           #16:30
            updateTrain(date,"E",currenttime,"E")
    
        elif currenttime == 68:           #17
            updateTrain(date,"B",currenttime,"E")
            updateTrain(date,"D",currenttime,"E")
            updateTrain(date,"G",currenttime,"E")
    
        elif currenttime == 69:           #17:15
            updateTrain(date,"C",currenttime,"D")
    
        elif currenttime == 71:           #17:45
            updateTrain(date,"A",currenttime,"C")
            updateTrain(date,"F",currenttime,"C")
    
        elif currenttime == 72:           #18
            updateTrain(date,"B",currenttime,"D")
            updateTrain(date,"D",currenttime,"D")
            updateTrain(date,"G",currenttime,"D")
    
        elif currenttime == 76:           #19
            updateTrain(date,"B",currenttime,"C")
            updateTrain(date,"D",currenttime,"C")
            updateTrain(date,"G",currenttime,"C")
    
            updateTrain(date,"C",currenttime,"B")
            updateTrain(date,"E",currenttime,"B")
    
        elif currenttime == 78:           #19:30
            updateTrain(date,"A",currenttime,"A")
            updateTrain(date,"F",currenttime,"A")
    
        elif currenttime == 80:           #20
            updateTrain(date,"B",currenttime,"B")
            updateTrain(date,"D",currenttime,"B")
            updateTrain(date,"G",currenttime,"B")
    
            updateTrain(date,"C",currenttime,"A")
            updateTrain(date,"E",currenttime,"A")
    
        elif currenttime == 84:           #21
            updateTrain(date,"B",currenttime,"A")
            updateTrain(date,"D",currenttime,"A")
            updateTrain(date,"G",currenttime,"A")
    
        currenttime += 1
        time.sleep(update)


while date < 32:
    dayreset()
    daysimulator(date)
    date+=1