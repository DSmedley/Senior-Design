# Chirp Report
This is an analytics tool that can be used to analyze a Twitter account, cash tags, or hash tags. 
When analyzing a Twitter user, it will give insights around how the user displays themselves on Twitter by showing how many of their tweets
are positive, negative or neutral. It also shows the emotions (happy, sad, mad, etc.) that they display in their tweets and allows you to view their most emotional tweets.
It also shows statistical information around how they tweets. The statistics that are shown are:
- How many tweets were replies
- How many tweets @mentioned another user
- How many tweets contain hash tags
- How many tweets were retweets
- How many tweets include links
- How many tweets include media (images or videos)
- How many tweets were retweeted by other users
- How many tweets were favorited by other users

Finally, it will show you who they @mention the most and what times of the day they tweets.

When analyzing either cash tags or hash tags, it will give very similar statistical information as analyzing a specific user. For these cases, however,
the statical information is based around how other users feel about that specific hash tag or cash tag. 

# Technologies Used

This project is created with the Laravel framework as a core but it uses many other technologies on top of it. Such as:

1. Sentiment and Emotion Lexicons - A list of over 14,000 lexicons with a sentiment and emotion attached to them provided by Saif M. Mohammad. Found <a href="http://saifmohammad.com/WebPages/lexicons.html">here</a>.
2. Circliful - A jQuery plugin used to display circle percentage statistics. Found <a href="https://github.com/pguso/jquery-plugin-circliful">here</a>.
3. Chartjs - A jQuery plugin used to display pie charts and bar charts. Found <a href="http://www.chartjs.org/">here</a>.
4. Bootstrap - A CSS library used for the front end development to give it a more professional look and feel. Found <a href="https://getbootstrap.com/">here</a>.
5. Font Awesome - An icon library used throughout the site to give it a more professional look and feel. Found <a href="https://fontawesome.com">here</a>.


# Setup

This project is created with the laravel framework.

Step to setup
1. Download the code and run composer install.
2. Create your database in your dev environment for the website
3. Create your .env file from .env.example and enter your database credentials
4. run php artisan migrate
5. run php artisan key:generate

The laravel project should now be correctly configured
