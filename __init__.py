from json import dumps
from flask import Flask, request, make_response
from Utils.Models import Database


app = Flask(__name__)
database = Database('DogPictures.db')


@app.route('/')
def mainPage():
    return 'This is the main page.'


@app.route('/api', methods=['GET', 'POST'])
def apiPage():
    if request.method == 'POST':
        addNewDoggo()
    else:
        getAllDoggo()


# @app.errorhandler(404)
# def not_found(error):
#     resp = make_response('Test lol', 404)
#     resp.headers['Content-Type'] = 'application/json'
#     return resp
# SELECT * FROM table ORDER BY RANDOM() LIMIT 1;


def addNewDoggo():
    pass


def getAllDoggo():
    pass


if __name__ == '__main__': app.run(debug=True)

