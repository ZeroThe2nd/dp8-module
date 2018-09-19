'use strict';

class coreFunctions {
  static getKaomoji() {
    const Kaomojis = '\\(^\u0414^)/ (\u0387.\u0387) (\u02da\u0394\u02da)b (\u0387_\u0387) (^_^)b (>_<) (o^^)o (;-;) (\u2265o\u2264) \\(o_o)/ (^-^*) (=\'X\'=)'.split(' ');

    return Kaomojis[Math.floor(Math.random() * Kaomojis.length)]
  }

  static http(url) {
    const core = {
      ajax: function (method, url, args, header) {
        return new Promise(function (resolve, reject) {
          const client = new XMLHttpRequest();
          let uri = url;
          if (args && (method === 'POST' || method === 'PUT' || method === 'GET')) {
            uri += '?';
            let argCount = 0;
            for (let key in args) {
              if (args.hasOwnProperty(key)) {
                if (argCount++) {
                  uri += '&'
                }
                uri += encodeURIComponent(key) + '=' + encodeURIComponent(args[key])
              }
            }
          }
          client.open(method, uri);
          if (header) {
            for (let key in header) {
              if (header.hasOwnProperty(key)) {
                client.setRequestHeader(key, header[key])
              }
            }
          }
          client.send();
          client.onload = function () {
            if (this.status === 200) {
              resolve(this.response)
            }
            else {
              reject(this.statusText)
            }
          };
          client.onerror = function () {
            reject(this.statusText)
          }
        })
      },
    };

    // Adapter pattern
    return {
      'get': function (args, header) {
        return core.ajax('GET', url, args, header)
      },
      'post': function (args, header) {
        return core.ajax('POST', url, args, header)
      },
      'put': function (args, header) {
        return core.ajax('PUT', url, args, header)
      },
      'delete': function (args, header) {
        return core.ajax('DELETE', url, args, header)
      },
    }
  };
}

const bootVueKaomoji = () => {
  const KaomojiApp = new Vue({
    el: '#kaomojiApp',
    template: '<div class="card elevation-0 purple-900 kaomojiCard">'
      + '<div class="body">'
      + '<div v-if="loaded" class="kaomoji">{{ kaomoji }}</div>'
      + '<div v-else class="title">Loading...</div>'
      + '<p class="text-body-2 red" v-if="error.length > 0"></p>'
      + '</div><div class="actions">'
      + '<button class="md-btn small" @click="newKaomoji">'
      + '<span class="text-button">Moar!</span>'
      + '</button></div></div>',
    data: () => ({
      kaomoji: '...',
      loaded: false,
      error: ''
    }),
    created() {
      this.newKaomoji()
    },
    methods: {
      newKaomoji() {
        const self = this;
        coreFunctions.http('/kaomoji').get().then((data) => {
          try {
            data = JSON.parse(data)
          }
          catch (e) {
            self.error = 'Bad data';
            console.error("Could not parse JSON", e)
          }
          self.loaded = true;
          self.error = '';
          self.kaomoji = data.kaomoji
        }).catch((error) => {
          self.error = 'Failed to load data';
          console.error("Could not get a new Kaomoji", error)
        })
      }
    }
  });
};

window.addEventListener('load', bootVueKaomoji);
