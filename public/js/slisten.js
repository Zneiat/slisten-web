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
    }
};
