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

    # Get the current time
    currentTime = getCurrentTime()

    # Plonk it into the database
    database.execute(
        'INSERT INTO DogPictures(id, url, time, format, author_ip, verified, checked) VALUES (?, ?, ?, ?, ?, 0, 0)', 
        (newID, newThing.get('url'), currentTime, urlFormat, authIP)
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
            'verified': 0,
            'checked': 0
        }],
        'count': 1,
        'error': None
    }


def getRandomVerifiedDogFromDatabase(database, limit:int=1):

    # Get the item
    c = database.execute('SELECT * FROM DogPictures WHERE checked=1 ORDER BY RANDOM() LIMIT ?', (limit,))
    x = c.fetchall()
    return x


def getUnverifiedDogFromDatabase(database, limit:int=1):

    # Get the item
    c = database.execute('SELECT * FROM DogPictures WHERE checked=0 ORDER BY RANDOM() LIMIT ?', (limit,))
    x = c.fetchall()
    return x


def getSpecificDogFromDatabase(database, dogNumber:str):

    # Get the item
    c = database.execute('SELECT * FROM DogPictures WHERE id=?', (dogNumber,))
    x = c.fetchall()
    return x


def verifyDogFromDatabase(database, dogNumber:str):

    # Get the item
    database.execute('UPDATE DogPictures SET verified=1 WHERE id=?', (dogNumber,))
    database.execute('UPDATE DogPictures SET checked=1 WHERE id=?', (dogNumber,))
    database.commit()


def unverifyDogFromDatabase(database, dogNumber:str):

    # Get the item
    database.execute('UPDATE DogPictures SET checked=1 WHERE id=?', (dogNumber,))
    database.commit()


def countTheDatabaseContent(database):

    # Get the item
    c = database.execute('SELECT COUNT(id) FROM DogPictures WHERE verified=1')
    x = c.fetchall()
    return x[0][0]
