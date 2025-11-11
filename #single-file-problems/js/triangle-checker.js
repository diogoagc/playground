// Run using: node triangle-checker.js

// -----------------------
// Test cases
// -----------------------
const testCases = [
  { name: "Test 1", input: [1,2,2], output: true },
  { name: "Test 2", input: [7,2,2], output: false },
];

// -----------------------
// Test runner
// -----------------------
for (const tc of testCases) {
  const result = triangleChecker(...tc.input);
  if (result === tc.output) {
    console.log(`✅ ${tc.name} passed.`);
  } else {
    console.log(`❌ ${tc.name} failed (got ${result}, expected ${tc.output})`);
  }
}


function triangleChecker(a, b, c) {
  if(
    a <= 0
    || b <= 0
    || c <= 0
  ) {
    return false;
  }

  return a + b > c
    && b + c > a
    && c + a > b;
}