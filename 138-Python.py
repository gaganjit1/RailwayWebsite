from ConnectInfo import *
from random import SystemRandom
import hashlib
import sys, json

#PHPresponse = ["random", "password", "Random Man", "1980-02-08", "random@email.com", "408-217-6545"]

def storeresponse(PHPResponse):
    HashVal = Hash(PHPResponse[1])
    PHPResponse[1] = HashVal[0]
    PHPResponse.append(HashVal[1])
    answersstr = "', '".join(PHPResponse)
    cur = sql()[0]
    query = "EXEC dbo.AddUser '" + answersstr + "'"
    cur.execute(query)
    row = cur.fetchone()
    cur.commit()
    InsertErrorCheck(row, query)

def InsertErrorCheck(SQLResponse, query):
    if SQLResponse[0] == "None":
        print 'Succeeded!'
        target = open('Log.txt', 'a')
        target.write("\nUser:       "+"Query:'"+query+"'      SUCCESS")
        target.close
    elif SQLResponse[0] == "Future DOB":
        print 'Invalid date!'
        target = open('Log.txt', 'a')
        target.write("\nUser:       "+"Query:'"+query+"'      FAILED")
        target.close
    elif "Violation of PRIMARY KEY constraint" in SQLResponse[5]:
        print 'User already exists!'
        target = open('Log.txt', 'a')
        target.write("\nUser:       "+"Query:'"+query+"'      FAILED")
        target.close
    else:
        print 'Failed!'
        target = open('Log.txt', 'a')
        target.write("\nUser:       "+"Query:'"+query+"'      FAILED")
        target.close

def Authenticate(PHPInput):
    salt = GetSalt(PHPInput)
    authentication = PHPInput[0], hashlib.md5( str(salt) + str(PHPInput[1]) ).hexdigest()
    authstr = "', '".join(authentication)
    cur = sql()[0]
    cur.execute("EXEC dbo.AuthenticateUser'" + authstr + "'")
    row = cur.fetchall()
    if row[0][0] == 'Yes':
        print 'Succeeded!'
    else:
        print 'Failed!'

def DoSomeMd5(PHPin):
    salt = GetSalt(PHPin)
    phpResult = hashlib.md5(str(salt) + str(PHPin[1])).hexdigest()
    return phpResult

def AuthPage(username, hashpass):
    authentication = username, hashpass
    authstr = "', '".join(authentication)
    cur = sql()[0]
    cur.execute("EXEC dbo.AuthenticateUser'" + authstr + "'")
    row = cur.fetchall()
    if row[0][0] == 'Yes':
        print 'Succeeded!'
    else:
        print 'Failed!'

def GetSalt(PHPInput):
    cur = sql()[0]
    cur.execute("EXEC dbo.GetSalt '" + str(PHPInput[0]) + "'")
    salt = cur.fetchone()
    cur.commit()
    return salt[0]

def Hash(input):
    cryptogen = SystemRandom()
    salt = [cryptogen.randrange(10) for i in range(32)]
    salt = ''.join(str(i) for i in salt)
    hashval = hashlib.md5( salt + input ).hexdigest()
    return hashval, salt


if sys.argv[1] == 'authenticate':
    try:
        x = sys.argv[3]
        PHPinput = sys.argv[2],sys.argv[3]
        Authenticate(PHPinput)
    except IndexError:
        print 'Invalid command'
elif sys.argv[1] == 'md5':
    PHPinput = sys.argv[2], sys.argv[3]
    print DoSomeMd5(PHPinput)
elif sys.argv[1] == 'salt':
    PHPinput = [sys.argv[2]]
    print GetSalt(PHPinput)
elif sys.argv[1] == 'authpage':
    AuthPage(sys.argv[2], sys.argv[3])
elif sys.argv[1] == 'register':
    print sys.argv[2]
    PHPinput = eval(sys.argv[2])
    storeresponse(PHPinput)
else:
    print 'Invalid command'

