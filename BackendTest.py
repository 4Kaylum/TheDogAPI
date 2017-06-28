from re import match, IGNORECASE
from sqlite3 import connect
from datetime import datetime
from json import loads, dumps
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


FILENAME = 'DogPictures.json'
DATABASE = Database('DogPictures.db')
IDSTRING = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_'


def getNewID() -> str:
    return ''.join(choice(IDSTRING) for i in range(11))


def getCurrentTime() -> str:
    return datetime.now().isoformat()


def saveNewThing(newThing):

    # Check the image
    if not verifyImage(newThing):
        print('That\'s not a valid image. Please try again')
        return

    # # Generate the file if it doesn't exist
    # try:
    #     with open(FILENAME) as a:
    #         data = a.read()
    #         jsonData = loads(data)
    # except (FileExistsError, FileNotFoundError):
    #     jsonData = {}

    # Generate a new ID
    newID = getNewID()
    while newID in jsonData:
        newID = getNewID()

    # Get the current time
    currentTime = getCurrentTime()

    # # Plonk it into the database
    # jsonData[newID] = {
    #     'url': newThing,
    #     'id': newID,
    #     'time': currentTime,
    #     'author': 'Caleb#2831',
    #     'source': 'https://www.reddit.com/r/puppy'
    # }

    DATABASE.database.execute('insert into DogPictures(id, url, time, author) values (?, ?, ?, ?)', (newID, newThing, currentTime, 'Caleb#2831'))

    # # Save file
    # with open(FILENAME, 'w') as a:
    #     a.write(dumps(jsonData))

    DATABASE.commit()

    # Return the ID
    return newID


def addNewThings():
    while True:
        x = input('What is your dog picture?\n :: ')
        y = saveNewThing(x)
        print(f'Saved as `{y}`\n\n')    


def verifyDatabase():
    # Generate the file if it doesn't exist
    try:
        with open(FILENAME) as a:
            data = a.read()
            jsonData = loads(data)
    except (FileExistsError, FileNotFoundError):
        jsonData = {}

    for dogID, data in jsonData.items():
        dogImage = data['url']
        if not match(r'.+(jpeg|jpg|png|gif|gifv)', dogImage, IGNORECASE):
            print(dogID)


def verifyImage(imageURL) -> bool:
    x = match(r'.+(jpeg|jpg|png|gif|gifv)', imageURL, IGNORECASE)
    return bool(x)


def oneTimeNewThings():

    # Generate the file if it doesn't exist
    try:
        with open(FILENAME) as a:
            data = a.read()
            jsonData = loads(data)
    except (FileExistsError, FileNotFoundError):
        jsonData = {}  

    # Do stuff
    for dogID, data in jsonData.items():
        DATABASE.database.execute('insert into DogPictures(id, url, time, author) values (?, ?, ?, ?)', (dogID, data['url'], data['time'], data['author']))

    DATABASE.commit()


if __name__ == '__main__':
    # verifyDatabase()
    # addNewThings()
    oneTimeNewThings()


DATABASE.close()

