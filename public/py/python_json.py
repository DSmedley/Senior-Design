#!/usr/bin/python

import sys
import json

x=sys.argv[1]
x = x.replace("'", '"') 
data=json.loads(x)

with open('somefile.txt', 'a') as the_file:
    the_file.write('Hello\n')
#for item in data:
    #print(item['text'])
    #print(' ')
	#item.pop('text', None)

print(json.dumps(data))
#print(x)