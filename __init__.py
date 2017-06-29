from json import dumps
from sqlite3 import connect
from flask import Flask, request, make_response, g
from Utils.Functions import saveNewThing, getOldThing


app = Flask(__name__)
DATABASE = './DogPictures.db'


def makeJson(jsonData):
    resp = make_response(dumps(jsonData))
    resp.headers['Content-Type'] = 'application/json'
    return resp


def getDatabase():
    db = getattr(g, '_database', None)
    if db is None:
        db = g._database = connect(DATABASE)
    return db


@app.teardown_appcontext
def close_connection(exception):
    db = getattr(g, '_database', None)
    if db is not None:
        db.close()


@app.route('/')
def mainPage():
    return 'This is the main page.'


@app.route('/api', methods=['GET', 'POST'])
def apiPage():
    if request.method == 'POST':
        return addNewDoggo()
    else:
        return getAllDoggo()


# @app.errorhandler(404)
# def not_found(error):
#     resp = make_response('Test lol', 404)
#     resp.headers['Content-Type'] = 'application/json'
#     return resp
# SELECT * FROM table ORDER BY RANDOM() LIMIT 1;


def addNewDoggo():
    database = getDatabase()
    data = saveNewThing(database, request.args)
    if data is 0:
        data = {
            'error': 'Not valid format. Valid formats are JPG, PNG, and GIF.'
        }
    elif data is 1:
        data = {
            'error': 'That image is already in the database.'
        }

    return makeJson(data)
    


def getAllDoggo():
    database = getDatabase()
    x = getOldThing(database)
    y = x[0]
    data = {
        'id': y[0],
        'url': y[1],
        'time': y[2],
        'author': y[3],
        'format': y[4],
        'error': None
    }

    return makeJson(data)


if __name__ == '__main__': app.run(debug=True)

