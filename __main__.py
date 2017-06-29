from json import dumps
from sqlite3 import connect
from flask import Flask, request, make_response, g, redirect
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


@app.route('/<postID>')
def getPostInfo(postID):
    database = getDatabase()
    c = database.execute('SELECT url FROM DogPictures WHERE id=?', (postID,))
    x = c.fetchall()
    return redirect(x[0][0])


@app.route('/random')
def getRandomPost():
    database = getDatabase()
    c = database.execute('SELECT url FROM DogPictures ORDER BY RANDOM() LIMIT 1')
    x = c.fetchall()
    return redirect(x[0][0])


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
    elif data is 2:
        data = {
            'error': 'You used an invalid JSON key. Valid keys are author and url.'
        }
    elif data is 3:
        data = {
            'error': 'You\'re missing the URL from your request.'
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

