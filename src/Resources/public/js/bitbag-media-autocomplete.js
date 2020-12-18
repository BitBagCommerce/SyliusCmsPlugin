(function ($) {
    'use strict';
    $.fn.extend({
        mediaAutoComplete: function mediaAutoComplete() {
          this.each(function (idx, el) {
            var element = $(el);
            var criteriaName = element.data('criteria-name');
            var choiceName = element.data('choice-name');
            var choiceValue = element.data('choice-value');
            var autocompleteValue = element.find('input.autocomplete').val();
            var loadForEditUrl = element.data('load-edit-url');
            element.dropdown({
              delay: {
                search: 250
              },
              forceSelection: false,
              apiSettings: {
                dataType: 'JSON',
                cache: false,
                beforeSend: function beforeSend(settings) {
                  /* eslint-disable-next-line no-param-reassign */
                  settings.data[criteriaName] = settings.urlData.query;

                  return settings;
                },
                onResponse: function onResponse(response) {
                  return {
                    success: true,
                    results: response.map(function (item) {
                      if(item.path == null){
                        return {
                          name: item[choiceName],
                          value: item[choiceValue]
                        };
                      }
                      else {
                        return {
                          name: '<img src="' + item.path + '" alt="media-img"></img>' + '<strong>' + item[choiceName] + '</strong>' + ' ('+ item.code + ')',
                          value: item[choiceValue]
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
