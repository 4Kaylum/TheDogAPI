from re import match, IGNORECASE
from sqlite3 import connect
from datetime import datetime
from random import choice


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


DATABASE = Database('DogPictures.db')
IDSTRING = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_'


def getNewID() -> str:
    return ''.join(choice(IDSTRING) for i in range(11))


def getCurrentTime() -> str:
    return datetime.now().isoformat()


def getCurrentIDs() -> list:
    DATABASE.cursor = c = DATABASE.database.execute('select id from DogPictures')
    x = c.fetchall()
    y = [i[0] for i in x]
    return y


def saveNewThing(newThing):

    # Check the image
    if not verifyImage(newThing):
        print('That\'s not a valid image. Please try again')
        return

    # Generate a new ID
    newID = getNewID()
    currentIDs = getCurrentIDs()
    while newID in currentIDs:
        newID = getNewID()

    # Get the current time
    currentTime = getCurrentTime()

    # Plonk it into the database
    DATABASE.database.execute('insert into DogPictures(id, url, time, author) values (?, ?, ?, ?)', (newID, newThing, currentTime, 'Caleb#2831'))

    # Save file
    DATABASE.commit()

    # Return the ID
    return newID


def addNewThings():
    while True:
        x = input('What is your dog picture?\n :: ')
        y = saveNewThing(x)
        print(f'Saved as `{y}`\n\n')    


def verifyImage(imageURL) -> bool:
    x = match(r'.+(jpeg|jpg|png|gif|gifv)', imageURL, IGNORECASE)
    return bool(x)


if __name__ == '__main__':
    # verifyDatabase()
    addNewThings()
    # oneTimeNewThings()


DATABASE.close()

