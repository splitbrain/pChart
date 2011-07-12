#!/bin/bash

for i in `ls -v *.php`; do
   NAME=`echo $i | sed 's/.php//'`
   echo -n $NAME:\ 
   head -n 1 ${NAME}.txt
   php -q ${NAME}.php > /dev/null 2>&1
   if [ $? -ne 0 ]; then
      echo -e "\033[31mError!\033[30m"
      # That's red color
   else
      echo "Passed!"
   fi
done;
