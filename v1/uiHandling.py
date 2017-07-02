from flask import Blueprint, render_template
from .Utils.AllUtils import getDatabseVariable
from .Utils.DatabaseQueries import getRandomVerifiedDogFromDatabase
from .Utils.JsonReturnData import databaseQueryToDict


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
