#!/bin/bash

echo '<html><body><h1>pChart Examples</h1>' > index.html


for i in `ls -v *.php`; do
    NAME=`echo $i | sed 's/.php//'`
    TITLE=`head -n 1 ${NAME}.txt`
    echo $NAME: $TITLE
    echo "<h2>$NAME: $TITLE</h2>" >> index.html

    php -q ${NAME}.php > /dev/null 2>&1
    if [ $? -ne 0 ]; then
        echo -e "\033[31mError!\033[0m" # red
        echo '<p>Failed</p>' >> index.html
    else
        echo -e "\033[32mPassed!\033[0m" # green
        echo "<img src=\"$NAME.png\">" >> index.html
    fi
done;

echo '</body></html>' >> index.html
