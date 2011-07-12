#!/bin/bash
echo Processing all examples

for i in *.php; do
   NAME=`sed 's/php//' $i`
   head -n 1 $NAME.txt
   php -q $NAME.php
done;
