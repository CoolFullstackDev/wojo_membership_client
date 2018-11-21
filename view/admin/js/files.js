(function($, window, document, undefined) {
    "use strict";
    var pluginName = 'Manager';

    function Plugin(element, options) {
        this.element = element;
        this._name = pluginName;
        this._defaults = $.fn.Manager.defaults;
        this.options = $.extend({}, this._defaults, options);
        this.init();
    }

    $.extend(Plugin.prototype, {
        init: function() {
            this.bindEvents();
        },


        // Bind events that trigger methods
        bindEvents: function() {
            var plugin = this;
            //var element = this.element;
            var lang = plugin.options.lang;

            //File Upload
            $('#drag-and-drop-zone').on('click', function() {
                $(this).wojoUpload({
                    url: plugin.options.url + "/helper.php",
                    dataType: 'json',
                    extraData: {
                        simpleAction: 1,
						action: "fileUpload",
                    },
                    allowedTypes: '*',
                    onBeforeUpload: function(id) {
                        plugin.update_file_status(id, 'primary', 'Uploading...');
                    },
                    onNewFile: function(id, file) {
                        plugin.add_file(id, file);
                    },
                    onUploadProgress: function(id, percent) {
                        plugin.update_file_progress(id, percent);
                    },
                    onUploadSuccess: function(id, data) {
                        if (data.type === "error") {
                            plugin.update_file_status(id, 'negative', data.message);
                            plugin.update_file_progress(id, 0);
                        } else {
                            plugin.update_file_status(id, 'positive', '<i class="icon circle check"></i>');
                            plugin.update_file_progress(id, 100);
                            $('<div class="wojo upload fitted image" style="background-color:' + data.filecolor + '">' + data.filetype + '</div>').insertBefore('#contentFile_' + id);
							$('#fileData').prepend(data.html);
							$('#item_' + data.id).velocity("transition.whirlIn");
                        }
                    },
                    onUploadError: function(id, message) {
                        plugin.update_file_status(id, 'negative', message);
                    },
                    onFallbackMode: function(message) {
                        alert('Browser not supported: ' + message);
                    },
                    onComplete: function() {
                        $("#result").append('<div class="wojo divider"></div><a class="wojo small fluid basic black button">' + lang.done + '</a>');
                        $("#result").on('click', 'a', function() {
                            $('#fileList').html('');
                            $("#result").html('');
							$('#fileData .wDimmer').dimmer({
								on: 'hover'
							});
                        });
                    }
                });
            });
        },

        addLoader: function() {
            $(this.element).prepend('<i class="icon large round chart spinning disabled"></i>');
        },

        add_file: function(id, file) {
            var template = '' +
                '<div class="item relative" id="uploadFile_' + id + '">' +
                '<div class="right floated content"><span class="wojo small medium text primary">Waiting</span></div>' +
                '<div class="content" id="contentFile_' + id + '">' +
                '<div class="header">' + file.name + '</div>' +
                '<div id="description_' + id + '" class="description wojo small text"></div>' +
                '</div>' +
                '<div class="wojo bottom attached indicating progress" data-percent="0">' +
                '<div class="bar" style="width:100%"></div>' +
                '</div>' +
                '</div>';

            $('#fileList').prepend(template);
        },

        update_file_status: function(id, status, message) {
            $('#uploadFile_' + id).find('span').html(message).toggleClass(status);
        },

        update_file_progress: function(id, percent) {
            $('#uploadFile_' + id).find('.progress').attr("data-percent", percent);
        },

    });

    $.fn.Manager = function(options) {
        this.each(function() {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });

        return this;
    };

    $.fn.Manager.defaults = {
        url: "",
        dirurl: "",
        lang: {
            delete: "Delete",
            insert: "Insert",
            download: "Download",
            unzip: "Unzip",
            size: "Size",
            lastm: "Last Modified",
            items: "items",
            done: "Done",
            home: "Home",
        }
    };

})(jQuery, window, document);