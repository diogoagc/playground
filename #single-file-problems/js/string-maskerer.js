// Run using: node string-reverser.js

// -----------------------
// Test cases
// -----------------------
const testCases = [
  { name: "Test 1", input: "4556364607935616", output: "############5616" },
  { name: "Test 2", input: "1", output: "1" },
  { name: "Test 3", input: "11111", output: "#1111" }
];

// -----------------------
// Test runner
// -----------------------
for (const tc of testCases) {
  const result = stringMaskerer(tc.input);
  if (result === tc.output) {
    console.log(`✅ ${tc.name} passed.`);
  } else {
    console.log(`❌ ${tc.name} failed (got ${result}, expected ${tc.output})`);
  }
}

function stringMaskerer(str) {
  const strLen = str.length;

  if (strLen <= 4) {
    return str;
  }

  const maskedPart = "#".repeat(strLen - 4);
  const visiblePart = str.slice(-4);

  return maskedPart + visiblePart;
}
