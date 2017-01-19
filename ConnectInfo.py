import pypyodbc

def sql():
  server = "GAGAN-DP\SQLEXPRESS"
  db = "RailwayER"
  username = "webserver"
  password = "KirklandWater1"


  connection_string ="""DRIVER={{SQL Server}};SERVER={0};DATABASE={1};UID={2};PWD={3};Trusted_Connection=No;""".format(server, db, username, password)
  connection = pypyodbc.connect(connection_string)
  cur = connection.cursor()


  return cur, connection
