module.exports = {
  root: true,
  env : {
    browser: true,
    es2021 : true,
  },
  parser       : '@typescript-eslint/parser',
  parserOptions: {
    ecmaVersion: 13,
    sourceType : 'module',
  },
  plugins: ['@typescript-eslint'],
  extends: [
    'standard',
    'eslint:recommended',
    'plugin:@typescript-eslint/recommended',
    'prettier',
  ],
  rules: {
    'object-curly-spacing'   : ['error', 'always'],
    'quotes'                 : ['error', 'single'],
    'quote-props'            : ['error', 'consistent-as-needed'],
    'semi'                   : ['error', 'always'],
    'semi-spacing'           : ['error', { after: true, before: false }],
    'semi-style'             : ['error', 'last'],
    'no-extra-semi'          : 'error',
    'no-unexpected-multiline': 'error',
    'no-unreachable'         : 'error',
    'key-spacing'            : [2, {
      singleLine: {
        beforeColon: false,
        afterColon : true
      },
      multiLine: {
        beforeColon: false,
        afterColon : true,
        align      : 'colon'
      }
    }]
  },
  ignorePatterns: ['*.md']
};
