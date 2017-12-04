/* zneiat/slisten-web */
"use strict";

$(document).ready(function () {
    if (!app.checkRequirements())
        return;
});

var app = {
    PROJECT_LINK: 'https://github.com/Zneiat/slisten-web',
    AUTHOR_LINK: 'https://github.com/Zneiat',

    // 检查浏览器是否满足运行需求
    checkRequirements: function () {
        if (!!window.ActiveXObject || "ActiveXObject" in window) {
            // IE 浏览器升级提示
            alert('浏览器过时，请升级浏览器');
            window.location.href='/static/upgrade-browser.html';
            return false;
        }

        return true;
    },

    // Loading
    loadingLayer: {
        _sel: '.loading-layer',

        show: function (text) {
            var loadingElem = $(this._sel);
            loadingElem.find('.loading-layer-text').html(text || '加载中...');
            loadingElem.show();
        },

        hide: function () {
            $(this._sel).hide();
        }
    },

    mobilecheck: function () {
        var check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    },

    createEditor: function (element, autosave) {
        var toolbar = ['title', 'bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'image', 'hr', '|', 'indent', 'outdent', 'alignment'];
        var mobileToolbar = ["bold", "underline", "strikethrough", "color", "ul", "ol"];
        if (app.mobilecheck()) toolbar = mobileToolbar;

        return new Simditor({
            textarea: element,
            toolbar: toolbar,
            placeholder: '这里输入内容...',
            pasteImage: true,
            defaultImage: '',
            upload: {
                url: '/upload'
            },
            autosave: autosave
        });
    },

    writePage: {
        init: function () {
            var _this = this;
            this.$loading = $('.write-form-loading');
            this.$form = $('.write-form');
            this.$success = $('.write-form-success');
            this.$contentInput = this.$form.find('#content');

            this.editor = app.createEditor($('#content'), 'editor-content');
            this.$loading.hide();
            this.$form.show();
            this.$form.submit(this.onSubmit.bind(this));
        },

        onSubmit: function (e) {
            var _this = this;
            var $form = $(e.target);
            var url = $form.attr('action'),
                method = $form.attr('method'),
                data = $form.serializeArray();

            var contentVal = $.trim(_this.$contentInput.val());
            if (contentVal.length <= 0) {
                $.notify.warning('内容不能为空');
                _this.editor.focus();
                return false;
            }

            $.ajax({
                url: url,
                type: method,
                data: data,

                beforeSend: function () {
                    _this.$form.hide();
                    _this.$loading.show();
                },

                dataType: "json",
                success: function (obj) {
                    console.log(obj);
                    var resp = app.ajaxRespHandle(obj);
                    var data = resp.checkGetData();
                    if (!!data) {
                        _this.$loading.hide();
                        _this.$success.find('.success-text').html('信件投递成功<br/>编号：' + data['post_id']);
                        _this.$success.show();
                        _this.editor.setValue('');
                    } else {
                        _this.$loading.hide();
                        _this.$form.show();
                        if (!!data['error_inputs']) {
                            for (var name in data['error_inputs']) {
                                $.notify.error(data['error_inputs'][name]);
                                $(_this.$form.find('[name="' + name + '"]')).focus();
                            }
                        }
                    }
                },
                error: function (e) {
                    _this.$loading.hide();
                    _this.$form.show();
                    console.log(e);
                }
            });

            return false;
        }
    },

    postViewPage: {
        init: function () {
            this.initComments();
        },

        initComments: function () {
            this.$commentList = $('.comment-list');
            this.$commentListLoading = $('.comment-list-loading');

            this.$commentSend = $('.comment-send');
            this.$commentSendForm = this.$commentSend.find('.comment-send-form');
            this.$commentSendInput = this.$commentSendForm.find('#content');
            this.$commentSendFormLoading = this.$commentSend.find('.comment-send-form-loading');

            this.commentSendEditor = app.createEditor($('#content'), 'comment-send-editor');
            this.$commentSendForm.submit(this.onCommentSubmit.bind(this));
        },

        onCommentSubmit: function (e) {
            var _this = this;
            var $form = $(e.target);
            var url = $form.attr('action'),
                method = $form.attr('method'),
                data = $form.serializeArray();

            var contentVal = $.trim(_this.$commentSendInput.val());
            if (contentVal.length <= 0) {
                $.notify.warning('内容不能为空');
                _this.commentSendEditor.focus();
                return false;
            }

            $.ajax({
                url: url,
                type: method,
                data: data,

                beforeSend: function () {
                    _this.$commentSendForm.hide();
                    _this.$commentSendFormLoading.show();
                },

                dataType: "json",
                success: function (obj) {
                    console.log(obj);
                    var resp = app.ajaxRespHandle(obj);
                    var data = resp.checkGetData();
                    if (!!data) {
                        _this.$commentSendFormLoading.hide();
                        _this.$commentSendForm.show();
                        _this.commentSendEditor.setValue('');
                        $.notify.success(resp.getMsg());
                    } else {
                        _this.$commentSendFormLoading.hide();
                        _this.$commentSendForm.show();
                        if (!!data['error_inputs']) {
                            for (var name in data['error_inputs']) {
                                $.notify.error(data['error_inputs'][name]);
                                $(_this.$commentSendForm.find('[name="' + name + '"]')).focus();
                            }
                        }
                    }
                },
                error: function (e) {
                    _this.$commentSendFormLoading.hide();
                    _this.$commentSendForm.show();
                    console.log(e);
                }
            });

            return false;
        }
    },

    ajaxRespHandle: function (responseData) {
        if (!responseData || typeof responseData !== 'object' || $.isEmptyObject(responseData)) {
            app.notify.error('服务器响应数据格式错误');
            return;
        }

        var obj = {};
        obj.isSuccess = function () {
            return !!responseData['success'];
        };
        obj.getMsg = function () {
            return responseData['msg'] || '';
        };
        obj.checkGetData = function () {
            if (obj.isSuccess()) {
                return responseData['data'] || [];
            } else {
                $.notify.error(obj.getMsg());
                return false;
            }
        };
        obj.checkMakeNotify = function () {
            if (obj.isSuccess()) {
                $.notify.success(obj.getMsg());
                return true;
            } else {
                $.notify.error(obj.getMsg());
                return false;
            }
        };

        return obj;
    }
};

/* zneiat/notify-z */
$.extend({
    notify: {
        showEnabled: true,
        defaultTimeout: 4000,
        setShowEnabled: function (showEnabled) {
            if (typeof showEnabled !== 'boolean') return;
            this.showEnabled = showEnabled;
        },
        success: function (message) {
            this.show(message, 's');
        },
        error: function (message) {
            this.show(message, 'e');
        },
        info: function (message) {
            this.show(message, 'i');
        },
        warning: function (message) {
            this.show(message, 'w');
        },
        // level: s, e, i, w
        show: function (message, level, timeout) {
            console.log('[app.notify][' + level + '][' + new Date().toLocaleString() + '] ' + message);

            if (!this.showEnabled) return false;

            timeout = (typeof timeout === 'number') ? timeout : this.defaultTimeout;

            var layerElem = $('.notify-layer');
            if (layerElem.length === 0) layerElem = $('<div class="notify-layer" />').appendTo('body');

            var notifyElem = $('<div class="notify-item notify-anim-fade-in ' + (!!level ? 'type-' + level : '') + '"><p class="notify-content"></p></div>');
            notifyElem.find('.notify-content').html($('<div/>').text(message).html().replace('\n', '<br/>'));
            notifyElem.prependTo(layerElem);

            var notifyRemove = function () {
                notifyElem.addClass('notify-anim-fade-out');
                setTimeout(function () {
                    notifyElem.remove();
                }, 200);
            };

            var autoOut = true;
            notifyElem.click(function () {
                notifyRemove();
                autoOut = false;
            });

            if (timeout > 0) {
                setTimeout(function () {
                    if (!autoOut) return;
                    notifyRemove();
                }, timeout);
            }

            return true;
        }
    }
});