
# coding: utf-8

# In[35]:


import re
import nltk
import pandas as pd
import operator #USED AT THE BOTTOM

TWEET_FILE_CSV = 'clean_tweets2.csv'
#'clean_tweets2.csv' #AIRLINE
#'text_emotion_ck.csv' 8 SENTIMENTS

WORD_TEST_LIST = ["awesome"]  #WHICH WORD(S) WE WANT TO TEST (REALLY ONLY USE MORE THAN 1 FOR PUNCTUATION OR MISPELLINGS)


#3-6-18 ADDING SOME TESTING ONTO THIS. LETS KEEP A LIST OF WORDS WE WANT TO COMPARE NUMBER OF POSITIVE VS NEGATIVE ASSOCIATIONS
association_dict = {}  #JUST AN EMPTY TABLE TO START. EACH NEW EMOTION WILL BE ADDED AS IT COMES ACROSS THEM 


df = pd.read_csv(TWEET_FILE_CSV)
for i, row in df.iterrows():
    index = df.index[i]
    tweet, sentiment = row
    #print(tweet)
    assoccount = 0 #KEEP TRACK OF THE NUMBER OF THAT WORD WE FIND IN THIS TWEET
    
    #GO THROUGH EACH WORD OF THE TWEET
    for i2 in tweet.split():
        i2 = i2.lower()  #MAKE SURE ITS IN LOWERCASE THO
        
        if i2 in WORD_TEST_LIST: #IF THIS WORD IS OUR TEST WORD, ADD 1 TO THE ASSOCIATION COUNT
            assoccount += 1  #AT THE END OF THE ROUND, WHICHEVER SENTIMENT THIS IS WILL WIN POINTS EQUAL TO ASSOCCOUNT
    
        
    #3-6-18  DYNAMIC DICTIONARY ADJUSTMENTS TO ADD SENTIMENTS AS THEY ARE DISCOVERED
    if not sentiment in association_dict:   #IF ITS NOT THERE, PUT IT IN THERE,
        association_dict[sentiment] = 0;
        #print("ADDING ASSOC TO DICTIONARY", sentiment)
    
    #association_dict = 1
    
    #OKAY NOW ACTUALLY COUNT THEM TOGETHER
    for k, v in association_dict.items():
        if sentiment == k:
            association_dict[k] += assoccount; #ADD 1 TO THE TALLY
            if assoccount > 0: #FOR TEST PURPOSES
                print(tweet)
                print("ASSOCIATION RESULTS  POS:", sentiment)
            
        
    

            #print("ADDED ASSOC TO", v)
    #print("ASSOCIATION RESULTS  POS:", association_dict.items())


print("ASSOCIATION RESULTS  POS:", association_dict.items())
#NOW LETS LOOK AT OUR DICTIONARY'S FINAL RESULT
totaltallies = 0
for i in association_dict.values():
    totaltallies += i
    
#print("FINAL SCORE", round((((association_dict['assoc_pos']) / (abs(association_dict['assoc_pos'] + association_dict['assoc_neg'])))*100), 1))
print("   ----FINAL SCORE FOR:", WORD_TEST_LIST[0], "----")


 #RETURNS A LIST OF ALL KEYS IN THE DICTIONARY
for k, v in sorted(association_dict.items(), key=lambda x:x[1], reverse=True):  #ALL THAT KEY=LAMDA STUFF IS WEIRD BUT IT RETURNS ITEMS ORDERED
    print("TOTAL ", k, round(((v / totaltallies) * 100), 1), "%")



print("WINNER: ", max(association_dict.items(), key=operator.itemgetter(1))[0])


# In[16]:


# for k, v in sorted(association_dict.items()): #RETURNS A LIST OF ALL KEYS IN THE DICTIONARY
#     print("TOTAL ", k, round(((v / totaltallies) * 100), 1), "%")

    
# for keys in sorted(association_dict):
#     print("WHERE THEY AT", keys)
    
# print("TOTAL LEN", len(association_dict))
# maxnum = 0
# for k in sorted(association_dict.items()): #RETURNS A LIST OF ALL KEYS IN THE DICTIONARY
# # for k in len(association_dict):
#     print("TOTAL ", k, max(association_dict.items(), key=operator.itemgetter(1))[maxnum])
#     maxnum += 1

# print("WINNER: ", max(association_dict.items(), key=operator.itemgetter(1))[0])


# In[24]:



for k, v in sorted(association_dict.items(), key=lambda x:x[1], reverse=True): #RETURNS A LIST OF ALL KEYS IN THE DICTIONARY
    print("TOTAL ", k, round(((v / totaltallies) * 100), 1), "%")

