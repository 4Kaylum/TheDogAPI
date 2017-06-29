from sqlite3 import connect


class Database(object):

    def __init__(self, filename):
        self.filename = filename
        self.database = connect(filename)
        self.cursor = None

    def commit(self):
        self.database.commit()

    def close(self):
        self.database.close()
        del self

    def fetchall(self):
        return self.database.fetchall()
