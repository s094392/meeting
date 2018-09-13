module.exports = {
  "extends": ["airbnb-base", "plugin:vue/essential"],
  "globals": {
      "axios": false,
      "_": false,
      "UIkit": false,
  },
  "settings": {
    "import/resolver": {
      "node": {
        "extensions": [
          ".js",
          ".vue"
        ]
      }
    }
  }
};
