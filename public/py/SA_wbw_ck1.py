
# coding: utf-8

# In[23]:


import re
import nltk
from sklearn.feature_extraction.text import CountVectorizer


# In[24]:


#  FILE MANAGEMENT CELL

#THE CSV DATASET THAT WILL BE ANALYZED 
TWEET_FILE_CSV = 'text_emotion_ck.csv'
#ANY CSV FILES MUST BE CHANGED SO THAT "TWEET" CONTENT IS IN THE FIRST COLLUMN, AND "SENTIMENT" IN THE NEXT ONE. AND NO EXTRA COLLUMNS!!! DONT JUST DELETE, RIGHT CLICK AND "REMOVE ENTI COLLUMN

#DIFFERENT DATASETS WE HAVE WORKED WITH SO FAR:
#'text_emotion_ck.csv'  #CHANGED THE NAME OF IT AFTER ALTERING IT TO FIT THE 
#'clean_tweets2.csv'   --THE AIRLINE ONE

print("NODE COMPLETE")


# In[30]:


#2-25-18 YET ANOTHER VERSION THAT ASSIGNS EACH SENTIMENT ITS OWN DICTIONARY OF WORDS ASSOCIATED WITH THAT SENTIMENT
import pandas as pd


#SENTIMENT LISTS (SL)
# sl_positive = []
sl_ang = []
sl_ant = []
sl_disg = []
sl_fear = []
sl_joy = []
sl_sad = []
sl_surp = []
sl_trust = []

sl_total_wordlist = [] #WE WILL USE THIS TO LIGHTEN THE LOAD AND FIRST CHECK IF THE WORD IS IN THE LIST AT ALL BEFORE RUNNING THROUGH ALL 8 LISTS
# sl_total_wordlist = set([]) #MAYBE A SET WILL WORK BETTER?  --NAH

df = pd.read_csv('NRC-Emotion-Lexicon-v0.92-ck.csv')
for i, row in df.iterrows():
    index = df.index[i]
    word, pos, neg, ang, ant, disg, fear, joy, sad, surp, trust = row
    
    #CHECK THE SENTIMENT VALUE ON EVERY WORD AND ADD IT TO THE LIST OF EVERY SENTIMENT THAT IT HAS A VALUE IN
    #THIS IS KIND OF A CHEESEY WAY TO DO IT, BUT OH WELL
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
    #LETS US KNOW THE WORD IS IN AT LEAST ONE OF THESE 8 LISTS
    sl_total_wordlist.append(word) #LETS JUST ASSUME AT LEAST ONE SENTIMENT IS NOT 0 (THOUGH THAT ISNT ALWAYS TRUE. OH WELL)
    

print("SIZE OF SENTIMENT LISTS: ", len(sl_ang), len(sl_ant), len(sl_disg), len(sl_fear), len(sl_joy), len(sl_sad), len(sl_surp), len(sl_trust))
print("TOTAL LIST LENGTH", len(sl_total_wordlist))



#OKAY, LISTS CREATED. NOW LETS GO THROUGH THOSE TWEETS
#VVV NUMBER OF EACH RESULT PER CATAGORY IN EACH TWEET  --ADD "NADA" IN BY DEFAULT, THE REST WILL ADD THEMSELVES AS FOUND
total_beefoo_results = {'nada': 0, 'anger': 0, 'anticipation': 0, 'disgust': 0, 'fear': 0, 'joy': 0, 'sadness': 0, 'surprise': 0, 'trust': 0}

tweet_dict = {'sample tweet': 'sentiment'} 


df = pd.read_csv(TWEET_FILE_CSV)
for i, row in df.iterrows():
    index = df.index[i]
    tweet, sentiment = row
    tweet_dict[tweet] = 0;
    #A TEMPORARY TABLE TO KEEP TRACK OF THE EMOTION OF EACH TWEET. 
    #AT THE END OF READING THROUGH EACH WORD, THE EMOTION WITH THE HIGHEST SCORE WINS, AND THE TABLE IS RESET
    temp_sentiments = {'fear': 0, 'anger': 0, 'anticipation': 0, 'trust': 0, 'surprise': 0, 'sadness': 0, 'disgust': 0, 'joy': 0}
    highest_sent = 'nada'    #THESE TWO VARIABLES WILL BE USED TO DETERMINE WHICH SENTIMENT IS IN THE LEAD
    highest_sent_value = 0
    print(tweet)
    
    #ACTUALLY... LETS INSTEAD GO THROUGH THE TWEET AND KEEP A TABLE OF WORDS THAT ARE IN THE DICTIONARY
    temp_tweet_words = []
    for word in tweet.split():
        word = (word.lower())
        if word in sl_total_wordlist:
            temp_tweet_words.append(word)
            
    #NOW GO THROUGH THAT LIST OF WORDS FROM THE TWEET THAT ARE ACTUALLY IMPORTANT TO US
    for i in temp_tweet_words:
        word = (i.lower())  #MAKE SURE ITS IN LOWERCASE THO
        print(word)
        if word in sl_ang:
            temp_sentiments['anger'] += 1
            print("   anger -", i)
        if word in sl_ant:
            temp_sentiments['anticipation'] += 1
            print("   anticipation -", i)
        if word in sl_disg:
            temp_sentiments['disgust'] += 1
            print("   disgust -", i)
        if word in sl_fear:
            temp_sentiments['fear'] += 1
            print("   fear -", i)
        if word in sl_joy:
            temp_sentiments['joy'] += 1
            print("   joy -", i)
        if word in sl_sad:
            temp_sentiments['sadness'] += 1
            print("   sadness -", i)
        if word in sl_surp:
            temp_sentiments['surprise'] += 1
            print("   surprise -", i)
        if word in sl_trust:
            temp_sentiments['trust'] += 1
            print("   trust -", i)
        
       

    for key, val in temp_sentiments.items():
         if val > highest_sent_value:
            highest_sent = key
            highest_sent_value = val

    
    #WAIT UNTIL WE'VE GONE THROUGH ALL THE WORDS BEFORE DECIDING THE OUTCOME
    if highest_sent != 'nada':
        tweet_dict[tweet] = highest_sent
        print(" -- FINAL TWEET PV", tweet_dict[tweet])
        
        if highest_sent in total_beefoo_results: #ADD ONE TO OUR TOTAL RESULTS COUNTER
            total_beefoo_results[highest_sent] += 1
        else:
            total_beefoo_results[highest_sent] = 1 #IF IT DOESNT EXIST YET, ADD IT IN
            
    else:
        print(" -- NO EMOTION DETECTED")
        total_beefoo_results['nada'] += 1 #ANOTHER UNCLASSIFIED TWEET

        
        
for k, i in total_beefoo_results.items():
    print("BEEFOO ", k, i)


print("NODE COMPLETE")


# In[31]:


#CALCULATE THE PERCENT OF THE RESULTS OF EACH SENTIMENT

print("WRD-BY-WRD TOTAL")
wrd_tlt = 0
for i in total_beefoo_results.values():
    wrd_tlt += i

print("TOTAL WRD_TLT", wrd_tlt)
for k, v in total_beefoo_results.items(): #RETURNS A LIST OF ALL KEYS IN THE DICTIONARY
    print("TOTAL ", k, round(((v / wrd_tlt) * 100), 1), "%")
    
print("NODE COMPLETE")


# In[27]:


print("----INITIALIZATION COMPLETE---")

