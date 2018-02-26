
# coding: utf-8

# In[1]:


import re
import nltk
from sklearn.feature_extraction.text import CountVectorizer


# In[2]:


#  FILE MANAGEMENT CELL

TWEET_FILE_CSV = 'text_emotion_ck.csv'
#HOWEVER, CSV FILES MUST BE CHANGED SO THAT "TWEET" CONTENT IS IN THE FIRST COLLUMN, AND "SENTIMENT" IN THE NEXT ONE. AND NO EXTRA COLLUMNS!!! DONT JUST DELETE, RIGHT CLICK AND "REMOVE ENTI COLLUMN

#DIFFERENT DATASETS WE HAVE WORKED WITH SO FAR:
#'text_emotion_ck.csv'  #CHANGED THE NAME OF IT AFTER ALTERING IT TO FIT THE 
#'clean_tweets2.csv'   --THE AIRLINE ONE


print("NODE COMPLETE")


# In[3]:


#OKAY THIS IS JUST TO HELP US EXTRACT THE REAL VALUES WE WANT OUT OF THE TEXT FILE

import pandas as pd

positivesensories = []
negativesensories = []


print("GENERATING DATA SET")
print("PLEASE WAIT....")
print("...")
    
        
# df = pd.read_csv('lexicon-sensory-words-pre.csv')
# for i, row in df.iterrows():
#     index = df.index[i]
    #a,b,c,d,e,f,g,h,i2,j = row
#     if f == 1:
#         if e == 'positive':
#             print("POSITIVE SENT", a,b,c,d)
#         elif e == 'negative':
#             print("NEGATIVE SENT", a,b,c,d)
        
#     elif e == 1:
#         if d == 'positive':
#             print("POSITIVE SENT", a,b,c)
#         elif d == 'negative':
#             print("NEGATIVE SENT", a,b,c)
            
#     elif d == 1:
#         if c == 'positive':
#             print("POSITIVE SENT", a,b)
#         elif c == 'negative':
#             print("NEGATIVE SENT", a,b)


#2-22-18 RECREATED A VERSION WHERE SNETIMENT IS IN COL-A, VALUE IN COL-B, AND ANY SYNONYMS TAKE UP REMAINING COLLUMNS ALL THE WAY UP TO F
#ANY EMPTY COLLUMNS WERE AUTOFILLED WITH "NULL" SO THE FILE COULD STILL READ THEM

#OKAY, NEW VERSION NOW THAT THE DATA HAS BEEN REFORMATTED
df = pd.read_csv('lexicon-sensory-words-pre2.csv')
for i, row in df.iterrows():
    index = df.index[i]
    a,b,c,d,e,f = row
    if a == 'positive' and b == 1: 
        positivesensories.append(c)
        #ACTUALLY... I THINK ALL THE SYNONYMS ARE ALSO USED IN THERE... NO NEED TO GO THROUGH D-F
#         if d != 'null':
#             positivesensories.append(d)
#         if e != 'null':
#             positivesensories.append(e)
#         if f != 'null':
#             positivesensories.append(f)
            
    elif a == 'negative' and b == 1:
        negativesensories.append(c)
#         if d != 'null':
#             negativesensories.append(d)
#         if e != 'null':
#             negativesensories.append(e)
#         if f != 'null':
#             negativesensories.append(f)
    
    #tweet = row
    #print("TWEET", tweet)
    #IF HATE, COMBINE WITH ANGER
    #if sentiment == "hate":
    #sentiment = "happiness"
    
    #tweets.append(tweet)
    #labels.append(sentiment)
    
    
    
#NOW LETS SEE WHAT WE GOT
# i = 0  
# while i < len(positivesensories):
#     print("POS", positivesensories[i])
#     i += 1
    
    
# i = 0  
# while i < len(negativesensories):
#     print("NEG", negativesensories[i])
#     i += 1

for i in positivesensories:
    print(i)
        
print("NODE COMPLETE")



# In[4]:


import pandas as pd

#FIRST, LETS BUILD A DICTIONARY OF ALL OF THE WORDS WE HAVE + CALCULATE THEIR POSITIVITY VALUE
positivity_dict = {}  #'happy': 1, 'angry': 3, 'love': 5

df = pd.read_csv('NRC-Emotion-Lexicon-v0.92-ck.csv')
for i, row in df.iterrows():
    index = df.index[i]
    #word, pos, neg = row
    #word = row
    word, pos, neg, ang, ant, disg, fear, joy, sad, surp, trust = row
    print(word)
    positivity_dict[word] = (pos - neg)   #A WORDS POSITIVITY VALUE IS DEFINED AS POSITIVITY MINUS NEGATIVITY. SO, EITHER -1, 0, OR 1, BASICALLY
    print(positivity_dict[word])
    if positivity_dict[word] == 0: #OKAY BUT AS OF RIGHT NOW, WE DONT CARE ABOUT 0 VALUES. DELETE THEM FROM THE DICTIONARY
        del positivity_dict[word];
    
    #tweets.append(tweet)
    #labels.append(sentiment)
    #print(sentiment)
    
    
#NEXT, LETS TAKE THE SENSORY WORDS FROM OUR PREVIOUS CELL AND ADD THEM TO THIS DICTIONARY AS WELL
for i in positivesensories: #IF ITS IN THE POSITIVE, GIVE IT A PV 1. IF NEGATIVE, GIVE IT A -1 PV
    positivity_dict[i] = 1
    
for i in negativesensories: 
    positivity_dict[i] = -1

    
#OOOOHOOKAY, WHY IS FLYING LISTED AS POSITIVE?? THATS GOING TO ROYALLY SCREW UP OUR AIRLINE RESULTS
positivity_dict['flying'] = 0
positivity_dict['customer'] = 0
positivity_dict['virgin'] = 0  #THATS AN AIRLINERS NAME!!

positivity_dict['missed'] = -1
positivity_dict['missing'] = -1
positivity_dict['canceled'] = -1 #THESE TWO DONT HAVE NEGATIVE ASSOCIATIONS WITH THEIR TENSES
positivity_dict['canceling'] = -1
    
print("NODE COMPLETE")


# In[5]:


import pandas as pd

#A DICTIONARY OF TWEETS TO KEEP A TOTAL POSITIVITY SCORE FOR EACH TWEET IN ITS FULL TEXT
tweet_dict = {'sample tweet + its positivity score': 1}  #DOES THIS REALLY NEED TO BE A DICTIONARY THOUGH?...


df = pd.read_csv(TWEET_FILE_CSV)
for i, row in df.iterrows():
    index = df.index[i]
    tweet, sentiment = row
    tweet_dict[tweet] = 0; #GIVE THE ENTIRE TWEET A DICTIONARY SLOT. GIVE ITS PV 0 BY DEFAULT
    print(tweet)
    for i2 in tweet.split():
        i2 = i2.lower()  #MAKE SURE ITS IN LOWERCASE THO
        
        if i2 in positivity_dict:   #IF A WORD IS DETECTED IN THE POSITIVITY DICTIONARY
            tweet_dict[tweet] = tweet_dict[tweet] + positivity_dict[i2]; #ADD THE WORD'S PV TO THE TWEETS TOTAL PV, WETHER IT BE POSITIVE OR NEGATIVE
            print(" ", i2, positivity_dict[i2])
        #tweet_dict[finalsentiment]
    print(tweet_dict[tweet], " -- FINAL TWEET PV")
    
    


# In[6]:


import pandas as pd

#2-24-18
#A NEW VERSION THAT KEEPS TRACK OF A SINGLE SENTIMENT INSTEAD OF A PV VALUE
beefoo_dict = {}
total_beefoo_results = {'nada': 0} #NUMBER OF EACH RESULT PER CATAGORY IN EACH TWEET


df = pd.read_csv('beefoo_lexicons_compiled.csv')
for i, row in df.iterrows():
    index = df.index[i]
    word, sent, c, d, e, f, g = row
    #print(word, sent)
    beefoo_dict[word] = sent   #A WORDS POSITIVITY VALUE IS DEFINES AS POSITIVITY MINUS NEGATIVITY. SO, EITHER -1, 0, OR 1, BASICALLY
#     if beefoo_dict[sent] == 'null': #OKAY BUT AS OF RIGHT NOW, WE DONT CARE ABOUT NULL VALUES. DELETE THEM FROM THE DICTIONARY
    if sent == 'null':   
        del beefoo_dict[word];


tweet_dict = {'sample tweet + its positivity score': 'sentiment'} 


df = pd.read_csv(TWEET_FILE_CSV)
for i, row in df.iterrows():
    index = df.index[i]
    tweet, sentiment = row
    tweet_dict[tweet] = 0;
#     temp_sentiments = [["fear", 0], ["anger", 0], ["anticipation", 0], ["trust", 0], ["surprise", 0], ["sadness", 0], ["disgust", 0], ["joy", 0]]
    #OH RIGHT. LETS FORGET LISTS. DICTIONARIES IS WHERE ITS AT
    temp_sentiments = {'fear': 0, 'anger': 0, 'anticipation': 0, 'trust': 0, 'surprise': 0, 'sadness': 0, 'disgust': 0, 'joy': 0}
    highest_sent = 'null'    #THESE TWO VARIABLES WILL BE USED TO DETERMINE WHICH SENTIMENT IS IN THE LEAD
    highest_sent_value = 0
    print(tweet)
    for i2 in tweet.split():
        i2 = i2.lower()  #MAKE SURE ITS IN LOWERCASE THO
        
        if i2 in beefoo_dict and sentiment in temp_sentiments:   #IF A WORD IS DETECTED   -and beefoo_dict[i2] in temp_sentiments
#             beefoo_dict[i2] += 1
            temp_sentiments[beefoo_dict[i2]] += 1
            #print("!!!!!!!", i2, beefoo_dict[i2], temp_sentiments[beefoo_dict[i2]])
            if temp_sentiments[beefoo_dict[i2]] > highest_sent_value: #IS THIS SENTIMENT OUR NEW HIGHEST SCORING SENTIMENT? IF IT IS, REPLACE THE OLD ONE
                highest_sent = beefoo_dict[i2]
                highest_sent_value = 0
                #print("   NEW HIGHEST SENTIMENT", highest_sent)
        #tweet_dict[finalsentiment]
    
    #WAIT UNTIL WE'VE GONE THROUGH ALL THE WORDS BEFORE DECIDING THE OUTCOME
    if highest_sent != 'null':
        tweet_dict[tweet] = highest_sent
        print(" -- FINAL TWEET PV", tweet_dict[tweet])
        
        if highest_sent in total_beefoo_results: #ADD ONE TO OUR TOTAL RESULTS COUNTER
            total_beefoo_results[highest_sent] += 1
        else:
            total_beefoo_results[highest_sent] = 1 #IF IT DOESNT EXIST YET, ADD IT IN
            
    else:
        print(" -- NO EMOTION DETECTED")
        total_beefoo_results['nada'] += 1 #ANOTHER UNCLASSIFIED TWEET
        
    


# In[7]:



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
# sl_total_wordlist = set([]) #MAYBE A SET WILL WORK BETTER?

df = pd.read_csv('NRC-Emotion-Lexicon-v0.92-ck.csv')
for i, row in df.iterrows():
    index = df.index[i]
    word, pos, neg, ang, ant, disg, fear, joy, sad, surp, trust = row
#     print(word)
    
    #CHECK THE SENTIMENT VALUE ON EVERY WORD AND ADD IT TO THE LIST OF EVERY SENTIMENT THAT IT HAS A VALUE IN
    #KIND OF A CHEESEY WAY TO DO IT, BUT OH WELL
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
    sl_total_wordlist.append(word) #LETS JUST ASSUME AT LEAST ONE SENTIMENT IS NOT 0 (THOUGH THAT ISNT ALWAYS TRUE)
#     sl_total_wordlist.add(word)
    

    
#!!! THIS JUST IN- TURNS OUT THIS SECOND LIST IS JUST SMALLER VERSION OF THE FIRST ONE WITH NO ADITIONAL INFO... WOOPS
#AND NOW, ONCE AGAIN, DO THE SAME THING FOR THE SENSORY WORDS FOR THE FILE FROMATTED WEIRDLY
# df = pd.read_csv('lexicon-sensory-words-pre2.csv')
# for i, row in df.iterrows():
#     index = df.index[i]
# #     a,b,c,d,e,f = row
#     sent, val, word ,d,e,f = row  #D E F ARE ALL SYSNONYMS, BUT POINTLESS BECAUSE THEY ARE ALL LISTED IN ROW A AT SOME POINT
#     #TODO- MAKE A VERSION OF THE CSV FILE WITH THE EXTRA ROWS TAKEN OUT TO MAKE LESS WORK FOR THE DATA TO COMB THROUGH
    
#     if val == 1:  #WHAT EVEN WAS THE PURPOSE OF STORING THEM IN DIFFERENT FORMATS ANYWAYS???
#         print("SENSORY VALUE FOUND", word)
#         if sent == 'anger':
#             sl_ang.append(word)
#         if sent == 'anticipation':
#             sl_ant.append(word)
#         if sent == 'disgust':
#             sl_disg.append(word)
#         if sent == 'fear':
#             sl_fear.append(word)
#         if sent == 'joy':
#             sl_joy.append(word)
#         if sent == 'sadness':
#             sl_sad.append(word)
#         if sent == 'surprise':
#             sl_surp.append(word)
#         if sent == 'trust':
#             sl_trust.append(word)
#         #SAME DEAL. FOR US TO KNOW ITS IN AT LEAST ONE OF THE 8 LISTS
#         if word not in sl_total_wordlist:
#             sl_total_wordlist.append(word)
#             print("ADDING SENSORY WORD TO LIST", word)
            


print("SIZE OF SENTIMENT LISTS: ", len(sl_ang), len(sl_ant), len(sl_disg), len(sl_fear), sl_joy, sl_sad, sl_surp, sl_trust)
print("TOTAL LIST LENGTH", len(sl_total_wordlist))



#OKAY, LISTS CREATED. NOW LETS GO THROUGH THOSE TWEETS
# beefoo_dict = {}
# total_beefoo_results = {'nada': 0} #NUMBER OF EACH RESULT PER CATAGORY IN EACH TWEET  --ADD "NADA" IN BY DEFAULT, THE REST WILL ADD THEMSELVES AS FOUND
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
        if word in sl_total_wordlist:
            temp_tweet_words.append(word)
            
    #NOW GO THROUGH THAT LIST OF WORDS FROM THE TWEET THAT ARE ACTUALLY IMPORTANT TO US
    for i in temp_tweet_words:
        if i in sl_ang:
            temp_sentiments['anger'] += 1
            print("   anger -", i)
        if i in sl_ant:
            temp_sentiments['anticipation'] += 1
            print("   anticipation -", i)
        if i in sl_disg:
            temp_sentiments['disgust'] += 1
            print("   disgust -", i)
        if i in sl_fear:
            temp_sentiments['fear'] += 1
            print("   fear -", i)
        if i in sl_joy:
            temp_sentiments['joy'] += 1
            print("   joy -", i)
        if i in sl_sad:
            temp_sentiments['sadness'] += 1
            print("   sadness -", i)
        if i in sl_surp:
            temp_sentiments['surprise'] += 1
            print("   surprise -", i)
        if i in sl_trust:
            temp_sentiments['trust'] += 1
            print("   trust -", i)
        
       

    for key, val in temp_sentiments.items():
         if val > highest_sent_value:
            highest_sent = key
            highest_sent_value = val
#             print(key, val)
#             highest_sent = beefoo_dict[i2]
                
            
    
    
    
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


# In[8]:


import nltk

#THIS MUST BE RUN ONCE AND THEN REMOVED
#nltk.download('popular')

def format_sentence(sent):
    return({word: True for word in nltk.word_tokenize(sent)})

print(format_sentence("The cat is very cute"))
print("NODE COMPLETE")


# In[9]:


import pandas as pd

        
tweets = []
labels = []

#WHY WAS THIS NEVER DONE UP HERE IN THE FIRST PLACE?
full = []
        
# df = pd.read_csv(TWEET_FILE_CSV)
# for i, row in df.iterrows():
#     index = df.index[i]
#     tweet, airline_sentiment = row
    
    #    #sentiment = "happiness" #ITS A TRICK!   --PART OF THAT TACKY STUDY TO TRY AND MAKE EVERYTHING HAPPY --IT ACTUALLY JUST MADE EVERYTHING ANGRYYY
    #    #if i == 1:
    #         #sentiment = "angeryyyy"
    
#     full.append([format_sentence(tweet), airline_sentiment])
    
    
        
df = pd.read_csv(TWEET_FILE_CSV)
for i, row in df.iterrows():
    index = df.index[i]
    tweet, sentiment = row
    #tweet = row
    #print("TWEET", tweet)
    #IF HATE, COMBINE WITH ANGER
    #if sentiment == "hate":
    #sentiment = "happiness"
    
#     if sentiment != 'anger':
    if sentiment == 'happiness' or sentiment == 'sadness' or sentiment == 'anger' or sentiment == 'surprise' or sentiment == 'worry' or sentiment == 'neutral':
        tweets.append(tweet)
        labels.append(sentiment)
        full.append([format_sentence(tweet), sentiment])
        #print(sentiment)
    

print(len(tweets))


print("NODE COMPLETE")


# In[10]:


#LETS ADD SOME OF OUR OWN
#REWRITING AS A LIST
addtweets = [
    ["I hate planes", "angry"],
    ["Im so happy!", "positive"],
    ["HEY AIRLINES ID RATHER TAKE A BURNING BUS TO MEXICO THAN SIT IN ONE OF YOUR METAL AIR TRAPS SUCK MY DIIIICJK", "negative"],
    ["youre alright i guess", "positive"]
]

#i = 0
#for i in addtweets:
#while i < len(addtweets):
    #extra_sentiment, extra_tweet = addtweets[i] #HAVE TO BE DECLARED IN REVERSE ORDER, APPARENTLY
#    extra_tweet, extra_sentiment = addtweets[i] #NO YOU JUST CANT USE SINGLE QUOTES IN YOUR TWEET SAMPLES. GREAT
#    tweets.append(extra_tweet)
#    labels.append(extra_sentiment)
#    i += 1
    
    
    
    
#OKAY. TRY 2
#for i, k in addtweets:
#    print(k)
#    extra_tweet = k
#    tweets.append(extra_tweet)

    
    
    
#AH! A HYBRID? LITTLE BIT OF BOTH?  --NO DONT
#i = 0
#while i < len(addtweets):
#    extra_sentiment, extra_tweet = addtweets[i]
#    labels.append(extra_sentiment)
    
    
    

#ALRIGHT. TRY 3

traincustoms = False #SET THIS TO TRUE IF YOU WANT TO SEND YOUR CUSTOMS INTO THE TRAIN TABLE, ELSE THEY WILL BE IGNORED
    
i = 0
while i < len(addtweets) and traincustoms == True:
    extra_tweet, extra_sentiment = addtweets[i]
    print(extra_tweet, extra_sentiment)
    tweets.append(extra_tweet)
    labels.append(extra_sentiment)
    i += 1
    
print(len(addtweets))
print(len(tweets))

#i = 14500 #0
#while i < len(tweets):
#    print(tweets[i], " ---- ", classifier.classify(format_sentence(tweets[i])))
#    i += 1


# In[11]:


#ALRIGHT WHATEVER. ITS A TEMP SOLUTION
#tweets1 = pd.read_csv('clean_tweets2.csv')
#OHHHHH, NO. YOU JUST NEED TO WAIT FOR THE ABOVE TO FINISH RUNNING FIRST, OR ELSE IT WONT EXIST

training_text = tweets[:int((.8)*len(tweets))]
training_labels = labels[:int((.8)*len(labels))]

test_text = tweets[int((.8)*len(tweets)):]
test_labels = labels[int((.8)*len(labels)):]
print("NODE COMPLETE")


# In[12]:


vectorizer = CountVectorizer(
    analyzer = 'word',
    lowercase = False,
    max_features = 85
)
print("NODE COMPLETE")


# In[13]:


features = vectorizer.fit_transform(
    training_text + test_text)

features_nd = features.toarray() # for easy use
print("NODE COMPLETE")


# In[14]:


from sklearn.cross_validation import train_test_split

#print("NODE COMPLETE",  X_test) 
X_train, X_test, y_train, y_test  = train_test_split(
        features_nd[0:len(training_text)], 
        training_labels,
        train_size=0.80, 
        random_state=1234)
#print("NODE COMPLETE",  X_train, X_test, y_train, y_test) 

# print("NODE COMPLETE",  training_labels) 
#NOTE, THIS NODE TENDS TO RUN CORRECTLY AS LONG AS YOU DO NOT RE-RUN NODES A CONSISTANT NUMBER OF TIMES


# In[15]:


from sklearn.linear_model import LogisticRegression
log_model = LogisticRegression()
print("NODE COMPLETE")


# In[16]:


log_model = log_model.fit(X=X_train, y=y_train)
print("NODE COMPLETE")


# In[17]:


y_pred = log_model.predict(X_test)
print("NODE COMPLETE") #OKAY I GUESS IT HAD NO PROBLEMS THIS TIME??


# In[18]:


from sklearn.metrics import accuracy_score
print(accuracy_score(y_test, y_pred))

i = 0
while i < len(y_test):
    print("Test: ", y_test[i], " Prediction: ", y_pred[i])
    i += 1


# In[19]:


#neg = []
#with open("./neg_tweets.txt", encoding="utf8") as f:
#    for i in f: 
#        neg.append([format_sentence(i), 'neg'])
       
#2-23 IS THIS MESSING WITH OUR RESULTS? IS THIS AN EXTRA? LETS REMOVE IT
# full = []
        
# df = pd.read_csv(TWEET_FILE_CSV)
# for i, row in df.iterrows():
#     index = df.index[i]
#     tweet, airline_sentiment = row
    
    #    #sentiment = "happiness" #ITS A TRICK!   --PART OF THAT TACKY STUDY TO TRY AND MAKE EVERYTHING HAPPY --IT ACTUALLY JUST MADE EVERYTHING ANGRYYY
    #    #if i == 1:
    #         #sentiment = "angeryyyy"
    
#     full.append([format_sentence(tweet), airline_sentiment])
    
print("NODE COMPLETE")
#THIS ONE TAKES A WHILE TO RUN!!  --A LOT LESS NOW THAT WE CUT OUT THE DUPLICATES

#2-23  MOVED THIS PROCESS UP TOP TO RUN AT THE SAME TIME TWEETS AND SENTIMENT TABLES ARE CREATED BECAUSE WHY WOULD YOU RUN IT TWICE???


# In[20]:


#SO WAIT, WHY IS THIS HERE AGAIN???

training = full[:int((.95)*len(full))]
test = full[int((.95)*len(full)):]

print(len(test))
print(len(training))
print("NODE COMPLETE")


# In[21]:


from nltk.classify import NaiveBayesClassifier

classifier = NaiveBayesClassifier.train(training)
print("NODE COMPLETE")


# In[22]:


example1 = "This icecream was mediocre"

print(classifier.classify(format_sentence(example1)))
print("NODE COMPLETE")


# In[23]:


classifier.show_most_informative_features()
print("NODE COMPLETE")


# In[24]:


example1 = "This icecream was mediocre"

print(classifier.classify(format_sentence(example1)))
print("NODE COMPLETE")


# In[25]:


example2 = "I'm sad that school is almost over!"

print(classifier.classify(format_sentence(example2)))


# In[26]:


example3 = "This is great!"

print(classifier.classify(format_sentence(example3)))


# In[27]:


example4 = "I had an awesome time!"

print(classifier.classify(format_sentence(example4)))


# In[28]:


from nltk.classify.util import accuracy
print(accuracy(classifier, test))
print("NODE COMPLETE")


# In[29]:


#DETERMINE WHAT OUTPUT TABLE WE WANT TO DISPLAY

OUTPUTTABLE = tweets  #tweets   #test-THIS IS A WEIRD ONE
    
    


# In[30]:


#THROW IN A FEW OF OUR OWN? WITHOUT TRAINING THEM
#SINCE THESE DONT GET TRAINED, ANY SENTIMENT ASSIGNED TO THEM WON'T BE RECOGNIZED BY THE ALGORYTHM

shorthandtweets = [
    ["Im aleargic to airplanes", "worry"],   #WOW. OKAY. NOTE TO SELF, DONT USE SINGLE-QUOTES IN TWEETS IT FUCKS UP EVERYTHING
    ["clICK hERE FOR FREE iPH0NE x- bit.shdy.lnk", "positive"],
    ["sentance", "feeling"]
]

i = 0
shorthandenabled = False #IM DISABLING THIS WHILE I WORK ON THE WORD-BY-WORD ALGORYTHM

while i < len(shorthandtweets) and shorthandenabled == True:
    extra_tweet2, extra_sentiment2 = shorthandtweets[i] #BUT NOT THIS ONE???? WHAT???
    #extra_tweet2 = shorthandtweets[i]
    #extra_sentiment2 = shorthandtweets[i]
    print(extra_sentiment2, extra_tweet2)
    tweets.append(extra_tweet2)
    labels.append(extra_sentiment2)
    i += 1



# In[31]:


#ALRIGHT. LETS JUST GO NUTS AND TEST OUT EVERY SINGLE TWEET AND SEE WHAT HAPPENS

OUTPUTTABLE = tweets  #tweets   #test


#SENTIMENT DICTIONARY: SHORTHAND TABLE THAT KEEPS TALLY OF EACH SENTIMENT'S APPEARENCE COUNT
sent_dict = {} #JUST AN EMPTY TABLE TO START. EACH NEW EMOTION WILL BE ADDED AS IT COMES ACROSS THEM

i = 0

#DO WE WANT TO CYCLE THROUGH THE WHOLE THING OR JUST THE NEW ONES?
fullcycle = "true" #REALLY NOW?? YOURE GOING TO MAKE ME DECLARE A BOOLEAN AS A STRING??
if fullcycle == "false":
    i = len(OUTPUTTABLE) - (len(shorthandtweets) + 4)
    print(len(OUTPUTTABLE))


while i < len(OUTPUTTABLE):
   # print("Test: ", y_test[i], " Prediction: ", y_pred[i])
    #print(tweet[i] + " --AND KNUCKLES-- ") #LOL NO THAT PRINTS IT VERTICALLY LETTER FOR LETTER
    #THE ACTUAL SENTIMENT OF THE SPECIFIED TWEET
    finalsentiment = classifier.classify(format_sentence(OUTPUTTABLE[i]))  #DECLARE IT HERE SO WE CAN USE IT ELSEWHERE
    finalpvvalue = tweet_dict[OUTPUTTABLE[i]]
    print(OUTPUTTABLE[i], " ---- ", finalsentiment, finalpvvalue)
    i += 1
    #if sent_dict.has_key('happy'):  #WHY NOT???  #OH, THAT METHOD WAS REMOVED LIKE 8 YEARS AGO
    if finalsentiment in sent_dict:
        sent_dict[finalsentiment] += 1; #ADD 1 TO THE TALLY
    else:
        sent_dict[finalsentiment] = 1;  #IF ITS NOT THERE, PUT IT IN THERE, AND START AT 1
        print("NEW SENTIMENT ADDED TO TALLY", finalsentiment)

        
#NOW LETS LOOK AT OUR DICTIONARY'S FINAL RESULT
totaltallies = 0
for i in sent_dict.values():
    totaltallies += i #ADD THE VALUE OF EACH 
    
print("DICTIONARY'S FINAL RESULT ", sent_dict.items())

#NOW DO IT ALL AGAIN EXCEPT DEVIDE EACH FEILD'S TOTAL BY THE NUMBER OF TOTALTALLIES FOR THE PERCENTAGE
for i in sent_dict.keys(): #RETURNS A LIST OF ALL KEYS IN THE DICTIONARY
    print("MACHINE LEARNING TOTAL ", round(((sent_dict[i] / totaltallies) * 100), 1), "%", i)
    
    
#AND ONE MORE FOR WORD-BY-WORD SENT ANALYSIS
print("WRD-BY-WRD TOTAL")
wrd_tlt = 0
for i in total_beefoo_results.values():
    wrd_tlt += i

print("TOTAL WRD_TLT", wrd_tlt)
for k, v in total_beefoo_results.items(): #RETURNS A LIST OF ALL KEYS IN THE DICTIONARY
    print("TOTAL ", k, round(((v / wrd_tlt) * 100), 1), "%")
    
#AND NOW FOR THE TOTAL POSITIVITY VALUES FROM WORD-BY-WORD COUNT
totalppv = 0 #POSITIVE PV
totalnpv = 0 #NEGATIVE PV
totalnuetrpv = 0 #NEUTRAL PV
# for i in tweet_dict.values(): #FOR REFERENCE, LETS JUST ASSIGN EACH ONE A POSITIVE/NEGATIVE VALUE VIA PV TO COMPARE
#     if i > 0:
#         totalppv += 1
#     elif i < 0:  #REALLY? WHO THE HELL CALLS IT "ELIF"?
#         totalnpv += 1
#     else:
#         totalnuetrpv += 1
        
        
#AND ONE MORE FOR WORD-BY-WORD SENT ANALYSIS
# for k, i in total_beefoo_results.items(): #FOR REFERENCE, LETS JUST ASSIGN EACH ONE A POSITIVE/NEGATIVE VALUE VIA PV TO COMPARE
#      print("BEEFOO ", k, i)
        
print("TOTAL PV POINTS")
print("NEUTRAL PV", round(((totalnuetrpv / totaltallies)*100), 1))
print("POSITIVE PV", round(((totalppv / totaltallies)*100), 1))
print("NEGATIVE PV", round(((totalnpv / totaltallies)*100), 1))

    
print("NODE COMPLETE")


# In[32]:


#AFTER SELECTING "RUN ALL" IN THE "CELL" TAB, WAIT UNTIL THE FOLLOWING SHOWS UP BEFORE STARTING TO WORK ON ANY CODE

print("NODE COMPLETE")
print("----INITIALIZATION COMPLETE---")
print("CODE IS NOW READY TO BE EDITED FREELY")

