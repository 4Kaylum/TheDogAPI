from .InputVerification import*


def saveNewToDatabse(database, request):

    newThing = request.args
       
    # Make the URL required
    if 'url' not in newThing.keys():
        return 3

    # Check the image
    urlFormat = verifyImage(newThing.get('url'))
    if urlFormat == None:
        return 0

    # Make sure that the item isn't already in the database
    if duplicateImage(database, newThing.get('url')):
        return 1

    # Generate a new ID
    newID = getNewID()
    currentIDs = getCurrentIDs(database)
    while newID in currentIDs:
        newID = getNewID()

    # Get the author's IP
    authIP = request.environ.get('HTTP_X_REAL_IP', request.remote_addr)

    # If it's me, auto-verify
    verif = 1 if authIP == '127.0.0.1' else 0

    # Get the current time
    currentTime = getCurrentTime()

    # Plonk it into the database
    database.execute(
        'INSERT INTO DogPictures(id, url, time, format, author_ip, verified) VALUES (?, ?, ?, ?, ?, ?)', 
        (newID, newThing.get('url'), currentTime, urlFormat, authIP, verif)
    )

    # Save file
    database.commit()

    # Return the data
    return {
        'data': [{
            'id': newID,
            'url': newThing.get('url', None),
            'time': currentTime,
            'format': urlFormat,
            'verified': verif
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
    c = database.execute('SELECT COUNT(id) FROM DogPictures')
    x = c.fetchall()
    return x[0][0]
