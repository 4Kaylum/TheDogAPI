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


def saveNewThing(database, newThing):

    # Check the image
    if not verifyImage(newThing):
        print('That\'s not a valid image. Please try again')
        return

    # Generate a new ID
    newID = getNewID()
    currentIDs = getCurrentIDs(database)
    while newID in currentIDs:
        newID = getNewID()

    # Get the URL format
    urlFormat = newThing.split('.')[-1].lower().replace('jpeg', 'jpg').replace('gifv', 'gif')

    # Get the current time
    currentTime = getCurrentTime()

    # Plonk it into the database
    database.execute('INSERT INTO DogPictures(id, url, time, author, format) VALUES (?, ?, ?, ?)', (newID, newThing, currentTime, 'Caleb#2831', urlFormat))

    # Save file
    database.commit()

    # Return the ID
    return newID


def verifyImage(imageURL) -> bool:
    x = match(r'.+(jpeg|jpg|png|gif|gifv)', imageURL, IGNORECASE)
    return bool(x)


def getOldThing(database):

    # Get the item
    c = database.execute('SELECT * FROM DogPictures ORDER BY RANDOM() LIMIT 1')
    x = c.fetchall()
    return x
