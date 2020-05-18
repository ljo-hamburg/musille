module.exports = {
  root: true,
  env: {
    node: true,
  },
  plugins: ["prettier"],
  parserOptions: {
    parser: "babel-eslint",
    ecmaVersion: 2020,
  },
  rules: {
    "no-console": "off",
    "no-debugger": "off",
  },
  extends: ["eslint:recommended", "plugin:prettier/recommended"],
};
