"use strict";

var mediaCharLimit = 20;
var HTMLChars = {
  "&": "&amp;",
  "<": "&lt;",
  ">": "&gt;",
  '"': "&quot;"
};

var htmlToString = function htmlToString(item) {
  return String(item).replace(/&|<|>|"/gi, function (matched) {
    return HTMLChars[matched];
  });
};

var trimValue = function trimValue(item) {
  return item.length > mediaCharLimit ?
    item.substring(0, mediaCharLimit) + "..." :
    item;
};

var optionNameTmpl = function optionNameTmpl(item, nameField, defaultName) {
  return '\n    <img src="'
    .concat(item.path, ' " alt="media-img" />\n    <strong> ')
    .concat(
      !item[nameField] ? defaultName : trimValue(htmlToString(item[nameField])),
      " </strong>\n    ("
    )
    .concat(trimValue(item.code), ")\n");
};

(function ($) {
  "use strict";

  $.fn.extend({
    mediaAutoComplete: function mediaAutoComplete() {
      this.each(function (idx, el) {
        var element = $(el);
        var _el$dataset = el.dataset,
          choiceName = _el$dataset.choiceName,
          choiceValue = _el$dataset.choiceValue,
          loadEditUrl = _el$dataset.loadEditUrl,
          nameMessage = _el$dataset.nameMessage;
        var imageDelete = element.find(".js-image-delete"),
          selectedImage = element.find(".js-selected-image"),
          autocompleteInput = element.find("input.autocomplete");
        var autocompleteValue = autocompleteInput.val();
        var autocompleteTextValues = autocompleteValue
          .split(",")
          .filter(String);

        var createDropdownFromElement = function createDropdownFromElement(
          element
        ) {
          var values =
            arguments.length > 1 && arguments[1] !== undefined ?
              arguments[1] : [];
          element.dropdown({
            delay: {
              search: 250
            },
            values: values,
            forceSelection: false,
            onChange: function () {
              imageDelete.removeClass("is-hidden");
            },
            apiSettings: {
              dataType: "JSON",
              cache: false,
              beforeSend: function beforeSend(settings) {
                settings.data.limit = 30;
                settings.data.criteria = {
                  search: {
                    type: "contains",
                    value: settings.urlData.query
                  },
                  type: "image"
                };
                return settings;
              },
              onResponse: function onResponse(response) {
                return {
                  success: true,
                  results: response._embedded.items.map(function (item) {
                    return {
                      name: optionNameTmpl(item, choiceName, nameMessage),
                      value: item[choiceValue]
                    };
                  })
                };
              }
            }
          });
        };

        if (autocompleteTextValues.length > 0) {
          var menuElement = element.find("div.menu");
          menuElement.api({
            on: "now",
            method: "GET",
            url: loadEditUrl,
            beforeSend: function beforeSend(settings) {
              /* eslint-disable-next-line no-param-reassign */
              settings.data[choiceValue] = autocompleteTextValues;
              return settings;
            },
            onSuccess: function onSuccess(response) {
              response.forEach(function (item) {
                createDropdownFromElement(element, [{
                  name: optionNameTmpl(item, choiceName, nameMessage),
                  value: item.code,
                  selected: true
                }]);
                menuElement.append(
                  $(
                    '<div class="item" data-value="'.concat(
                      item[choiceValue],
                      '"></div>'
                    )
                  )
                );
              });
            }
          });
        } else {
          createDropdownFromElement(element);
        }

        if (imageDelete.length) {
          if (autocompleteTextValues.length) {
            imageDelete.removeClass("is-hidden");
          }
          imageDelete.on("click", () => {
            imageDelete.addClass("is-hidden");
            autocompleteInput.val("");
            selectedImage.html("");
          });
        }

      });
    }
  });
})($);

(function ($) {
  $(function () {
    return $(".bitbag-media-autocomplete").mediaAutoComplete();
  });
})($);
