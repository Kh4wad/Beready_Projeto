// .eslintrc.cjs
module.exports = {
  extends: ['plugin:vue/vue3-essential', 'plugin:@typescript-eslint/recommended'],
  rules: {
    'vue/multi-word-component-names': 'off',
  },
  parserOptions: {
    parser: '@typescript-eslint/parser',
  },
}
