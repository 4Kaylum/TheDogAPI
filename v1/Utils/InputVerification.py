from re import search, IGNORECASE
# from requests import get
# from imghdr import what
from datetime import datetime 
from random import choice


IDSTRING = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_'


def verifyImage(imageURL) -> bool:
    # site = get(imageURL)
    # data = site.content
    # return what('', h=data)
    m = r'.+(png|jp[e]*g|gif[v]*)$'
    if ' ' in imageURL: return False
    return bool(search(m, imageURL, IGNORECASE))


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
