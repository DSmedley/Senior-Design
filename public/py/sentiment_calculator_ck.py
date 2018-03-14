
# coding: utf-8

# In[2]:


#get_ipython().system('/usr/bin/python ')

#THIS IS THE MAIN, AND FINAL, CALCULATOR TO TOTAL UP ALL SENTIMENTS AND RETURN THE FINAL RESULTS

import sys 
import json 
import os 
import pandas as pd 

DEBUG = False


#TO DISCUSS!!! WOULD IT BE MORE EFFECIENT TO STORE THE SENTIMENT DICTIONARY IN JUST A REGULAR PYTHON TABLE AS OPPOSED TO A CSV FILE??

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


#3-12   --- CHANGES MADE TO WORDLIST_CSV ---
#CHANGED HATE: FEAR FROM 1 TO 0.5
#CHANGED HAPPY: ANTICIPATION FROM 1 TO 0.5
#ADDED PHOBIA (1-negative, 2-fear)

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


most_emot_tweet_dict_score = {} #YEA THESE NAMES ARE VERY LONG, BUT WITH SO MANY DICTIONARIES, WE WANT TO MAKE SURE WE DONT MIX THE UP
most_emot_tweet_dict_tweet = {} 

for i in total_beefoo_results:  # --THIS WILL GENERATE THE STARTING KEYS OF THESE DICTIONARIES
    # --BOTH OF THESE DICTIONARIES HOLD 8 KEYS, ONE FOR ALL 8 SENTIMENTS.   --(I SHOULD REALLY LOOK INTO USING THREE DIMENTIONAL LISTS INSTEAD...)
    # --ONE WILL HOLD THE CURRENT HIGHEST TWEETS SCORE, WHILE THE OTHER HOLDS THE ACTUAL TEXT OF THAT TWEET
    most_emot_tweet_dict_score[i] = 0   #BOTH OF THE DICTIONARIES USE THE 8 SENTIMENTS AS THEIR KEYS
    most_emot_tweet_dict_tweet[i] = 0


# --DECLARE SOME IMPORTANT VARIABLES BEFORE WE START
highest_emot = 0  #THIS VARIABLE WILL KEEP TRACK OF THE HIGHEST EMOTIONAL VALUE WE HAVE ENCOUNTERED IN A TWEET
most_emot_tweet = "nothing yet" #THIS VARIABLE WILL CONTAIN SAID TWEET MENTIONED ABOVE
most_emot_sentiment = "neutral"  #AND THIS ONE, THE SENTIMENT OF THAT TWEET

# --A LITTLE MORE ADVANCED. EXPLAINED FURTHER BELOW
tie_count_modifier = 0
sent_tie_count = 0


for item in data:
    #THE METHODS OF PULLING THE DATA FROM THE TABLES IS A LOT DIFFERENT. THIS MIGHT NEED TO BE CHANGED LATER
    #print(item)
    if DEBUG == True:
        tweet = item
    else:
        tweet = item['text']
    tweet_dict[tweet] = 'hi';
    tweet_pv_values[tweet] = 0;
#     temp_sentiments = {'fear': 0, 'anger': 0, 'anticipation': 0, 'trust': 0, 'surprise': 0, 'sadness': 0, 'disgust': 0, 'joy': 0} 
    #OKAY, I AM REARANGING PRIORITY INTO SOMETHING THAT MAKES MORE SENSE
    temp_sentiments = {'joy': 0, 'sadness': 0, 'anger': 0, 'fear': 0, 'anticipation': 0, 'surprise': 0, 'disgust': 0, 'trust': 0} 
    temp_pv = 0
    highest_sent = 'nada'
    highest_sent_value = 0
    sent_tie_count = 0  #NUMBER OF SENTIMENTS THE HIGHEST VALUE IS CURRENTLY TIED WITH

    temp_tweet_words = []
    for word in tweet.split():
        word = (word.lower())
        if word in sl_total_wordlist:
            temp_tweet_words.append(word)
            
    for i in temp_tweet_words:
        word = (i.lower())
        
        if word in sl_ang:
            temp_sentiments['anger'] += 1  #2.0 - LEAVING THESE IN IN CASE "MOST EMOTIONAL TWEET" IS USED
            total_beefoo_results['anger'] += 1  #2.0 - ADDING INSERTS INTO TOTAL RESULTS FOR EVERY WORD
        if word in sl_ant:
            temp_sentiments['anticipation'] += 1
            total_beefoo_results['anticipation'] += 1
        if word in sl_disg:
            temp_sentiments['disgust'] += 1
            total_beefoo_results['disgust'] += 1
        if word in sl_fear:
            temp_sentiments['fear'] += 1
            total_beefoo_results['fear'] += 1
        if word in sl_joy:
            temp_sentiments['joy'] += 1
            total_beefoo_results['joy'] += 1
        if word in sl_sad:
            temp_sentiments['sadness'] += 1
            total_beefoo_results['sadness'] += 1
        if word in sl_surp:
            temp_sentiments['surprise'] += 1
            total_beefoo_results['surprise'] += 1
        if word in sl_trust:
            temp_sentiments['trust'] += 1
            total_beefoo_results['trust'] += 1
        
        if word in sl_positive:
            temp_pv += 1
        if word in sl_negative:
            temp_pv -= 1
        
        #NOW JUST ADD 1 TO THE SENTIMENT IT COUNTS FOR. IF IT DOESNT EXIST YET, ADD IT IN
#         if word in total_beefoo_results:   #
#             total_beefoo_results[word] += 1
#         else:
#             total_beefoo_results[word] = 1
    
    #2.0 - GETTING RID OF THIS NOW THAT ALL SENTIMENT VALUES WILL BE COMBINED
#     if highest_sent != 'nada':
#         tweet_dict[tweet] = highest_sent
        
#         if highest_sent in total_beefoo_results:
#             total_beefoo_results[highest_sent] += 1
#         else:
#             total_beefoo_results[highest_sent] = 1
            
#     else:
#         total_beefoo_results['nada'] += 1
    
    
    #THIS, WE'LL LEAVE IN. I THINK
    if temp_pv > 0:
        tweet_pv_values[tweet] = 'positive'
        total_pv_results['positive'] += 1
    elif temp_pv < 0:
        tweet_pv_values[tweet] = 'negative'
        total_pv_results['negative'] += 1
    else:
        tweet_pv_values[tweet] = 'neutral'
        total_pv_results['neutral'] += 1
    
    
    
    
    
    #EVERYTHING AFTER THIS POINT IS A WIP AND WILL NOT BE USED IN THE NEXT DEMO. I AM SETTING IT TO DEBUG MODE ONLY
    if DEBUG == True:
    
        #EACH SENTIMENT HAS IT'S OWN "MOST EMOTIONAL TWEET" 
        for key, val in temp_sentiments.items():
            #3-11-18 THIS WILL COUNT THE NUMBER OF SENTIMENTS TIED IN SCORE, FAVORING SENTIMENTS THAT ARE FURTHER AHEAD THAN THE REST OF THE PACK
            if val > highest_sent_value:   #IF THE SCORE IS HIGHER, JUST REPLACE IT AND RESET ALL COUNTERS
                highest_sent = key  
                highest_sent_value = val
                sent_tie_count = 0
            elif val == highest_sent_value: #IF THE SCORE IS TIED WITH ANOTHER SCORE, ADD 1 TO THE NUMBER OF TIED WINNERS
                sent_tie_count += 1
                #THIS NUMBER IS TO HELP WEIGH "MOST EMOT" TWEET SCORES HIGHER, THE LESS NUMBER OF SENTS THEY ARE TIED WITH


        # --THE LESS COMPETITION THE SENTIMENT HAS FOR THE #1 SPOT, THE MORE LIKELY IT IS TO BE TRUE.
        tie_count_modifier = (4 - sent_tie_count) / 10
    #     tie_count_modifier = 0 #REVERTING THIS TO 0 FOR TESTING BECAUSE APPARENTLY THE NUMBER "0.1" IS FUCKED UP IN PYTHON
        # --THIS WILL HELP INCREASE SENTIMENT PRIORITY WHEN TIED WITH ANOTHER TWEET WITH SENTIMENT SCORES ALL OVER THE PLACE
        # --IN THIS CASE, TWEETS WITH SCORES TIED IN 4 OR MORE SENTIMENTS WILL ACTUALLY RANK DOWN LOWER THAN NORMAL ONES.
        # --THIS MODIFIER IS ONLY USED IN RANKING "MOST EMOTIONAL TWEETS" AND NOT USED IN THE FINAL PERCENTAGE OUTCOMES FOR EACH SENTIMENT


        #SINCE SOME TWEETS HAVE SUCH OVERPOWERING SENTIMENT SCORES, THEY WOULD OFTEN BECOME THE HIGHEST_EMOT TWEET FOR MULTIPLE SENTIMENTS.
        #LETS ENSURE THAT ONE TWEET CANT BE THE HIGHEST_EMOT_TWEET FOR MORE THAN ONE SENTIMENT
        largest_emo_diff = 0 #TO HELP DECIDE WHICH SENTIMENT WILL RECEIVE THE NEW HIGHEST EMOT_TWEET WHEN ONE IS FOUND (SO IT WONT GO TO MORE THAN 1)
        largest_emo_diff_sent = "none"
        largest_emo_diff_bankscore = 0 #3-12 THE PRIZE POT OF WHAT THE "REAL" FINAL SCORE OF WHICHEVER SENTIMENT WON THE CONTEST


        for key, val in temp_sentiments.items():


            #3-11 -COMPARE THE VALUE TO THE CURRENT HIGHEST VALUE IN THE "MOST EMOTIONAL TWEET" TABLES
            emo_value = round((val + tie_count_modifier), 2) #FOR EASIER USE -- THIS IS THE VALUE OF THE SENTIMENT'S SCORE + ANY WEIGHT VALUES
            if emo_value > most_emot_tweet_dict_score[key]:
                #THE ORIGINAL METHOD, WHERE MOST_EMOT TWEETS ARENT LIMITED TO ONE SENTIMENT
    #             most_emot_tweet_dict_score[key] = emo_value
    #             most_emot_tweet_dict_tweet[key] = tweet
    #             print("HIGH EMOTIONAL TWEET: ", most_emot_tweet_dict_tweet[key], " --SENTIMENT:", key, most_emot_tweet_dict_score[key])
    #             print("MODIFIER USED", tie_count_modifier)

                #AH-AH- BEFORE WE MAKE OUR CHANGE, LETS FIRST CHECK ALL THE EMOT_TWEETS TO SEE WHICH VALUE HAS THE LARGEST SCORE DIFFERENCE
                if round((emo_value - most_emot_tweet_dict_score[key]), 2) > largest_emo_diff:
                    print("----OLD HIGH SCORE", most_emot_tweet_dict_score[key], key)
                    largest_emo_diff = round((emo_value - most_emot_tweet_dict_score[key]), 2) #THE NEW LARGEST DIFFERENCE
                    largest_emo_diff_sent = key
                    largest_emo_diff_bankscore = emo_value
                    print("NEW HIGHEST_SENT_DIFF FOUND. Difference:", round((emo_value - most_emot_tweet_dict_score[key]), 2), key)


        #NOW, !AFTER! WE HAVE DECIDED WHICH SENTIMENT NEEDS THIS NEW HIGHEST_EMO_TWEET THE MOST, WE WILL APPLY IT TO ONLY THAT SENTIMENT    
        if largest_emo_diff != 0:     #IF SCORES ARE EXACTLY THE SAME, SENTIMENT WITH HIGHEST PORT PRIORITY WILL RECEIVE IT. SUCKS TO BE 'TRUST'
            most_emot_tweet_dict_score[largest_emo_diff_sent] = largest_emo_diff_bankscore  #largest_emo_diff
            most_emot_tweet_dict_tweet[largest_emo_diff_sent] = tweet
            print("THE WINNER OF THE HIGHEST DIFF IS: ", largest_emo_diff_sent, most_emot_tweet_dict_score[largest_emo_diff_sent])




        
#A MORE VIEWER FRIENDLY VERSION OF THE OUTPUT RESULTS- FOR DEBUG MODE ONLY
if DEBUG == True:
    print("ASSOCIATION RESULTS:")

    totaltallies = 0  #GET THE TOTAL NUMBER OF RESULTS TO DEVIDE EACH SENTIMENT COUNT BY FOR PERCENTAGE
    for i in total_beefoo_results.values():
        totaltallies += i

    #RETURNS A LIST OF ALL KEYS IN THE DICTIONARY AND THEIR PERCENTILE RESULTS, HIGHEST TO LOWEST 
    for k, v in sorted(total_beefoo_results.items(), key=lambda x:x[1], reverse=True):  #ALL THAT KEY=LAMDA STUFF IS WEIRD BUT IT RETURNS ITEMS ORDERED
        print("TOTAL ", k, round(((v / totaltallies) * 100), 1), "%")
        
    print("  -- MOST EMOTIONAL TWEETS -- ")
    for k, v in most_emot_tweet_dict_tweet.items():
        print(k, most_emot_tweet_dict_score[k], v)



# BEFORE WE FINISH, ADD THE PV RESULTS ONTO THE SENTIMENT RESULTS SO WE CAN RETURN BOTH SETS OF RESULTS IN ONE STRING
for k, v in total_pv_results.items(): 
    total_beefoo_results[k] = v 



if os.path.exists(x): 
    os.remove(x) 
     
print(json.dumps(total_beefoo_results)) 

