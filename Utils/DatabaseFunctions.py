from re import match, IGNORECASE
from datetime import datetime 
from random import choice


IDSTRING = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_'


def getNewID() -> str:
    return ''.join(choice(IDSTRING) for i in range(11))


def getCurrentTime() -> str:
    return datetime.now().isoformat()


def getCurrentIDs(database) -> list:
    c = database.execute('SELECT id FROM DogPictures')
    x = c.fetchall()
    y = [i[0] for i in x]
    return y


def duplicateImage(database, url) -> bool:
    c = database.execute('SELECT id FROM DogPictures WHERE url=?', (url,))
    x = c.fetchall()
    y = len(x)
    return bool(y)  # Returns True if duplicate


def saveNewToDatabse(database, newThing):

    # Make sure that there's only the author and URL specified
    for i, o in newThing.items():
        if i not in ['author', 'url']:
            return 2
       
    # Make the URL required
    if 'url' not in newThing.keys():
        return 3

    # Check the image
    if not verifyImage(newThing.get('url')):
        return 0

    # Make sure that the item isn't already in the database
    if duplicateImage(database, newThing.get('url')):
        return 1

    # Generate a new ID
    newID = getNewID()
    currentIDs = getCurrentIDs(database)
    while newID in currentIDs:
        newID = getNewID()

    # Get the URL format
    urlFormat = newThing.get('url').split('.')[-1].lower().replace('jpeg', 'jpg').replace('gifv', 'gif')

    # Get the current time
    currentTime = getCurrentTime()

    # Plonk it into the database
    database.execute('INSERT INTO DogPictures(id, url, time, author, format) VALUES (?, ?, ?, ?, ?)', (newID, newThing.get('url'), currentTime, newThing.get('author'), urlFormat))

    # Save file
    database.commit()

    # Return the data
    return {
        'data': [{
            'id': newID,
            'url': newThing.get('url', None),
            'time': currentTime,
            'author': newThing.get('author', None),
            'format': urlFormat
        }],
        'count': 1,
        'error': None
    }


def verifyImage(imageURL) -> bool:
    x = match(r'.+(jpeg|jpg|png|gif|gifv)', imageURL, IGNORECASE)
    return bool(x)


def getRandomDogFromDatabase(database, limit:int=1):

    # Get the item
    c = database.execute('SELECT * FROM DogPictures ORDER BY RANDOM() LIMIT ?', (limit,))
    x = c.fetchall()
    return x


def getSpecificDogFromDatabase(database, dogNumber:str):

    # Get the item
    c = database.execute('SELECT * FROM DogPictures WHERE id=?', (dogNumber,))
    x = c.fetchall()
    return x
