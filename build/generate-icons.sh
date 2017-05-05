#!/usr/bin/env bash
for filename in src/Icons/*.svg; do
    echo "Converting $filename"
    convert "$filename" -thumbnail 30x30 -gravity center -extent 32x32 -set filename:output 'docs/assets/%t-%wx%h' '%[filename:output].png'
    convert "$filename" -thumbnail 14x14 -gravity center -extent 16x16 -set filename:output 'docs/assets/%t-%wx%h' '%[filename:output].png'
done
