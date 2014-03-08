#!/usr/bin/python

# Author: Dominik Penner
# Coded in: Python3
# Dependencies: requests
#               http://docs.python-requests.org/

import urllib.request
import requests
import sys
import re

apikey = '' # API Key goes here.
track = input('Track URL> ')

def getTrackInfo(track):
    request = requests.get("http://api.soundcloud.com/resolve.json?url={0}&client_id={1}".format(track, apikey))
    return request.json()

def getTrackDownloadLink(trackid):
    request = requests.get("http://api.soundcloud.com/i1/tracks/{0}/streams?client_id={1}".format(trackid, apikey))
    return request.json()['http_mp3_128_url']


track_id = getTrackInfo(track)['id']
track_title = getTrackInfo(track)['title']
track_download = getTrackDownloadLink(track_id)

urllib.request.urlretrieve(track_download, "{0}.mp3".format(track_title))

sys.exit() 
