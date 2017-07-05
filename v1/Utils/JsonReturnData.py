from .AllUtils import makeJsonResponse, DogObject


def databaseQueryToDict(query, apiVersion='v1'):
    v = ['id', 'url', 'time', 'format', 'author_ip', 'verified']
    data = {'data':[], 'count':0, 'error':None, 'api_version': apiVersion}
    for databaseItem in query:
        b = {}
        for index, returnItem in enumerate(databaseItem):
            b[v[index]] = returnItem

        del b['author_ip']
        data['data'].append(b)

    data['count'] = len(data['data'])
    data['api_version'] = apiVersion
    return data


def databaseQueryToResponse(query, apiVersion='v1'):
    v = databaseQueryToDict(query, apiVersion)
    return makeJsonResponse(v)


def databaseQueryToObjects(query, apiVersion='v1'):
    v = databaseQueryToDict(query, apiVersion)
    return [DogObject(i, apiVersion) for i in v['data']]

