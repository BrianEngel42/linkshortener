# Linkshortener

just a basic link shortener in php

# Why are you not using a database?
My first idea was to use a database.
Unfortunately it creates slightly longer urls as it gets the link id via a url parameter  
http://yourdomain.de/i?id=abF2  
vs  
http://yourdomain.de/a/abF2  
