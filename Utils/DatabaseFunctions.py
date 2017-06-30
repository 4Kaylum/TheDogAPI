from .DatabaseBackend import*


def saveNewToDatabse(database, request):

    newThing = request.args

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

    # Get the author's IP
    authIP = request.environ.get('HTTP_X_REAL_IP', request.remote_addr)

    # Get the current time
    currentTime = getCurrentTime()

    # Plonk it into the database
    database.execute(
        'INSERT INTO DogPictures(id, url, time, author, format, author_ip, verified) VALUES (?, ?, ?, ?, ?, ?, 0)', 
        (newID, newThing.get('url'), currentTime, newThing.get('author'), urlFormat, authIP)
    )

    # Save file
    database.commit()

    # Return the data
    return {
        'data': [{
            'id': newID,
            'url': newThing.get('url', None),
            'time': currentTime,
            'author': newThing.get('author', None),
            'format': urlFormat,
            'verified': 0
        }],
        'count': 1,
        'error': None
    }


def getRandomVerifiedDogFromDatabase(database, limit:int=1):

    # Get the item
    c = database.execute('SELECT * FROM DogPictures WHERE verified=1 ORDER BY RANDOM() LIMIT ?', (limit,))
    x = c.fetchall()
    return x


def getAnyRandomDogFromDatabase(database, limit:int=1):

    # Get the item
    c = database.execute('SELECT * FROM DogPictures ORDER BY RANDOM() LIMIT ?', (limit,))
    x = c.fetchall()
    return x


def getSpecificDogFromDatabase(database, dogNumber:str):

    # Get the item
    c = database.execute('SELECT * FROM DogPictures WHERE id=?', (dogNumber,))
    x = c.fetchall()
    return x


def countTheDatabaseContent(database):

    # Get the item
    c = database.execute('SELECT id FROM DogPictures')
    x = c.fetchall()
    return len(x)
