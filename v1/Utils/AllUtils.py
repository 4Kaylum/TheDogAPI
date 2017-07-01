from json import dumps
from flask import make_response


def makeJsonResponse(jsonData):
    resp = make_response(dumps(jsonData))
    resp.headers['Content-Type'] = 'application/json'
    return resp
