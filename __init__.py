from json import dumps
from sqlite3 import connect
from flask import Flask, request, make_response, g
from Utils.Functions import saveNewThing, getOldThing


app = Flask(__name__)
DATABASE = './DogPictures.db'


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
    pass


def getAllDoggo():
    database = getDatabase()
    x = getOldThing(database)
    y = x[0]
    data = {
        'id': y[0],
        'url': y[1],
        'time': y[2],
        'author': y[3],
        'format': y[4]
    }

    resp = make_response(dumps(data))
    resp.headers['Content-Type'] = 'application/json'
    return resp


if __name__ == '__main__': app.run(debug=True)

