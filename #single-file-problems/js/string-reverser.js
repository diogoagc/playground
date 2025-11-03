// Run using: node string-reverser.js

// -----------------------
// Test cases
// -----------------------
const testCases = [
  { name: "Test 1 — classic true", input: "world", output: "dlrow" },
  { name: "Test 2 — simple true", input: "hello", output: "olleh" },
  { name: "Test 3 — simple false", input: "", output: "" },
  { name: "Test 4 — case-insensitive", input: "h", output: "h" }
];

// -----------------------
// Test runner
// -----------------------
for (const tc of testCases) {
  const result = stringReverser(tc.input);
  if (result === tc.output) {
    console.log(`✅ ${tc.name} passed.`);
  } else {
    console.log(`❌ ${tc.name} failed (got ${result}, expected ${tc.output})`);
  }
}

function stringReverser(str) {
  let reversed = "";

  for (let index = str.length - 1; index >= 0; index--) {
    reversed += str[index];
  }

  return reversed;
}
