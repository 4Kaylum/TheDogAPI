from flask import Blueprint, render_template, request
from .Utils.AllUtils import getDatabseVariable, verifyToken
from .Utils.DatabaseQueries import verifyDogFromDatabase, getRandomVerifiedDogFromDatabase, getSpecificDogFromDatabase, getUnverifiedDogFromDatabase
from .Utils.JsonReturnData import databaseQueryToDict, databaseQueryToObjects


ui_v1 = Blueprint(
    'ui_v1', 
    __name__,
    template_folder='templates'
)


@ui_v1.route('/v1/dog')
def doggoPage():
    database = getDatabseVariable()
    dogThing = getRandomVerifiedDogFromDatabase(database)
    dogData = databaseQueryToDict(dogThing)
    dogID = dogData['data'][0]['id']
    dogURL = dogData['data'][0]['url']
    return render_template('dog.html', dogID=dogID, dogURL=dogURL)


@ui_v1.route('/v1/dog/<dogPageID>')
def doggoPageByID(dogPageID):
    database = getDatabseVariable()
    dogThing = getSpecificDogFromDatabase(database, dogPageID)
    dogData = databaseQueryToDict(dogThing)
    dogID = dogData['data'][0]['id']
    dogURL = dogData['data'][0]['url']
    return render_template('dog.html', dogID=dogID, dogURL=dogURL)


@ui_v1.route('/v1/submit')
def submitPage():
    return render_template('submit.html')


@ui_v1.route('/v1/verify', methods=['GET'])
def verifyPage():
    if not verifyToken(request):
        return render_template('unavailable.html'), 403

    database = getDatabseVariable()
    dogThing = getUnverifiedDogFromDatabase(database)
    dogData = databaseQueryToObjects(dogThing, 'v1')
    return render_template('verify.html', dog=dogData[0])


@ui_v1.route('/v1/verify', methods=['POST'])
def verifyPagePost():
    if not verifyToken(request):
        return render_template('unavailable.html'), 403

    form = request.form
    dogID = form['dogID']
    action = form['Action']
    database = getDatabseVariable()
    if action == 'Accept':
        verifyDogFromDatabase(database, dogID)
    else:
        pass

    dogThing = getUnverifiedDogFromDatabase(database)
    dogData = databaseQueryToObjects(dogThing, 'v1')
    return render_template('verify.html', dog=dogData[0])

