from json import dumps
from flask import Flask, g, render_template, Blueprint, request, make_response, redirect, send_from_directory


app = Flask(__name__)
root_pages = Blueprint(
    'root_pages', 
    __name__,
    template_folder='templates'
)
app.config['SERVER_NAME'] = 'thedogapi.co.uk'


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
@root_pages.route('/cookies/')
def cookiePage():
    return render_template('set_cookie.html', cookies=request.cookies)


@root_pages.route('/cookies', methods=['POST'])
@root_pages.route('/cookies/', methods=['POST'])
def cookiePagePost():
    form = request.form
    v = make_response(render_template('set_cookie.html', cookies=request.cookies))
    v.set_cookie(form['CookieName'], form['CookieValue'], 60*60*24*7*365)
    return v


@root_pages.route('/doggo')
@root_pages.route('/doggo/')
def doggoPage():
    return redirect('/ui/v1/dog')


@root_pages.route('/dogumentation')
@root_pages.route('/dogumentation/')
def apiPage():
    return render_template('api.html')


@root_pages.route('/robots.txt')
@root_pages.route('/sitemap.xml')
@root_pages.route('/googlea72746dfade83aa5.html')
@root_pages.route('/BingSiteAuth.xml')
def robotsPage():
    return send_from_directory(app.static_folder, request.path[1:])


from .v1.apiHandling import api_v1
from .v1.uiHandling import ui_v1
app.register_blueprint(api_v1)
app.register_blueprint(ui_v1)
app.register_blueprint(root_pages)


if __name__ == '__main__': 
    app.run(host='0.0.0.0', port=80, debug=False)
