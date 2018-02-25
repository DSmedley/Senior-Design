#!/usr/bin/python

import sys
import json

x=sys.argv[1]
data=json.loads(x)


#for item in data:
#	item['sentiment'] = item['text'] + "ADDED!"
#	item.pop('text', None)

print(json.dumps(data))
