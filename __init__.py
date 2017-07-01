from json import dumps
from flask import Flask, g


app = Flask(__name__)
from v1.apiHandling import api_v1
from v1.uiHandling import ui_v1
app.register_blueprint(api_v1)
app.register_blueprint(ui_v1)


@app.teardown_appcontext
def closeDatabaseConnection(exception):
    db = getattr(g, '_database', None)
    if db is not None:
        db.close()


@app.errorhandler(429)
def ratelimit_handler(e):
    return {
            'data': [],
            'count': 0,
            'error': 'Rate limit exceeded',
            'api_version': 'v1'
        }, 429


@app.route('/')
def mainPage():
    return 'This is the main page.'


if __name__ == '__main__': 
    app.run(host='0.0.0.0', port=5000)
