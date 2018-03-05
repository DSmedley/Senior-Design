
# coding: utf-8

# In[2]:


get_ipython().system('/usr/bin/python ')

import sys 
import json 
import os 
import pandas as pd 

DEBUG = False

#DECLARE TEMP VARIABLES
x = 'temp123'
data = []
WORDLIST_CSV = 'temp.csv'

#CHECK TO SEE IF THE SERVERSIDE FILE EXISTS
if os.path.isdir('py/temp/'):
    x='py/temp/'+sys.argv[1] 
    data = json.load(open(x))
    WORDLIST_CSV = 'py/NRC-Emotion-Lexicon-v0.92-ck.csv'  #SAME THING BUT WITH THE PY/ PATH ADDED ON FOR THE ENV TO FIND
    
    
else: #ELSE, ASSUME WE ARE RUNNING DEBUG MODE
    df = pd.read_csv('text_emotion_ck.csv').iterrows()
    for i, row in df:
        #print(i, row.content) #THE ROWS DATA DEPENDS ON THE HEADER OF THE CSV FILE. AT SOME POINT, CHANGE IT TO "TEXT" TO MATCH THE JSON FILE
        data.append(row.content)
    WORDLIST_CSV = 'NRC-Emotion-Lexicon-v0.92-ck.csv'
    DEBUG = True


sl_positive = [] 
sl_negative = [] 
 
sl_ang = [] 
sl_ant = [] 
sl_disg = [] 
sl_fear = [] 
sl_joy = [] 
sl_sad = [] 
sl_surp = [] 
sl_trust = [] 
 
sl_total_wordlist = []  
df = pd.read_csv(WORDLIST_CSV) 
for i, row in df.iterrows(): 
    index = df.index[i] 
    word, pos, neg, ang, ant, disg, fear, joy, sad, surp, trust = row 
    if pos == 1: 
        sl_positive.append(word) 
    if neg == 1: 
        sl_negative.append(word) 
    if ang == 1: 
        sl_ang.append(word) 
    if ant == 1: 
        sl_ant.append(word) 
    if disg == 1: 
        sl_disg.append(word) 
    if fear == 1: 
        sl_fear.append(word) 
    if joy == 1: 
        sl_joy.append(word) 
    if sad == 1: 
        sl_sad.append(word) 
    if surp == 1: 
        sl_surp.append(word)
    if trust == 1:
        sl_trust.append(word)
    sl_total_wordlist.append(word)


total_beefoo_results = {'nada': 0, 'anger': 0, 'anticipation': 0, 'disgust': 0, 'fear': 0, 'joy': 0, 'sadness': 0, 'surprise': 0, 'trust': 0} 
total_pv_results = {'neutral': 0, 'positive': 0, 'negative': 0}

tweet_dict = {'sample tweet': 'sentiment'}
tweet_pv_values = {'sample tweet': 'neutral'}



for item in data:
    #THE METHODS OF PULLING THE DATA FROM THE TABLES IS A LOT DIFFERENT. THIS MIGHT NEED TO BE CHANGED LATER
    #print(item)
    if DEBUG == True:
        tweet = item
    else:
        tweet = item['text']
    tweet_dict[tweet] = 'hi';
    tweet_pv_values[tweet] = 0;
    temp_sentiments = {'fear': 0, 'anger': 0, 'anticipation': 0, 'trust': 0, 'surprise': 0, 'sadness': 0, 'disgust': 0, 'joy': 0} 
    temp_pv = 0
    highest_sent = 'nada'
    highest_sent_value = 0

    temp_tweet_words = []
    for word in tweet.split():
        word = (word.lower())
        if word in sl_total_wordlist:
            temp_tweet_words.append(word)
            
    for i in temp_tweet_words:
        word = (i.lower())
        
        if word in sl_ang:
            temp_sentiments['anger'] += 1
        if word in sl_ant:
            temp_sentiments['anticipation'] += 1
        if word in sl_disg:
            temp_sentiments['disgust'] += 1
        if word in sl_fear:
            temp_sentiments['fear'] += 1
        if word in sl_joy:
            temp_sentiments['joy'] += 1
        if word in sl_sad:
            temp_sentiments['sadness'] += 1
        if word in sl_surp:
            temp_sentiments['surprise'] += 1
        if word in sl_trust:
            temp_sentiments['trust'] += 1
        if word in sl_positive:
            temp_pv += 1

        if word in sl_negative:
            temp_pv -= 1

    for key, val in temp_sentiments.items():
         if val > highest_sent_value:
            highest_sent = key
            highest_sent_value = val

    if highest_sent != 'nada':
        tweet_dict[tweet] = highest_sent
        
        if highest_sent in total_beefoo_results:
            total_beefoo_results[highest_sent] += 1
        else:
            total_beefoo_results[highest_sent] = 1
            
    else:
        total_beefoo_results['nada'] += 1
    
    
    
    if temp_pv > 0:
        tweet_pv_values[tweet] = 'positive'
        total_pv_results['positive'] += 1
    elif temp_pv < 0:
        tweet_pv_values[tweet] = 'negative'
        total_pv_results['negative'] += 1
    else:
        tweet_pv_values[tweet] = 'neutral'
        total_pv_results['neutral'] += 1


for k, v in total_pv_results.items(): 
    total_beefoo_results[k] = v 
     
if os.path.exists(x): 
    os.remove(x) 
     
print(json.dumps(total_beefoo_results)) 

