const preset = require('jest-preset-miaoxing/jest-preset');

module.exports = {
  ...preset,
  moduleNameMapper: {
    ...preset.moduleNameMapper,
    '@miaoxing/user/(.*)': '<rootDir>/$1',
    '@miaoxing/user': '<rootDir>',
  },
};
