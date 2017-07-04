from flask import Blueprint, request
from .Utils.AllUtils import makeJsonResponse, getDatabseVariable
from .Utils.DatabaseQueries import getSpecificDogFromDatabase, countTheDatabaseContent
from .Utils.JsonReturnData import databaseQueryToResponse
from .Utils.EndpointResponses import*


api_v1 = Blueprint(
    'api_v1', 
    __name__,
    template_folder='templates'
)


@api_v1.route('/api/v1/dog', methods=['GET', 'POST'])
def apiPage():
    if request.method == 'POST':
        x, y = apiPagePOST()
        return x, y
    else:
        return apiPageGET(), 200


@api_v1.route('/api/v1/dog/<dogID>')
def getSpecificDog(dogID):
    database = getDatabseVariable()
    x = getSpecificDogFromDatabase(database, dogID)
    return databaseQueryToResponse(x, 'v1')


@api_v1.route('/api/v1/count')
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
