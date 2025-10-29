// Run using: node balanced-brackets.js

const testCases = [
  { name: "Test 1", input: "({[]})", output: true },
  { name: "Test 2", input: "{[a+b]*(x+2)}", output: true },
  { name: "Test 3", input: "([2])", output: true },
  { name: "Test 4", input: "{[(])}", output: false },
];

for (const testCase of testCases) {
  const result = areBracketsBalanced(testCase.input);
  if (result === testCase.output) {
    console.log(`✅ ${testCase.name} passed.`);
  } else {
    console.log(
      `❌ ${testCase.name} failed (got ${result}, expected ${testCase.output})`
    );
  }
}

function areBracketsBalanced(str) {
  const stack = [];

  const bracketsMap = {
    "(": ")",
    "[": "]",
    "{": "}",
  };

  const bracketsMapKeys = Object.keys(bracketsMap);
  const bracketsMapValues = Object.values(bracketsMap);

  for (let i = 0; i < str.length; i++) {
    if (bracketsMapKeys.includes(str[i])) {
      stack.push(str[i]);
      continue;
    }

    if (bracketsMapValues.includes(str[i])) {
      const correspondentKey = bracketsMapKeys.find(
        (key) => bracketsMap[key] === str[i]
      );

      if (correspondentKey !== stack.pop()) {
        return false;
      }
    }
  }

  return true;
}
