<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SentimentController extends Controller
{
    public function getEmotions($input_tweets){

        $input_tweets = json_decode($input_tweets, true);
        
        
		
		
		// ------------------------------
				

		// DECLARE WHAT CSV FILES WE WILL BE LOOKING AT
		// $WORDLIST_CSV = 'C:\Users\Connor\Documents\Github\phpml\datasets\NRC-Emotion-Lexicon-v0.92-ck.csv';
		//C:\Users\Connor\Desktop\third phpml backup\phpml\datasets\NRC-Emotion-Lexicon-v0.92-ck.csv
		// 'datasets/NRC-Emotion-Lexicon-v0.92-ck.csv'

		// $SAMPLE_TWEETS = 'C:\Users\Connor\Documents\Github\phpml\datasets\text_emotion_ck.csv';
		$DEBUG = false; //FOR NOW.


		//THE LIST OF TWEETS WE WILL BE EXAMINING
		// if (file_exists('C:\Users\Connor\Documents\Github\phpml\datasets\text_emotion_ck.csv')) {
			// echo "The file $filename exists";
			// $SAMPLE_TWEETS = 'C:\Users\Connor\Documents\Github\phpml\datasets\text_emotion_ck.csv';
			// $DEBUG = true;
		// } else {
			// echo "The file does not exist";
			// //BUT IF WE'RE RECEIVING A JSON FILE, LOOP THROUGH THAT INSTEAD
			// $SAMPLE_TWEETS = json_decode( $json, true );
			// $DEBUG = false;
		// }

		//FOR NOW, MANUALLY PUT THE JSON INPUT WE WILL BE USING
		$WORDLIST_CSV = 'py/NRC-Emotion-Lexicon-v0.92-ck.csv';
		$SAMPLE_TWEETS = $input_tweets;


		//OKAY IS THIS EVEN THE RIGHT WAY TO DO IT?? LETS GIVE IT A TRY
		/*
		$array = [
			"foo" => "bar",
			"bar" => "foo",
			"hig" => "bury",
		];
		foreach ($array as $color) {
			echo "Do you like $color?\n";
		}

		var_dump($array);
		*/




		// $dataset = array_map('str_getcsv', file($WORDLIST_CSV));
		// var_dump($dataset);




		#SENTIMENT LISTS  --THESE WILL KEEP TRACK OF WHAT WORDS ARE PART OF EACH SENTIMENT. EACH SENTIMENT TABLE HOLDS A LIST OF ALL WORDS ASSOCIATED WITH IT
		$sl_positive = []; 
		$sl_negative = []; 

		$sl_ang = []; 
		$sl_ant = []; 
		$sl_disg = []; 
		$sl_fear = []; 
		$sl_joy = []; 
		$sl_sad = []; 
		$sl_surp = []; 
		$sl_trust = []; 

		$sl_total_wordlist = [];  //THIS ONE JUST HOLDS ALL WORDS ASSOCIATED WITH ANY OF THE ABOVE TABLES. 



		//STEP 1 
		// $dataset = new CsvDataset('datasets/clean_tweets.csv',1);
		// $dataset = new CsvDataset($WORDLIST_CSV,10);  //OH. CHANGE THE INPUT NUMBER TO DETERMINE HOW MANY COLLUMNS THERE ARE TO LISTEN FOR. NOT BAD
		$dataset = array_map('str_getcsv', file($WORDLIST_CSV));  //OKAY THIS IS MUCH SIMPLER AND ALSO ACTUALLY WORKS, UNLIKE THE VERSION ABOVE

		// var_dump($dataset->getSamples());

		$rowtick = 0;
		$samples = [];
		// foreach ($dataset->getSamples() as $sample) {  //OKAY, WHATEVER THE HECK THIS IS, FORGET ABOUT IT. WE'RE MAKING OUR OWN
		foreach ($dataset as $sample) {

			$samples[] = $sample[0];
			// echo 'HEY NOW '.$sample[2] . $sample[3];
			
			#CSV SENTIMENT ORDER LOOKS LIKE THIS:  word, pos, neg, ang, ant, disg, fear, joy, sad, surp, trust
			$word = $sample[0];
			// $word = new StringMaker($sample[0]);
			// echo $word;
			
			if ($sample[1] == 1){
				// sl_positive.append(word)
				$sl_positive[] = $word; //APPENDING LOOKS WEIRD IN PHP
			}
			if ($sample[2] == 1){
				$sl_negative[] = $word;
			}
			if ($sample[3] == 1){
				$sl_ang[] = $word;
			}
			if ($sample[4] == 1){
				$sl_ant[] = $word;
			}
			if ($sample[5] == 1){
				$sl_disg[] = $word;
			}
			if ($sample[6] == 1){
				$sl_fear[] = $word;
			}
			if ($sample[7] == 1){
				$sl_joy[] = $word;
			}
			if ($sample[8] == 1){
				$sl_sad[] = $word;
			}
			if ($sample[9] == 1){
				$sl_surp[] = $word;
			}
			if ($sample[10] == 1){
				$sl_trust[] = $word;
			}
				
			$sl_total_wordlist[] = $word;
			
			// $rowtick ++;
			// if($rowtick == 10){ //OKAY, I GUESS EVEN LESS...
					// // print_r($sl_total_wordlist);
					// // echo $sl_total_wordlist;
					// break;
			// }
		}



		// PRINT ALL WORDS FOUND
		// foreach ($sl_total_wordlist as $word) {
			// echo "OH MY $word \n";
		// }

		// OKAY. DICTIONARY FILLED. LETS GET TO THE HARD PART.








		// $total_beefoo_results = {"nada": 0, "anger": 0, "anticipation": 0, "disgust": 0, "fear": 0, "joy": 0, "sadness": 0, "surprise": 0, "trust": 0}
		$total_beefoo_results = ["nada" => 0, "anger" => 0, "anticipation" => 0, "disgust" => 0, "fear" => 0, "joy" => 0, "sadness" => 0, "surprise" => 0, "trust" => 0];
		$total_pv_results = ["neutral" => 0, "positive" => 0, "negative" => 0];


		$tweet_dict = ["sample tweet" => "sentiment"];
		$tweet_pv_values = ["sample tweet" => "neutral"];



		//A LARGE LIST OF ARRAYS MUST BE DECLARED TO HELP US KEEP TRACK OF "MOST EMOTIONAL TWEETS"
		#YEA THESE NAMES ARE VERY LONG, BUT WITH SO MANY DICTIONARIES, WE WANT TO MAKE SURE WE DONT MIX THE UP
		$most_emot_tweet_dict_score = ["nada" => 0, "anger" => 0, "anticipation" => 0, "disgust" => 0, "fear" => 0, "joy" => 0, "sadness" => 0, "surprise" => 0, "trust" => 0]; 
		$most_emot_tweet_dict_tweet = ["nada" => 0, "anger" => 0, "anticipation" => 0, "disgust" => 0, "fear" => 0, "joy" => 0, "sadness" => 0, "surprise" => 0, "trust" => 0]; 

		//MAYBE SOMEDAY WE MAY TRY FOR A 3 DIMENTIONAL ARRAY. BUT TODAY IS NOT THAT DAY
		// $most_emot_tweet_dict_score = ["nada" => 0, 
			// "anger" => 0 => "empt", 
			// "anticipation" => 0 => "empt", 
			// "disgust" => 0 => "empt", 
			// "fear" => 0 => "empt", 
			// "joy" => 0 => "empt", 
			// "sadness" => 0 => "empt", 
			// "surprise" => 0 => "empt", 
			// "trust" => 0 => "empt"
		// ]; 

		# --DECLARE SOME IMPORTANT VARIABLES BEFORE WE START
		$highest_emot = 0;  #THIS VARIABLE WILL KEEP TRACK OF THE HIGHEST EMOTIONAL VALUE WE HAVE ENCOUNTERED IN A TWEET
		$most_emot_tweet = "nothing yet"; #THIS VARIABLE WILL CONTAIN SAID TWEET MENTIONED ABOVE
		$most_emot_sentiment = "neutral";  #AND THIS ONE, THE SENTIMENT OF THAT TWEET

		# --A LITTLE MORE ADVANCED. EXPLAINED FURTHER BELOW
		$tie_count_modifier = 0;
		$sent_tie_count = 0;


       // error_log(var_dump($SAMPLE_TWEETS));




		//$SAMPLE_TWEETS = array_map('str_getcsv', file($SAMPLE_TWEETS));
		foreach ($SAMPLE_TWEETS as $item) {
			#THE METHODS OF PULLING THE DATA FROM THE TABLES IS A LOT DIFFERENT. THIS MIGHT NEED TO BE CHANGED LATER
			#print(item)
			/*if ($DEBUG == true){
				$tweet = $item[0];
			} else {
				$tweet = $item["text"];
			}*/
            
            //error_log(var_dump($item));
            
            $tweet = $item["text"];
			$tweet_dict[$tweet] = "hi";
			$tweet_pv_values[$tweet] = 0;
		#     $temp_sentiments = {"fear": 0, "anger": 0, "anticipation": 0, "trust": 0, "surprise": 0, "sadness": 0, "disgust": 0, "joy": 0} 
			#OKAY, I AM REARANGING PRIORITY INTO SOMETHING THAT MAKES MORE SENSE
			$temp_sentiments = ["joy" => 0, "sadness" => 0, "anger" => 0, "fear" => 0, "anticipation" => 0, "surprise" => 0, "disgust" => 0, "trust" => 0];
			$temp_pv = 0;
			$highest_sent = "nada";
			$highest_sent_value = 0;
			$sent_tie_count = 0;  #NUMBER OF SENTIMENTS THE HIGHEST VALUE IS CURRENTLY TIED WITH

			$temp_tweet_words = [];
			// for $word in $tweet.split():
			foreach (explode(" ", $tweet) as $word) {
				$word = strtolower($word);
				if (in_array($word, $sl_total_wordlist)){
					// $temp_tweet_words.append($word)
					$temp_tweet_words[] = $word;  //THIS IS HOW YOU APPEND, APPARENTLY
				}
			}


			foreach ($temp_tweet_words as $i) {
				$word = strtolower($i);
				
				// if ($word in $sl_ang){
				if (in_array($word, $sl_ang)){
					$temp_sentiments["anger"] += 1;  #2.0 - LEAVING THESE IN IN CASE "MOST EMOTIONAL TWEET" IS USED
					$total_beefoo_results["anger"] += 1;  #2.0 - ADDING INSERTS INTO TOTAL RESULTS FOR EVERY WORD
				}
				if (in_array($word, $sl_ant)){
					$temp_sentiments["anticipation"] += 1;
					$total_beefoo_results["anticipation"] += 1;
				}
				if (in_array($word, $sl_disg)){
					$temp_sentiments["disgust"] += 1;
					$total_beefoo_results["disgust"] += 1;
				}
				if (in_array($word, $sl_fear)){
					$temp_sentiments["fear"] += 1;
					$total_beefoo_results["fear"] += 1;
				}
				if (in_array($word, $sl_joy)){
					$temp_sentiments["joy"] += 1;
					$total_beefoo_results["joy"] += 1;
				}
				if (in_array($word, $sl_sad)){
					$temp_sentiments["sadness"] += 1;
					$total_beefoo_results["sadness"] += 1;
				}
				if (in_array($word, $sl_surp)){
					$temp_sentiments["surprise"] += 1;
					$total_beefoo_results["surprise"] += 1;
				}
				if (in_array($word, $sl_trust)){
					$temp_sentiments["trust"] += 1;
					$total_beefoo_results["trust"] += 1;
				}
				
				if (in_array($word, $sl_positive)){
					$temp_pv += 1;
				}
				if (in_array($word, $sl_negative)){
					$temp_pv -= 1;
				}
			}    
			
			
			#THIS, WE'LL LEAVE IN. I THINK
			if ($temp_pv > 0){
				$tweet_pv_values[$tweet] = "positive";
				$total_pv_results["positive"] += 1;
			} elseif ($temp_pv < 0){
				$tweet_pv_values[$tweet] = "negative";
				$total_pv_results["negative"] += 1;
			}else {
				$tweet_pv_values[$tweet] = "neutral";
				$total_pv_results["neutral"] += 1;
			}
			
			
			
			
			
			#EVERYTHING AFTER THIS POINT IS A WIP AND WILL NOT BE USED IN THE NEXT DEMO. I AM SETTING IT TO $DEBUG MODE ONLY
			if ($DEBUG == false){  //3-21-18 --SWITCHING TO NONDEBUG FOR LIVE USE
			
				#EACH SENTIMENT HAS IT'S OWN "MOST EMOTIONAL TWEET" 
				// for key, val in $temp_sentiments.items():
				foreach ($temp_sentiments as $key => $val) {
					#3-11-18 THIS WILL COUNT THE NUMBER OF SENTIMENTS TIED IN SCORE, FAVORING SENTIMENTS THAT ARE FURTHER AHEAD THAN THE REST OF THE PACK
					if ($val > $highest_sent_value){   #IF THE SCORE IS HIGHER, JUST REPLACE IT AND RESET ALL COUNTERS
						$highest_sent = $key;
						$highest_sent_value = $val;
						$sent_tie_count = 0;
					} elseif ($val == $highest_sent_value) { #IF THE SCORE IS TIED WITH ANOTHER SCORE, ADD 1 TO THE NUMBER OF TIED WINNERS
						$sent_tie_count += 1;
						#THIS NUMBER IS TO HELP WEIGH "MOST EMOT" TWEET SCORES HIGHER, THE LESS NUMBER OF SENTS THEY ARE TIED WITH
					}
				}

				# --THE LESS COMPETITION THE SENTIMENT HAS FOR THE #1 SPOT, THE MORE LIKELY IT IS TO BE TRUE.
				$tie_count_modifier = (4 - $sent_tie_count) / 10;
			#     tie_count_modifier = 0 #REVERTING THIS TO 0 FOR TESTING BECAUSE APPARENTLY THE NUMBER "0.1" IS FUCKED UP IN PYTHON
				# --THIS WILL HELP INCREASE SENTIMENT PRIORITY WHEN TIED WITH ANOTHER TWEET WITH SENTIMENT SCORES ALL OVER THE PLACE
				# --IN THIS CASE, TWEETS WITH SCORES TIED IN 4 OR MORE SENTIMENTS WILL ACTUALLY RANK DOWN LOWER THAN NORMAL ONES.
				# --THIS MODIFIER IS ONLY USED IN RANKING "MOST EMOTIONAL TWEETS" AND NOT USED IN THE FINAL PERCENTAGE OUTCOMES FOR EACH SENTIMENT


				#SINCE SOME TWEETS HAVE SUCH OVERPOWERING SENTIMENT SCORES, THEY WOULD OFTEN BECOME THE HIGHEST_EMOT TWEET FOR MULTIPLE SENTIMENTS.
				#LETS ENSURE THAT ONE TWEET CANT BE THE HIGHEST_EMOT_TWEET FOR MORE THAN ONE SENTIMENT
				$largest_emo_diff = 0;  #TO HELP DECIDE WHICH SENTIMENT WILL RECEIVE THE NEW HIGHEST EMOT_TWEET WHEN ONE IS FOUND (SO IT WONT GO TO MORE THAN 1)
				$largest_emo_diff_sent = "none"; 
				$largest_emo_diff_bankscore = 0;  #3-12 THE PRIZE POT OF WHAT THE "REAL" FINAL SCORE OF WHICHEVER SENTIMENT WON THE CONTEST
				

				foreach ($temp_sentiments as $key => $val) {


					#3-11 -COMPARE THE VALUE TO THE CURRENT HIGHEST VALUE IN THE "MOST EMOTIONAL TWEET" TABLES
					$emo_value = round(($val + $tie_count_modifier), 2);  #FOR EASIER USE -- THIS IS THE VALUE OF THE SENTIMENT'S SCORE + ANY WEIGHT VALUES
					if ($emo_value > $most_emot_tweet_dict_score[$key]){
						#THE ORIGINAL METHOD, WHERE MOST_EMOT TWEETS ARENT LIMITED TO ONE SENTIMENT
			#             most_emot_tweet_dict_score[key] = emo_value
			#             most_emot_tweet_dict_tweet[key] = $tweet
			#             print("HIGH EMOTIONAL TWEET: ", most_emot_tweet_dict_tweet[key], " --SENTIMENT:", key, most_emot_tweet_dict_score[key])
			#             print("MODIFIER USED", tie_count_modifier)

						#AH-AH- BEFORE WE MAKE OUR CHANGE, LETS FIRST CHECK ALL THE EMOT_TWEETS TO SEE WHICH VALUE HAS THE LARGEST SCORE DIFFERENCE
						if (round(($emo_value - $most_emot_tweet_dict_score[$key]), 2) > $largest_emo_diff){
							// echo ("----OLD HIGH SCORE: $most_emot_tweet_dict_score[$key] $key ");
							$largest_emo_diff = round(($emo_value - $most_emot_tweet_dict_score[$key]), 2);  #THE NEW LARGEST DIFFERENCE
							$largest_emo_diff_sent = $key;
							$largest_emo_diff_bankscore = $emo_value;
							// echo ("NEW HIGHEST_SENT_DIFF FOUND. Difference: round(($emo_value - $most_emot_tweet_dict_score[$key]), 2) $key");
						}
					}
				}


				#NOW, !AFTER! WE HAVE DECIDED WHICH SENTIMENT NEEDS THIS NEW HIGHEST_EMO_TWEET THE MOST, WE WILL APPLY IT TO ONLY THAT SENTIMENT    
				if ($largest_emo_diff != 0){     #IF SCORES ARE EXACTLY THE SAME, SENTIMENT WITH HIGHEST PORT PRIORITY WILL RECEIVE IT. SUCKS TO BE 'TRUST'
					$most_emot_tweet_dict_score[$largest_emo_diff_sent] = $largest_emo_diff_bankscore;  #largest_emo_diff
					$most_emot_tweet_dict_tweet[$largest_emo_diff_sent] = $tweet;
					// echo ("THE WINNER OF THE HIGHEST DIFF IS:  $largest_emo_diff_sent $most_emot_tweet_dict_score[$largest_emo_diff_sent] \n $tweet \n");
				}
			}
		}




		#A MORE VIEWER FRIENDLY VERSION OF THE OUTPUT RESULTS- FOR DEBUG MODE ONLY
		if ($DEBUG == true){
			// print("ASSOCIATION RESULTS:");
			// echo("WE'VE REACHED THE BOTTOM");
			// var_dump($total_pv_results);
			// var_dump($total_beefoo_results);

			$totaltallies = 0;  #GET THE TOTAL NUMBER OF RESULTS TO DEVIDE EACH SENTIMENT COUNT BY FOR PERCENTAGE
			foreach (array_values($total_beefoo_results) as $i) {
				$totaltallies += $i;
			}
			// for i in $total_beefoo_results.values():
				// $totaltallies += i

			// #RETURNS A LIST OF ALL KEYS IN THE DICTIONARY AND THEIR PERCENTILE RESULTS, HIGHEST TO LOWEST 
			// for k, v in sorted($total_beefoo_results.items(), key=lambda x:x[1], reverse=true):  #ALL THAT KEY=LAMDA STUFF IS WEIRD BUT IT RETURNS ITEMS ORDERED
				// print("TOTAL ", k, round(((v / $totaltallies) * 100), 1), "%")
			arsort($total_beefoo_results);  //SORT THE RESULTS TO SHOW HIGHEST RESULTS FIRST
			foreach ($total_beefoo_results as $key => $value) {
				// echo "Key: $key; Value: $value<br />\n";
				$percentile = round((($value / $totaltallies) * 100), 1);
				echo ("TOTAL: $key $percentile % \n");
			}
				
			// print("  -- MOST EMOTIONAL TWEETS -- ")
			// for k, v in most_emot_tweet_dict_tweet.items():
				// print(k, most_emot_tweet_dict_score[k], v)
				
			foreach ($most_emot_tweet_dict_tweet as $key => $value) {
				echo ("$key  $most_emot_tweet_dict_score[$key]  $value \n");
			}
			
		} else {
			// var_dump($total_beefoo_results);
			// var_dump($total_pv_results);
			
			# BEFORE WE FINISH, ADD THE PV RESULTS ONTO THE SENTIMENT RESULTS SO WE CAN RETURN BOTH SETS OF RESULTS IN ONE STRING
			foreach ($total_pv_results as $key => $value) {
				$total_beefoo_results[$key] = $value;
			}
			
			
			//3-21-18 ADDING MOST EMOTIONAL TWEETS TO THE RETURN JSON
			//--DECLARE EACH AS NADA FOR NOW  --ACTUALLY, THE CURRENT METHOD DOESN'T EVEN REQUIRE THESE YET. BUT THIS IS MINIMAL, AND WONT SLOW ANYTHING DOWN
			$top_ang = "nada"; 
			$top_ant = "nada"; 
			$top_disg = "nada"; 
			$top_fear = "nada"; 
			$top_joy = "nada"; 
			$top_sad = "nada"; 
			$top_surp = "nada"; 
			$top_trust = "nada"; 
			
			foreach ($most_emot_tweet_dict_tweet as $key => $value) {
				// echo ("$key  $most_emot_tweet_dict_score[$key]  $value \n");
				
				if ($key == "joy") {
					$top_joy = $value; //THIS IS AN EDITIED VERSION WHERE THE VARIABLE IS NOT AN ARRAY
					$total_beefoo_results["top_joy"] = $value;
				} elseif ($key == "sadness") {
					$top_sad = $value;
					$total_beefoo_results["top_sad"] = $value;
				} elseif ($key == "anger") {
					$top_ang = $value;
					$total_beefoo_results["top_ang"] = $value;
				} elseif ($key == "fear") {
					$top_fear = $value;
					$total_beefoo_results["top_fear"] = $value;
				} elseif ($key == "anticipation") {
					$top_ant = $value;
					$total_beefoo_results["top_ant"] = $value;
				} elseif ($key == "surprise") {
					$top_surp = $value;
					$total_beefoo_results["top_surp"] = $value;
				} elseif ($key == "disgust") {
					$top_disg = $value;
					$total_beefoo_results["top_disg"] = $value;
				} elseif ($key == "trust") {
					$top_trust = $value;
					$total_beefoo_results["top_trust"] = $value;
				}
			}
					
			//OKAY. NOW RETURN THE RESULTS IN A JSON FILE
			json_encode($total_beefoo_results);
				
			}
		
		
		
		
		
		
		
        
        
        return json_encode($total_beefoo_results);
    }
    
}