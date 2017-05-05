#!/usr/bin/env bash
for filename in docs/assets/*.svg; do
    echo "Converting $filename"
    convert "$filename" -thumbnail 30x30 -gravity center -extent 32x32 -set filename:output '%d/%t-%wx%h' '%[filename:output].png'
    convert "$filename" -thumbnail 14x14 -gravity center -extent 16x16 -set filename:output '%d/%t-%wx%h' '%[filename:output].png'
done
