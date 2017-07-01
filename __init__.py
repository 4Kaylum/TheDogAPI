from json import dumps
from os.path import dirname, realpath
from sqlite3 import connect
from flask import Flask, request, g, redirect
from .Utils.AllUtils import makeJsonResponse
from .Utils.DatabaseFunctions import*
from .Utils.DataReturns import databaseQueryToResponse


app = Flask(__name__)
here = dirname(realpath(__file__))
DATABASE = '{}/DogPictures.db'.format(here)


def getDatabseVariable():
    db = getattr(g, '_database', None)
    if db is None:
        db = g._database = connect(DATABASE)
    return db


@app.teardown_appcontext
def closeDatabaseConnection(exception):
    db = getattr(g, '_database', None)
    if db is not None:
        db.close()


@app.errorhandler(429)
def ratelimit_handler(e):
    return {
            'data': [],
            'count': 0,
            'error': 'Rate limit exceeded',
            'api_version': 'v1'
        }, 429


@app.route('/')
def mainPage():
    return 'This is the main page.'


@app.route('/api/v1/dog', methods=['GET', 'POST'])
def apiPage():
    if request.method == 'POST':
        x, y = apiPagePOST()
        return x, y
    else:
        return apiPageGET(), 200


def apiPageGET():
    limit = int(request.args.get('limit', 1))
    verif = bool(request.args.get('verified', 1))
    if limit > 20:
        limit = 20
    database = getDatabseVariable()
    if verif:
        x = getRandomVerifiedDogFromDatabase(database, limit)
    else:
        x = getAnyRandomDogFromDatabase(database, limit)
    return databaseQueryToResponse(x, 'v1')


def apiPagePOST():
    database = getDatabseVariable()
    data = saveNewToDatabse(database, request)
    responseCode = 201

    # Check for any error responses
    if data is 0:
        data = {
            'data': [],
            'count': 0,
            'error': 'The given image was not in a valid format.',
            'api_version': 'v1'
        }
        responseCode = 400
    elif data is 1:
        data = {
            'data': [],
            'count': 0,
            'error': 'That image is already in the database.',
            'api_version': 'v1'
        }
        responseCode = 403
    elif data is 3:
        data = {
            'data': [],
            'count': 0,
            'error': 'You\'re missing the URL from your request.',
            'api_version': 'v1'
        }
        responseCode = 400

    # Return any of the data as necessary
    return makeJsonResponse(data), responseCode


@app.route('/api/v1/dog/<dogID>')
def getSpecificDog(dogID):
    database = getDatabseVariable()
    x = getSpecificDogFromDatabase(database, dogID)
    return databaseQueryToResponse(x, 'v1')


@app.route('/api/v1/count')
def countTheDatabaseSize():
    database = getDatabseVariable()
    x = countTheDatabaseContent(database)
    data = {
        'data': [],
        'count': x,
        'error': None,
        'api_version': 'v1'
    }
    return makeJsonResponse(data)


if __name__ == '__main__': app.run(host='0.0.0.0', port=80)

