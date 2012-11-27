#!/bin/bash

for i in `ls -v *.php`; do
   NAME=`echo $i | sed 's/.php//'`
   echo -n $NAME:\ 
   head -n 1 ${NAME}.txt
   php -q ${NAME}.php > /dev/null 2>&1
   if [ $? -ne 0 ]; then
      echo -e "\033[31mError!\033[0m" # red
   else
      echo -e "\033[32mPassed!\033[0m" # green
   fi
done;
