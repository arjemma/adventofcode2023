const { readFileSync } = require('fs');
const { join } = require('path');

const inputFile = readFileSync(join(__dirname, '/inputs/day5.txt'), 'utf8');

const findMinimumLocation = (input) => {
    // Parse the initial seed ranges
    const seedData = input.split('\n')[0].split(': ')[1].split(' ').map(Number);
    const seedRanges = [];
    for (let i = 0; i < seedData.length; i += 2) {
        seedRanges.push({ start: seedData[i], length: seedData[i + 1] });
    }

    // Parse and reverse transformation mappings
    const reversedMappings = input
        .split('\n\n')
        .slice(1)
        .map(section => section.split('\n').slice(1).map(entry => entry.split(' ').map(Number)))
        .reverse();

    // Helper function to apply transformations in reverse
    const applyReversedMappings = (value, mappings) => {
        let transformedValue = value;
        for (const map of mappings) {
            const matchingMap = map.find(([destStart, , rangeLength]) =>
                transformedValue >= destStart && transformedValue < destStart + rangeLength
            );
            if (matchingMap) {
                const [destStart, srcStart] = matchingMap;
                transformedValue = srcStart + (transformedValue - destStart);
            }
        }
        return transformedValue;
    };

    // Helper function to check if a value is within any seed range
    const isValueInSeedRange = (value, ranges) => {
        return ranges.some(({ start, length }) => 
            value >= start && value < start + length
        );
    };

    // Main loop to find the minimum valid location
    for (let i = 0; i < 10_000_000_000; i++) {
        const transformedValue = applyReversedMappings(i, reversedMappings);
        if (isValueInSeedRange(transformedValue, seedRanges)) {
            return i;
        }
    }
};

console.log("Minimum valid location: " + findMinimumLocation(inputFile));