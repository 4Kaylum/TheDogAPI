from flask import request
from .AllUtils import makeJsonResponse, getDatabseVariable
from .DatabaseQueries import getRandomVerifiedDogFromDatabase, getUnverifiedDogFromDatabase, saveNewToDatabse
from .JsonReturnData import databaseQueryToResponse


def apiPageGET():
    limit = int(request.args.get('limit', 1))
    verif = bool(request.args.get('verified', 1))
    if limit > 20:
        limit = 20
    database = getDatabseVariable()
    if verif:
        x = getRandomVerifiedDogFromDatabase(database, limit)
    else:
        x = getUnverifiedDogFromDatabase(database, limit)
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
