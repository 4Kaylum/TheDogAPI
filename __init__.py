from json import dumps
from flask import Flask, g, render_template, Blueprint, request, make_response, Redirect


app = Flask(__name__)
root_pages = Blueprint(
    'root_pages', 
    __name__,
    template_folder='templates'
)


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


@root_pages.route('/')
def mainPage():
    return render_template('index.html')


@root_pages.route('/cookies')
def cookiePage():
    return render_template('set_cookie.html', cookies=request.cookies)


@root_pages.route('/cookies', methods=['POST'])
def cookiePagePost():
    form = request.form
    v = make_response(render_template('set_cookie.html', cookies=request.cookies))
    v.set_cookie(form['CookieName'], form['CookieValue'], 60*60*24*7*365)
    return v


@root_pages.route('/doggo')
def doggoPage():
    return Redirect('/v1/dog')


@root_pages.route('/api')
def apiPage():
    return render_template('api.html')


from .v1.apiHandling import api_v1
from .v1.uiHandling import ui_v1
app.register_blueprint(api_v1)
app.register_blueprint(ui_v1)
app.register_blueprint(root_pages)


if __name__ == '__main__': 
    app.run(host='0.0.0.0', port=80, debug=False)
