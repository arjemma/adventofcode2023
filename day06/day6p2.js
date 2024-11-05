const { readFileSync } = require('fs');
const { join } = require('path');

const inputFile = join(__dirname, 'inputs/day6.txt');
const inputContent = readFileSync(inputFile, 'utf8').trim().split('\n');

function parseSingleRace(inputContent) {
    // Concatenate numbers without spaces for time and distance
    const time = parseInt(inputContent[0].split(':')[1].replace(/\s+/g, ''), 10);
    const record = parseInt(inputContent[1].split(':')[1].replace(/\s+/g, ''), 10);
    return { time, record };
}

function calculateWaysToWinSingleRace(time, record) {
    let waysToWin = 0;

    // Try each possible button-hold time (t) from 1 up to time - 1
    for (let t = 1; t < time; t++) {
        // Calculate distance for this button-hold time
        const distance = t * (time - t);

        // Check if this distance beats the record
        if (distance > record) {
            waysToWin++;
        }
    }

    return waysToWin;
}

// Parse the single race data
const { time, record } = parseSingleRace(inputContent);

// Calculate and print the answer
console.log("Ways to win single race: " + calculateWaysToWinSingleRace(time, record));
