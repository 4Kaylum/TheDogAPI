from os.path import dirname, realpath
from json import dumps
from flask import make_response, g
from sqlite3 import connect


here = dirname(realpath(__file__))
DATABASE = '{}/../../DogPictures.db'.format(here)
USERTOKENS = '{}/../../UserTokens'.format(here)


class DogObject(object):

    def __init__(self, d, apiVersion):
        self.api_version = apiVersion
        self.id = d['id']
        self.url = d['url']
        self.time = d['time']
        self.format = d['format']
        self.verified = d['verified']


def makeJsonResponse(jsonData):
    resp = make_response(dumps(jsonData))
    resp.headers['Content-Type'] = 'application/json'
    return resp


def getDatabseVariable():
    db = getattr(g, '_database', None)
    if db is None:
        db = g._database = connect(DATABASE)
    return db


def verifyToken(request):
    token = request.cookies.get('token')
    with open(USERTOKENS) as a:
        if token in a.read().split('\n'):
            return True 
    return False
