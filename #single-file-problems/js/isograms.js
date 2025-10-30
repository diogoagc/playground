// Run using: node isograms.js

/*
  7 kyu — Isograms

  A word is an "isogram" if it has no repeating letters, consecutive or non-consecutive.
  Implement the function `isIsogram(str)` that returns true if the string is an isogram,
  and false otherwise.

  Rules:
  - Letter checks are case-insensitive (e.g., 'A' and 'a' are considered the same).
  - Ignore any non-letter characters (spaces, hyphens, punctuation, digits, etc.).
  - The empty string is an isogram (return true).

  Examples:
    isIsogram("Dermatoglyphics") ➜ true
    isIsogram("aba")             ➜ false
    isIsogram("moOse")           ➜ false
    isIsogram("six-year-old")    ➜ true   // hyphen ignored
*/

// -----------------------
// Test cases
// -----------------------
const testCases = [
  { name: "Test 1 — classic true", input: "Dermatoglyphics", output: true },
  { name: "Test 2 — simple true", input: "isogram", output: true },
  { name: "Test 3 — simple false", input: "aba", output: false },
  { name: "Test 4 — case-insensitive", input: "moOse", output: false },
  { name: "Test 5 — empty is true", input: "", output: true },
  { name: "Test 6 — ignore hyphen", input: "six-year-old", output: true },
  {
    name: "Test 7 — punctuation/space ignored (false)",
    input: "Hello, World!",
    output: false,
  },
  { name: "Test 8 — all unique", input: "background", output: true },
  { name: "Test 9 — all unique", input: "downstream", output: true },
  { name: "Test 10 — repeated later", input: "Alphabet", output: false },
  { name: "Test 11 — long true", input: "thumbscrew-japingly", output: true },
  { name: "Test 12 — long true", input: "subdermatoglyphic", output: true },
];

// -----------------------
// Test runner
// -----------------------
for (const tc of testCases) {
  const result = isIsogram(tc.input);
  if (result === tc.output) {
    console.log(`✅ ${tc.name} passed.`);
  } else {
    console.log(`❌ ${tc.name} failed (got ${result}, expected ${tc.output})`);
  }
}

// -----------------------
// Function under test
// -----------------------
/**
 * Returns true if `str` is an isogram per the rules above.
 * Implement this function.
 *
 * @param {string} str
 * @returns {boolean}
 */
/* function isIsogram(str) {
  const alpha = Array.from(Array(26)).map((e, i) => i + 65);
  const alphabet = alpha.map((x) => String.fromCharCode(x));

  str = str.toUpperCase();

  const seen = [];

  let i = str.length;
  while (i--) {
    if (!alphabet.includes(str[i])) {
      continue;
    }

    if (seen.includes(str[i])) {
      return false;
    }

    seen.push(str[i]);
  }

  return true;
} */

/**
 * Unicode-friendly variant (supports accents)
 */
function isIsogram(str) {
  const seen = new Set();
  for (const ch of str) {
    if (!/\p{L}/u.test(ch)) continue;
    const up = ch.toUpperCase();
    if (seen.has(up)) return false;
    seen.add(up);
  }
  return true;
}

/**
 * Fastest ASCII-only micro-opt (no regex)
 */
/* function isIsogram(str) {
  let mask = 0; // 26-bit bitmap for A-Z
  for (let i = 0; i < str.length; i++) {
    const c = str.charCodeAt(i);
    // 'A'..'Z'
    if (c >= 65 && c <= 90) {
      const bit = 1 << (c - 65);
      if (mask & bit) return false;
      mask |= bit;
      // 'a'..'z'
    } else if (c >= 97 && c <= 122) {
      const bit = 1 << (c - 97);
      if (mask & bit) return false;
      mask |= bit;
    }
    // else ignore
  }
  return true;
} */
