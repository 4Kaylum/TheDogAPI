from datetime import datetime
from json import loads, dumps
from random import choice


FILENAME = 'DogPictures.json'
IDSTRING = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_'


def getNewID() -> str:
    return ''.join(choice(IDSTRING) for i in range(11))


def getCurrentTime() -> str:
    return datetime.now().isoformat()


def saveNewThing(newThing):

    # Generate the file if it doesn't exist
    try:
        with open(FILENAME) as a:
            data = a.read()
            jsonData = loads(data)
    except (FileExistsError, FileNotFoundError):
        jsonData = {}

    # Generate a new ID
    newID = getNewID()
    while newID in jsonData:
        newID = getNewID()

    # Get the current time
    currentTime = getCurrentTime()

    # Plonk it into the database
    jsonData[newID] = {
        'url': newThing,
        'id': newID,
        'time': currentTime,
        'author': 'Caleb#2831',
        'source': 'https://www.reddit.com/r/puppy'
    }

    # Save file
    with open(FILENAME, 'w') as a:
        a.write(dumps(jsonData))

    # Return the ID
    return newID


if __name__ == '__main__':
    while True:
        x = input('What is your dog picture?\n :: ')
        y = saveNewThing(x)
        print(f'Saved as `{y}`\n\n')


