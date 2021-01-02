global.$ = global.jQuery = require('jquery/dist/jquery.slim');
require('bootstrap/dist/js/bootstrap.bundle');
global.flatpickr = require('flatpickr/dist/flatpickr');
global.Cleave = require('cleave.js/dist/cleave');
global.autosize = require('autosize');
global.selectize = require('selectize/dist/js/standalone/selectize');
require('peity');

class UploadPreview {

    constructor(input, preloaded) {
        const fileReader = new FileReader();
        this.options = {
            textSelector: '.form-file-text',
            target: undefined, //jQuery node
            preloaded: preloaded //filename
        }
        const options = this.options;

        const updateText = (input, text) => {
            text = text ? text : 'Elegir archivo...';
            input.next().children(options.textSelector).text(text);
        }

        function uploadListener() {
            const filename = input.val().split('\\').pop();
            updateText(input, filename);
            if (options.target != null) {
                let file = input.prop('files')[0];
                let url = URL.createObjectURL(file);

                fileReader.onload = () => {
                    options.target.attr('src', url);
                    options.target.attr('controls', true);
                };
                fileReader.readAsDataURL(file);
            }
        }

        function refreshListener() {
            let filename = options.preloaded == null ? null : options.preloaded.split('\\').pop().split('/').pop();
            updateText(input, filename);
            if (options.target != null) {
                input.attr('src', options.preloaded);
                input.attr('controls', false);
            }
        }

        input.change(uploadListener);
        $(window).on('pageshow', refreshListener);
    }

    preview(target) {
        this.options.target = target;
        return this;
    }
}

global.UploadPreview = UploadPreview;
