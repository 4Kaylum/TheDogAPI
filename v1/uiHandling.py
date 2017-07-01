from flask import Blueprint
from .Utils.DatabaseFunctions import*


ui_v1 = Blueprint(
    'ui_v1', 
    __name__,
    template_folder='templates'
)
