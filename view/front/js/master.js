(function($) {
    "use strict";
    $.Master = function(settings) {
        var config = {
            weekstart: 0,
            ampm: 0,
            url: '',
            lang: {
                button_text: "Choose file...",
                empty_text: "No file...",
            }
        };

        if (settings) {
            $.extend(config, settings);
        }

        /* == Menu == */
        $('#menu').hover(function() {
            $('.sub').removeClass('display');
            $('.actionButton').removeClass('open');
        });
        $('.actionButton').on('click', function() {
            $(this).addClass('open');
            $('.sub').addClass('display');
        });

        $("#backto").on('click', function() {
            $("#loginform").velocity("slideDown");
            $("#passform").velocity("slideUp");
        });
        $("#passreset").on('click', function() {
            $("#loginform").velocity("slideUp");
            $("#passform").velocity("slideDown");
        });

        $('.wojo.dropdown').dropdown();
        $('.wojo.checkbox').checkbox();
        $('[data-content]').popup({
            variation: "small inverted"
        });

        /* == Responsive Tables == */
        $('.wojo.table:not(.unstackable)').responsiveTable();
        $("table.sorting").tablesort();


        /* == Avatar Upload == */
        $('[data-type="image"]').ezdz({
            text: config.lang.selPic,
            validators: {
                maxWidth: 2400,
                maxHeight: 1200
            },
            reject: function(file, errors) {
                if (errors.mimeType) {
                    $.sticky(decodeURIComponent(file.name + ' must be an image.'), {
                        autoclose: 4000,
                        type: "error",
                        title: 'Error'
                    });
                }
                if (errors.maxWidth || errors.maxHeight) {
                    $.sticky(decodeURIComponent(file.name + ' must be width:2400px, and height:1200px  max.'), {
                        autoclose: 4000,
                        type: "error",
                        title: 'Error'
                    });
                }
            }
        });

        /* == View News == */
        $(".sub.news").on('click', function() {
            $.ajax({
                type: 'post',
                url: config.url + "/controller.php",
                data: {
                    'action': 'news',
                },
                dataType: "json",
                success: function(json) {
                    if (json.type === "success") {
                        $('<div class="wojo small modal">' +
                            '<div class="header">' + json.title + '</div>' +
                            '<div class="content content-center">' + json.content + '' +
                            '</div>' +
                            '</div>').modal('show');
                    }
                }
            });
        });
		
        /* == Password Reset == */
        $("button[name=passreset]").on('click', function() {
            var $btn = $(this);
            $btn.addClass('loading');
            $btn.prop('disabled', true);
            var email = $("input[name=pemail]").val();
            var fname = $("input[name=fname]").val();
            $.ajax({
                type: 'post',
                url: config.url + "/controller.php",
                data: {
                    'action': 'uResetPass',
                    'email': email,
                    'fname': fname
                },
                dataType: "json",
                success: function(json) {
                    if (json.type === "success") {
                        $("#passform .field").removeClass('error');
                        $btn.replaceWith(json.message);
                    } else {
                        $("#passform .field").addClass('error');
                    }
                    $btn.removeClass('loading');
                    $btn.prop('disabled', false);
                }
            });
        });

        /* == Account actions Reset == */
        $(".add-cart").on("click", function() {
            $(".login-form .segment").removeClass('frame');
            $(this).closest('.segment').addClass('frame');
            var id = $(this).data('id');
            $.post(config.url + "/controller.php", {
                action: "buyMembership",
                id: id
            }, function(json) {
                $("#mResult").html(json.message);
                $("#mResult").velocity('scroll', {
                    duration: 500,
                    offset: -40,
                    easing: 'ease-in-out'
                });
            }, "json");
        });

        $("#mResult").on("click", ".sGateway", function() {
            $("#mResult .sGateway").removeClass('primary');
            $(this).addClass('primary');
            var id = $(this).data('id');
            $.post(config.url + "/controller.php", {
                action: "selectGateway",
                id: id
            }, function(json) {
                $("#mResult #gdata").html(json.message);
                $("#mResult #gdata").velocity('scroll', {
                    duration: 500,
                    offset: -40,
                    easing: 'ease-in-out'
                });
            }, "json");
        });

        $("#mResult").on("click", "#cinput", function() {
            var id = $(this).data('id');
            var $this = $(this);
            var $parent = $(this).parent();
            var $input = $("input[name=coupon]");
            if (!$input.val()) {
                $parent.addClass('error');
            } else {
                $parent.addClass('loading');
                $.post(config.url + "/controller.php", {
                    action: "getCoupon",
                    id: id,
                    code: $input.val()
                }, function(json) {
                    if (json.type === "success") {
                        $parent.removeClass('error');
                        $this.toggleClass('find check');
                        $parent.prop('disabled', true);
                        $(".totaltax").html(json.tax);
                        $(".totalamt").html(json.gtotal);
                        $(".disc").html(json.disc);
                        $(".disc").parent().addClass('highlite');
                    } else {
                        $parent.addClass('error');
                    }
                    $parent.removeClass('loading');
                }, "json");
            }
        });

        /* == Simple Status Actions == */
        $(document).on('click', '.simpleAction', function() {
            var dataset = $(this).data("set");
            var $parent = dataset.parent;
            $.ajax({
                type: 'POST',
                url: config.url + dataset.url,
                dataType: 'json',
                data: dataset.option[0]
            }).done(function(json) {
                if (json.type === "success") {
                    switch (dataset.after) {
                        case "remove":
                            $($parent).transition({
                                animation: 'scale',
                                onComplete: function() {
                                    $($parent).remove();
                                }
                            });
                            break;

                        case "replace":
                            $($parent).html(json.html).transition('fade in');
                            break;

                        case "prepend":
                            $($parent).prepend(json.html).transition('fade in');
                            break;

                    }

                    if (dataset.redirect) {
                        setTimeout(function() {
                            $("body").transition({
                                animation: 'scale'
                            });
                            window.location.href = json.redirect;
                        }, 800);
                    }
                }

                if (json.message) {
                    $.sticky(decodeURIComponent(json.message), {
                        autoclose: 12000,
                        type: json.type,
                        title: json.title
                    });
                }
            });
        });


        /* == Clear Session Debug Queries == */
        $("#debug-panel").on('click', 'a.clear_session', function() {
            $.get(config.url + '/controller.php', {
                ClearSessionQueries: 1
            });
            $(this).css('color', '#222');
        });


        /* == Master Form == */
        $(document).on('click', 'button[name=dosubmit]', function() {
            var $button = $(this);
            var action = $(this).data('action');
            var $form = $(this).closest("form");
            var asseturl = $(this).data('url');

            function showResponse(json) {
                setTimeout(function() {
                    $($button).removeClass("loading").prop("disabled", false);
                }, 500);
                $.sticky(json.message, {
                    autoclose: 12000,
                    type: json.type,
                    title: json.title
                });
                if (json.type === "success" && json.redirect) {
                    $('.wojo-grid').velocity("transition.whirlOut", {
                        duration: 4000,
                        complete: function() {
                            window.location.href = json.redirect;
                        }
                    });
                }
            }

            function showLoader() {
                $($button).addClass("loading").prop("disabled", true);
            }
            var options = {
                target: null,
                beforeSubmit: showLoader,
                success: showResponse,
                type: "post",
                url: asseturl ? asseturl : config.url + "/controller.php",
                data: {
                    action: action
                },
                dataType: 'json'
            };

            $($form).ajaxForm(options).submit();
        });
    };
})(jQuery);