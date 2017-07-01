from os.path import dirname, realpath
from json import dumps
from flask import make_response, g
from sqlite3 import connect


here = dirname(realpath(__file__))
DATABASE = '{}/../../DogPictures.db'.format(here)


def makeJsonResponse(jsonData):
    resp = make_response(dumps(jsonData))
    resp.headers['Content-Type'] = 'application/json'
    return resp


def getDatabseVariable():
    db = getattr(g, '_database', None)
    if db is None:
        db = g._database = connect(DATABASE)
    return db
