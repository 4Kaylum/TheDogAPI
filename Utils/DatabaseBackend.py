from re import match, IGNORECASE
from datetime import datetime 
from random import choice


IDSTRING = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_'


def verifyImage(imageURL) -> bool:
    x = match(r'.+(jpeg|jpg|png|gif|gifv)', imageURL, IGNORECASE)
    return bool(x)


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
