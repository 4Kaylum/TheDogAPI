from .AllUtils import makeJsonResponse


def databaseQueryToDict(query):
    v = ['id', 'url', 'time', 'author', 'format', 'author_ip', 'verified']
    data = {'data':[], 'count':0, 'error':None}
    for databaseItem in query:
        b = {}
        for index, returnItem in enumerate(databaseItem):
            b[v[index]] = returnItem

        del b['author_ip']
        data['data'].append(b)

    data['count'] = len(data['data'])
    return data


def databaseQueryToResponse(query):
    v = databaseQueryToDict(query)
    return makeJsonResponse(v)

