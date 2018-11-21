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
                monthsFull: '',
                monthsShort: '',
                weeksFull: '',
                weeksShort: '',
                weeksMed: '',
                today: "Today",
                now: "Now",
                delBtn: "Delete Record",
                trsBtn: "Move to Trash",
                arcBtn: "Move to Archive",
                uarcBtn: "Restore From Archive",
                restBtn: "Restore Item",
                canBtn: "Cancel",
                clear: "Clear",
                selProject: "Select Project",
                delMsg1: "Are you sure you want to delete this record?",
                delMsg2: "This action cannot be undone!!!",
                delMsg3: "Trash",
                delMsg5: "Move [NAME] to the archive?",
                delMsg6: "Remove [NAME] from the archive?",
                delMsg7: "Restore [NAME]?",
                delMsg8: "The item will remain in Trash for 30 days. To remove it permanently, go to Trash and empty it.",
                working: "working..."
            }
        };

        if (settings) {
            $.extend(config, settings);
        }

        $("nav > ul > li > a").click(function() {
            var isOpen = $(this).find("+ ul").is(':visible'),
                dir = isOpen ? 'slideUp' : 'slideDown';
            $(this).toggleClass("expanded collapsed").find("+ ul").velocity(dir, {
                easing: 'easeOutQuart',
                duration: 500
            });
        });
        
        /* == Nav == */
        $("#mnav").click(function() {
            if ($('aside').is(':visible')) {
                $('aside').velocity('transition.slideLeftOut', 100);
            } else {
                $('aside').velocity('transition.slideLeftIn', 100);
            }
        });

        $("#mnav-alt").click(function() {
            if ($('aside .menuwrap').is(':visible')) {
                $('aside .menuwrap').velocity(
                    'slideUp', {
                        duration: 200,
                        complete: function() {
                            $('aside .menuwrap').css('display', '');
                        }
                    });

            } else {
                $('aside .menuwrap').velocity('slideDown', 200);
            }
        });

        $('.wojo.dropdown').dropdown();
        $('.wojo.checkbox').checkbox();
        $('[data-content]').popup({
            variation: "mini inverted",
			inline:true,
        });

        //Dimmable
        $('.wDimmer').dimmer({
            on: 'hover'
        });
		
		/* == Responsive Tables == */
		$('.wojo.table:not(.unstackable)').responsiveTable(); 
		$("table.sorting").tablesort();
		
		$('#randPass').click(function() {
			$(this).prev('input').val($.password(8));
		});

        /* == Transitions == */
        $(document).on('click', '[data-velocity="true"]', function() {
            var type = $(this).data('type');
            var trigger = $(this).data('trigger');
            $(trigger).velocity($(trigger).is(':visible') ? 'transition.' + type + 'Out' : 'transition.' + type + 'In', {duration:200});
        });

        /* == Datepicker == */
        $('[data-datepicker]').calendar({
            firstDayOfWeek: config.weekstart,
            today: true,
            type: 'date',
            text: {
                days: config.lang.weeksShort,
                months: config.lang.monthsFull,
                monthsShort: config.lang.monthsShort,
                today: config.lang.today,
            }
        });

        /* == Time Picker == */
        $('[data-timepicker]').calendar({
            firstDayOfWeek: config.weekstart,
            today: true,
            type: 'time',
            className: {
                popup: 'wojo inverted popup',
            },
            ampm: config.ampm,
            text: {
                days: config.lang.weeksShort,
                months: config.lang.monthsFull,
                monthsShort: config.lang.monthsShort,
                now: config.lang.now
            }
        });

        /* == Tabs == */
        $(".wojo.tab.item").hide();
        $(".wojo.tab.item:first").show();
        $(".wojo.tabs:not(.responsive) a").on('click', function() {
            $(".wojo.tabs:not(.responsive) li").removeClass("active");
            $(this).parent().addClass("active");
            $(".wojo.tab.item").hide();
            var activeTab = $(this).data("tab");
			if($(activeTab).is(':first-child')) {
				$(activeTab).parent().addClass('tabbed');
			} else {
				$(activeTab).parent().removeClass('tabbed');
			}
            $(activeTab).show();
            return false;
        });

		/* == Dimmable content == */
		$(document).on('change', '.is_dimmable', function() {
			var dataset = $(this).data('set');
			var status = $(this).checkbox('is checked') ? 1 : 0;
			var result = $.extend(true, dataset.option[0], {"active":status});
			$.post(config.url + "/helper.php", result);
			$(dataset.parent).dimmer({variation:"inverted", closable:false}).dimmer('toggle');
		}); 
		
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

        /* == Editor == */
        $('.bodypost').trumbowyg({
            svgPath: false,
            hideButtonTexts: true,
            autogrow: true,
            btns: [
                ['viewHTML'],
                ['formatting'],
                'btnGrp-semantic', ['superscript', 'subscript'],
                ['link'],
                ['insertImage'],
                'btnGrp-justify',
                'btnGrp-lists', ['horizontalRule'],
                ['removeformat'],
                ['fullscreen']
            ]
        });
		
        $('.altpost').trumbowyg({
            svgPath: false,
            hideButtonTexts: true,
            autogrow: false,
            btns: [
                ['formatting'],
                'btnGrp-semantic',
                'btnGrp-justify',
                'btnGrp-lists', ['removeformat'],
                ['fullscreen']
            ]
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
		
        /* == Inline Edit == */
        $('#editable').editableTableWidget();
        $('#editable')
            .on('validate', '[data-editable]', function(e, val) {
                if (val === "") {
                    return false;
                }
            })
            .on('change', '[data-editable]', function(e, val) {
                var data = $(this).data('set');
                var $this = $(this);
                $.ajax({
                    type: "POST",
                    url: (data.url) ? data.url : config.url + "/helper.php",
                    dataType: "json",
                    data: ({
                        'title': val,
                        'type': data.type,
                        'key': data.key,
                        'path': data.path,
                        'id': data.id,
                        'quickedit': 1
                    }),
                    beforeSend: function() {
                        $this.text(config.lang.working).animate({
                            opacity: 0.2
                        }, 800);
                    },
                    success: function(json) {
                        $this.animate({
                            opacity: 1
                        }, 800);
                        setTimeout(function() {
                            $this.html(json.title).fadeIn("slow");
                        }, 1000);
                    }
                });
            });
			
        /* == Clear Session Debug Queries == */
        $("#debug-panel").on('click', 'a.clear_session', function() {
            $.get(config.url + '/helper.php', {
                ClearSessionQueries: 1
            });
            $(this).css('color', '#222');
        });

        /* == From/To date range == */
        $('#fromdate').calendar({
            weekStart: config.weekstart,
            type: 'date',
            endCalendar: $('#enddate')
        });
        $('#enddate').calendar({
            weekStart: config.weekstart,
            type: 'date',
            startCalendar: $('#fromdate')
        });
		
        /* == Search == */
		var timeout;
        $(document).on('keyup', '#masterSearch', function() {
			var $input = $(this).parent();
			$input.addClass('loading');
			window.clearTimeout(timeout);
            var srch_string = $(this).val();
            var type_string = $(this).data('page');
            if (srch_string.length > 3) {
				timeout = window.setTimeout(function(){
					$.ajax({
						type: "get",
						dataType: 'json',
						url: config.url + '/helper.php',
						data: {
							liveSearch: 1,
							value: srch_string,
							type: type_string
						},
						success: function(json) {
							if(json.status === "success") {
								$('#mResults .padding').html(json.html);
								$('#mResults').dimmer({opacity:'.97',transition:'scale' }).dimmer('show');
							}
							$input.removeClass('loading');
							
						}
					});
				},700);
            }
            return false;
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
					$('.container')
					  .transition({
						animation  : 'scale',
						duration   : '1s',
						onComplete : function() {
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
                url: asseturl ? config.url + "/" + asseturl + "/controller.php" : config.url + "/controller.php",
                data: {
                    action: action
                },
                dataType: 'json'
            };

            $($form).ajaxForm(options).submit();
        });
		
        /* == Add/Edit Modal Actions == */
        $(document).on('click', '.addAction', function() {
            var dataset = $(this).data("set");
            var $parent = dataset.parent;
            var $this = $(this);
			var actions = '';
			var closeb = dataset.buttons === 0 ? '<a class="close"><i class="icon close"></i></a>' : '';

            $.get(config.url + dataset.url, dataset.option[0], function(data) {
				if(dataset.buttons !== false) {
					actions = '' +
                    '<div class="actions">' +
                    '<div class="wojo small cancel button">' + config.lang.canBtn + '</div>' +
                    '<button class="wojo ok small secondary button">' + dataset.label + '</button>' +
                    '</div>';
				}
                var $modal = $('<div class="wojo ' + dataset.modalclass + ' modal">' +
                    '' + closeb + '' +
					'' + data + '' +
                    '' + actions + '' +
                    '</div>');
					$($modal).modal('setting', 'onShow', function() {
					    $('.wojo.dropdown').dropdown();
						$('.wojo.checkbox').checkbox();
						$('[data-datepicker]').calendar({
							firstDayOfWeek: config.weekstart,
							today: true,
							type: 'date',
							text: {
								days: config.lang.weeksShort,
								months: config.lang.monthsFull,
								monthsShort: config.lang.monthsShort,
								today: config.lang.today,
							},
							onChange: function(date, text) {
								if (!date) {
									return '';
								}
								var day = date.getDate();
								var month = config.lang.monthsFull[date.getMonth()];
								var year = date.getFullYear();
								var formatted = month + ' ' + day + ', ' + year;
				
								var element = $(this).data('element');
								var parent = $(this).data('parent');
								$(parent).html(text);
								if ($(element).is(":input")) {
									$(element).val(text);
								} else {
									$(element).html(formatted);
								}
							}
						});
					}).modal('show').modal('setting', 'onApprove', function() {
                    var modal = this;
		
                    $('.ok.button', this).addClass('loading').prop("disabled", true);
                    function showResponse(json) {
                        setTimeout(function() {
                            $('.ok.button', modal).removeClass('loading').prop("disabled", false);
                            if (json.message) {
                                $.sticky(decodeURIComponent(json.message), {
                                    autoclose: 12000,
                                    type: json.type,
                                    title: json.title
                                });
                            }
                            if (json.type === "success") {
                                if (dataset.redirect) {
                                    setTimeout(function() {
                                        $("body").transition({
                                            animation: 'scale'
                                        });
                                        window.location.href = json.redirect;
                                    }, 800);
                                } else {
                                    switch (dataset.action) {
										case "replace":
											$($parent).html(json.html).transition('fade in');
											break;
										case "replaceWith":
											$($this).replaceWith(json.html).transition('fade in');
											break;
										case "append":
											$($parent).append(json.html).transition('bounce');
											break;
										case "prepend":
											$($parent).prepend(json.html).transition('bounce');
											break;
										case "update":
											$($parent).replaceWith(json.html).transition('fade in');
											break;
										case "insert":
											if (dataset.mode === "append") {
												$($parent).append(json.html);
											}
											if (dataset.mode === "prepend") {
												$($parent).prepend(json.html);
											}
											if (dataset.after) {
												dataset.after;
											}
											break;
										case "highlite":
											$($parent).addClass('highlite');
											break;
										default:
											break;
                                    }
									
									if (dataset.after) {
										dataset.after;
									}
									$('.wojo.dropdown').dropdown();
									$('.wojo.checkbox').checkbox();
									$(modal).modal('hide');
                                }
                            }

                        }, 500);
                    }

                    var options = {
                        target: null,
                        success: showResponse,
                        type: "post",
                        url: config.url + dataset.url,
                        data: dataset.option[0],
                        dataType: 'json'
                    };
                    $('#modal_form').ajaxForm(options).submit();

                    return false;
                }).modal('setting', 'onHidden', function() {
                    $(this).remove();
                });
            });
        });
		
        /* == Modal Delete/Archive/Trash Actions == */
        $(document).on('click', 'a.action', function() {
            var dataset = $(this).data("set");
            var $parent = $(this).closest(dataset.parent);
            var asseturl = dataset.url;
            var subtext = dataset.subtext;
            var children = dataset.children ? dataset.children[0] : null;
            var header;
            var content;
            var icon;
            var btnLabel;
            switch (dataset.action) {
                case "trash":
                    icon = "trash";
                    btnLabel = config.lang.trsBtn;
                    subtext = '<span class="wojo bold text">' + config.lang.delMsg8 + '</span>';
                    header = config.lang.delMsg3 + " <span class=\"wojo secondary text\">" + dataset.option[0].title + "?</span>";
                    content = "<i class=\"huge circular icon negative trash\"></i>";
                    break;

                case "archive":
                    icon = "briefcase";
                    btnLabel = config.lang.arcBtn;
                    header = config.lang.delMsg5.replace('[NAME]', '<span class=\"wojo secondary text\">' + dataset.option[0].title + '</span>');
                    content = "<i class=\"huge circular icon negative briefcase\"></i>";
                    break;

                case "unarchive":
                    icon = "briefcase alt";
                    btnLabel = config.lang.uarcBtn;
                    header = config.lang.delMsg6.replace('[NAME]', '<span class=\"wojo secondary text\">' + dataset.option[0].title + '</span>');
                    content = "<i class=\"huge circular icon positive briefcase alt\"></i>";
                    break;

                case "restore":
                    icon = "undo";
                    btnLabel = config.lang.restBtn;
                    subtext = '';
                    header = config.lang.delMsg7.replace('[NAME]', '<span class=\"wojo secondary text\">' + dataset.option[0].title + '</span>');
                    content = "<i class=\"huge circular icon positive undo\"></i>";
                    break;

                case "delete":
                    icon = "delete";
                    btnLabel = config.lang.delBtn;
                    subtext = '<span class="wojo bold text">' + config.lang.delMsg2 + '</span>';
                    header = config.lang.delMsg1;
                    content = "<i class=\"huge circular icon negative trash\"></i>";
                    break;
            }

            $('<div class="wojo small modal">' +
                '<div class="header">' + header + '</div>' +
                '<div class="content content-center">' + content + '' +
                '<p class="half-top-padding">' + subtext + '</p>' +
                '</div>' +
                '<div class="actions">' +
                '<div class="wojo cancel button">' + config.lang.canBtn + '</div>' +
                '<div class="wojo ok secondary button">' + btnLabel + '</div>' +
                '</div>' +
                '</div>').modal('show').modal('setting', 'onApprove', function() {
                var $this = $(this);
                $.ajax({
                    type: 'POST',
                    url: asseturl ? config.url + "/" + asseturl + "/controller.php" : config.url + "/controller.php",
                    dataType: 'json',
                    data: dataset.option[0]
                }).done(function(json) {
                    if (json.type === "success") {
                        if (dataset.redirect) {
                            $this.modal('hide');
                            $.sticky(decodeURIComponent(json.message), {
                                autoclose: 4000,
                                type: json.type,
                                title: json.title
                            });
                            setTimeout(function() {
                                $("body").transition({
                                    animation: 'scale'
                                });
                                window.location.href = dataset.redirect;
                            }, 1200);
                        } else {
                            $($parent).transition({
                                animation: 'fade',
                                duration: '1s',
                                onComplete: function() {
                                    $($parent).slideUp();
                                }
                            });
                            if (children) {
                                $.each(children, function(i, values) {
                                    $.each(values, function(k, v) {
                                        if (v === "html") {
                                            $(i).html(json[k]);
                                        } else {
                                            $(i).val(json[k]);
                                        }
                                    });
                                });
                            }

                            $('.huge.icon', $this).toggleClass('negative ' + icon + ' positive check transition hidden').transition('pulse').transition({
                                animation: 'fade out',
                                duration: '1s',
                                onComplete: function() {
                                    $this.modal('hide').remove();
                                    $.sticky(decodeURIComponent(json.message), {
                                        autoclose: 4000,
                                        type: json.type,
                                        title: json.title
                                    });
                                }
                            });
                        }

                    }

                });
                return false;

            }).modal('setting', 'onHidden', function() {
                $(this).remove();
            });
        });
    };
})(jQuery);