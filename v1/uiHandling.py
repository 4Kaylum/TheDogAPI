from flask import Blueprint, render_template, request
from .Utils.AllUtils import getDatabseVariable, verifyToken
from .Utils.DatabaseQueries import verifyDogFromDatabase, getRandomVerifiedDogFromDatabase, getSpecificDogFromDatabase, getUnverifiedDogFromDatabase
from .Utils.JsonReturnData import databaseQueryToDict, databaseQueryToObjects


ui_v1 = Blueprint(
    'ui_v1', 
    __name__,
    template_folder='templates'
)


@ui_v1.route('/ui/v1')
@ui_v1.route('/ui/v1/')
def documentationPage():
    return render_template('api_v1.html')


@ui_v1.route('/ui/v1/dog')
@ui_v1.route('/ui/v1/dog/')
def doggoPage():
    database = getDatabseVariable()
    dogThing = getRandomVerifiedDogFromDatabase(database)
    dogData = databaseQueryToDict(dogThing)
    dogID = dogData['data'][0]['id']
    dogURL = dogData['data'][0]['url']
    return render_template('dog.html', dogID=dogID, dogURL=dogURL)


@ui_v1.route('/ui/v1/dog/<dogPageID>')
@ui_v1.route('/ui/v1/dog/<dogPageID>/')
def doggoPageByID(dogPageID):
    database = getDatabseVariable()
    dogThing = getSpecificDogFromDatabase(database, dogPageID)
    dogData = databaseQueryToDict(dogThing)
    dogID = dogData['data'][0]['id']
    dogURL = dogData['data'][0]['url']
    return render_template('dog.html', dogID=dogID, dogURL=dogURL)


@ui_v1.route('/ui/v1/submit')
@ui_v1.route('/ui/v1/submit/')
def submitPage():
    return render_template('submit.html')


@ui_v1.route('/ui/v1/verify', methods=['GET', 'POST'])
@ui_v1.route('/ui/v1/verify/', methods=['GET', 'POST'])
def verifyPage():

    # Verify the user's token/cookie
    if not verifyToken(request):
        return render_template('unavailable.html'), 403

    # Check to see if a dog needs to be verified
    if request.method == 'POST':

        # Get the form
        form = request.form
        dogID = form['dogID']
        action = form['Action']

        # Change the database
        database = getDatabseVariable()
        if action == 'Accept':
            verifyDogFromDatabase(database, dogID)
        else:
            unverifyDogFromDatabase(database, dogID)

    # Get a new doggerino from the database to verify
    database = getDatabseVariable()
    dogThing = getUnverifiedDogFromDatabase(database)
    try:
        dogData = databaseQueryToObjects(dogThing, 'v1')
        return render_template('verify.html', dog=dogData[0])
    except Exception:
        return render_template('nothing.html')
