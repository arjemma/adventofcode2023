const { readFileSync } = require('fs');
const { join } = require('path');

const inputFile = join(__dirname, 'inputs/day6.txt');
const inputContent = readFileSync(inputFile, 'utf8').trim().split('\n');

function parseRaces(inputContent) {
    // Extract times and distances from the input file lines
    const times = inputContent[0].split(':')[1].trim().split(/\s+/).map(Number);
    const distances = inputContent[1].split(':')[1].trim().split(/\s+/).map(Number);

    // Combine times and distances into pairs for each race
    return times.map((time, index) => [time, distances[index]]);
}

function calculateWaysToWin(races) {
    let totalWays = 1;

    for (const [time, record] of races) {
        let waysToWin = 0;

        // Try each possible button-hold time (t) from 1 up to the race time - 1
        for (let t = 1; t < time; t++) {
            // Calculate distance covered with current button-hold time (t)
            const distance = t * (time - t);

            // Check if this distance beats the record
            if (distance > record) {
                waysToWin++;
            }
        }

        // Multiply the total ways by the ways to win for this race
        totalWays *= waysToWin;
    }

    return totalWays;
}

// Parse the input from the file
const races = parseRaces(inputContent);

// Calculate and print the answer
console.log("Ways to win: " + calculateWaysToWin(races));