function htmlToString(item) {
  var mapObj = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
  };
  var str = String(item).replace(/&|<|>|"/gi, function(matched){
    return mapObj[matched];
  });
  return str;
};
(function ($) {
    'use strict';
    $.fn.extend({
        mediaAutoComplete: function mediaAutoComplete() {
          this.each(function (idx, el) {
            var element = $(el);
            var choiceName = element.data('choice-name');
            var choiceValue = element.data('choice-value');
            var autocompleteValue = element.find('input.autocomplete').val();
            var loadForEditUrl = element.data('load-edit-url');
            var nameMessage = element.data('name-message');
            element.dropdown({
              delay: {
                search: 250
              },
              forceSelection: false,
              apiSettings: {
                dataType: 'JSON',
                cache: false,
                beforeSend: function beforeSend(settings) {
                  settings.data.limit = 30;
                  settings.data.criteria = {
                    search: {
                    type: 'contains',
                    value: settings.urlData.query,
                    },
                    type: 'image',
                    };
                  return settings;
                },
                onResponse: function onResponse(response) {
                  return {
                    success: true,
                    results: response._embedded.items.map(function (item) {
                      if(item[choiceName] == null){
                        return {
                          name: `<img src=" ${item.path} " alt="media-img"></img><strong> ${nameMessage} </strong> (${item.code})`,
                          value: item[choiceValue],
                        };
                      }
                      else{
                        return {
                          name: `<img src=" ${item.path} " alt="media-img"></img><strong> ${htmlToString(item[choiceName])} </strong> (${item.code})`,
                          value: item[choiceValue],
                        };
                      }
                    })
                  };
                }
              }
            });
            if (autocompleteValue.split(',').filter(String).length > 0) {
              var menuElement = element.find('div.menu');
              menuElement.api({
                on: 'now',
                method: 'GET',
                url: loadForEditUrl,
                beforeSend: function beforeSend(settings) {
                  /* eslint-disable-next-line no-param-reassign */
                  settings.data[choiceValue] = autocompleteValue.split(',').filter(String);
                  return settings;
                },
                onSuccess: function onSuccess(response) {
                  response.forEach(function (item) {
                    menuElement.append($('<div class="item" data-value="'+ item[choiceValue] + '">'  + '</div>'));
                  });
                }
              });
            }
            window.setTimeout(function () {
              element.dropdown('set selected', element.find('input.autocomplete').val().split(',').filter(String));
            }, 5000);
          });
        }
      });
})($);
(function($) {
    $(document).ready(function () {
        $('.bitbag-media-autocomplete').mediaAutoComplete();
    });
})($);