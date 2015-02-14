(function (k, o, p, l) {
    var a = k[l.k] = {
        w: k,
        d: o,
        n: p,
        a: l,
        s: {},
        f: function () {
            return {
                callback: [],
                kill: function (b) {
                    b.parentNode && b.parentNode.removeChild(b)
                },
                get: function (b, c) {
                    var e = null;
                    return e = b[c] || b.getAttribute(c)
                },
                make: function (b) {
                    var c = false,
                        e, d;
                    for (e in b) if (b[e].hasOwnProperty) {
                        c = a.d.createElement(e);
                        for (d in b[e]) if (b[e][d].hasOwnProperty) if (typeof b[e][d] === "string") c[d] = b[e][d];
                        break
                    }
                    return c
                },
                listen: function (b, c, e) {
                    if (typeof a.w.addEventListener !== "undefined") b.addEventListener(c, e, false);
                    else typeof a.w.attachEvent !== "undefined" && b.attachEvent("on" + c, e)
                },
                getSelection: function () {
                    return ("" + (a.w.getSelection ? a.w.getSelection() : a.d.getSelection ? a.d.getSelection() : a.d.selection.createRange().text)).replace(/(^\s+|\s+$)/g, "")
                },
                pin: function (b) {
                    var c = b.getElementsByTagName("IMG")[0],
                        e = "false",
                        d = a.a.pin + "?",
                        f = (new Date).getTime();
                    if (b.rel === "video") e = "true";
                    d = d + "media=" + encodeURIComponent(c.src);
                    d = d + "&url=" + encodeURIComponent(c.getAttribute("url") || a.d.URL);
                    d = d + "&title=" + encodeURIComponent(a.d.title);
                    d = d + "&is_video=" + e;
                    d = d + "&description=" + encodeURIComponent(a.v.selectedText || c.title || c.alt);
                    a.v.hazIOS && a.w.setTimeout(function () {
                        a.w.location = "pinit12:" + d
                    }, 25);
                    a.w.open(d, "pin" + f, a.a.pop)
                },
                close: function (b) {
                    if (a.s.bg) {
                        a.d.b.removeChild(a.s.shim);
                        a.d.b.removeChild(a.s.bg);
                        a.d.b.removeChild(a.s.bd)
                    }
                    k.hazPinningNow = false;
                    b && a.w.alert(b);
                    a.v.hazGoodUrl = false;
                    a.w.scroll(0, a.v.saveScrollTop)
                },
                click: function (b) {
                    b = b || a.w.event;
                    var c = null;
                    if (c = b.target ? b.target.nodeType === 3 ? b.target.parentNode : b.target : b.srcElement) if (c === a.s.x) a.f.close();
                    else if (c.parentNode.className === a.a.k + "_pinContainer" || c.className === a.a.k + "_pinButton") {
                        a.f.pin(c.parentNode.getElementsByTagName("A")[0]);
                        a.w.setTimeout(function () {
                            a.f.close()
                        }, 10)
                    }
                },
                behavior: function () {
                    a.f.listen(a.s.bd, "click", a.f.click)
                },
                presentation: function () {
                    var b = a.f.make({
                        STYLE: {
                            type: "text/css"
                        }
                    }),
                        c = a.a.rules.join("\n").replace(/#_/g, "#" + l.k + "_").replace(/\._/g, "." + l.k + "_");
                    if (b.styleSheet) b.styleSheet.cssText = c;
                    else b.appendChild(a.d.createTextNode(c));
                    a.d.h.appendChild(b)
                },
                thumb: function (b, c, e, d, f, g) {
                    if (a.v.hazSrc[b] !== true) a.v.hazSrc[b] = true;
                    else if (!a.v.hazIE) return;
                    a.v.hazAtLeastOneGoodThumb = true;
                    d || (d = "image");
                    var h = a.f.make({
                        SPAN: {
                            className: a.a.k + "_pinContainer"
                        }
                    }),
                        j = a.f.make({
                            A: {
                                rel: d
                            }
                        }),
                        i = new Image,
                        m, n;
                    i.setAttribute("nopin", "nopin");
                    i.style.visibility = "hidden";
                    if (f) i.title = f;
                    g && i.setAttribute("url", g);
                    i.onload = function () {
                        m = this.width;
                        n = this.height;
                        this.style.marginTop = n1 && a.v.hazCalledForThumb["_" + b] !== true) {
                        a.f.call("http://vimeo.com/api/v2/video/" + b + ".json?callback=", a.f.ping.vimeo);
                        a.v.hazCalledForThumb["_" + b] = true
                    }
                    d = c.length;
                    for (f = 0; f1 && a.v.hazCalledForThumb["_" + b] !== true) {
                        a.v.hazCalledForThumb["_" + b] = true;
                        a.f.call("http://vimeo.com/api/v2/video/" + b + ".json?callback=", a.f.ping.vimeo)
                    }
                }
                d = e.length;
                for (f = 0; f1 && a.v.hazCalledForThumb["_" + b] !== true) {
                    a.f.call("http://vimeo.com/api/v2/video/" + b + ".json?callback=", a.f.ping.vimeo);
                    a.v.hazCalledForThumb["_" + b] = true
                }
            }
        },
        pinterest: function () {
            a.f.close(a.a.msg.installed)
        },
        facebook: function () {
            a.f.close(a.a.msg.privateDomain.replace(/%privateDomain%/, "Facebook"))
        },
        googleReader: function () {
            a.f.close(a.a.msg.privateDomain.replace(/%privateDomain%/, "Google Reader"))
        },
        stumbleUpon: function () {
            var b = 0,
                c = a.a.stumbleFrame.length,
                e;
            for (b = 0; b1)) if (a.v.hazAtLeastOneGoodThumb === false || a.v.tag.length === 0) {
            a.f.close(a.a.msg.notFound);
            return
        }
    }
    k.hazPinningNow = true
}
}
}
}()
};
a.f.init()
})(window, document, navigator, {
    k: "PIN_" + (new Date).getTime(),
    checkpoint: {
        url: "//pin.revu.co.kr/node/add/pin"
    },
    pin: "//pin.revu.co.kr/node/add/pin",
    minImgSize: 80,
    thumbCellSize: 200,
    check: ["meta", "iframe", "embed", "object", "img", "video"],
    url: {
        vimeo: /^https?:\/\/.*?\.?vimeo\.com\//,
        facebook: /^https?:\/\/.*?\.?facebook\.com\//,
        googleReader: /^https?:\/\/.*?\.?google\.com\/reader\//,
        pinterest: /^https?:\/\/.*?\.?pinterest\.com\//,
        stumbleUpon: /^https?:\/\/.*?\.?stumbleupon\.com\//
    },
    stumbleFrame: ["tb-stumble-frame", "stumbleFrame"],
    tag: {
        video: {
            youtube: {
                att: "src",
                match: [/videoplayback/]
            }
        },
        embed: {
            youtube: {
                att: "src",
                match: [/^http:\/\/s\.ytimg\.com\/yt/, /^http:\/\/.*?\.?youtube-nocookie\.com\/v/]
            }
        },
        iframe: {
            youtube: {
                att: "src",
                match: [/^http:\/\/www\.youtube\.com\/embed\/([a-zA-Z0-9\-_]+)/]
            },
            vimeo: {
                att: "src",
                match: [/^http?s:\/\/vimeo.com\/(\d+)/, /^http:\/\/player\.vimeo\.com\/video\/(\d+)/]
            }
        },
        object: {
            youtube: {
                att: "data",
                match: [/^http:\/\/.*?\.?youtube-nocookie\.com\/v/]
            }
        }
    },
    msg: {
        check: "",
        cancelTitle: "Cancel",
        bustFrame: "We need to remove the StumbleUpon toolbar before you can pin anything. Click OK to do this or Cancel to stay here.",
        noPin: "Unfortunately, this website doesn't allow pinning. You can contact the website owner with any questions you may have regarding their stance on pinning.",
        privateDomain: "Sorry, can't pin directly from %privateDomain%.",
        notFound: "Sorry, but we cannot see any big images or videos on this page to pin.",
        installed: "The pinning bookmarklet is now installed! You can click the \"Pin It\" button from your bookmarks to pin images from around the web."
    },
    pop: "status=yes,resizable=yes,scrollbars=yes,personalbar=no,directories=yes,location=yes,toolbar=yes,menubar=yes,left=0,top=0",
    rules: ["#_bg {	 position:fixed;	 z-index:8675309; top:0; right:0; bottom:0; left:0; background-color:#e2e2e2; opacity:.95; }", "	#_shim {	 position:fixed; background: transparent; z-index:8675308; top:0; right:0; bottom:0; left:0;	}", "	#_bd {	 position: absolute; text-align: left; padding-top: 36px; top: 0; left: 0; right: 0; z-index:8675320; font:16px hevetica neue,arial,san-serif;	}", "	#_bd span { zoom:1; display: inline-block; background: #fff; height:200px; width:200px; border: 1px solid #bbb; border-top: none; border-left:none; text-decoration: none; text-shadow: 0 1px #fff; position: relative; cursor: pointer; vertical-align:middle; }", "	#_bd span#_logo {	 background: #FCF9F9 url(http://pin.revu.co.kr/sites/all/themes/pinboard2/logo.png) 50% 50% no-repeat; box-shadow: none;	}", "	#_bd a#_x {	 height: 36px; line-height: 36px; position: fixed; font-size: 14px; font-weight: bold; display: block; width:auto; top: 0; left: 0; right: 0; margin: 0; background: url(http://pin.revu.co.kr/sites/all/themes/pinboard/img/fullGradient07Normal.png) repeat-x scroll 0 0 #FFFFFF; border-bottom: 1px solid #bbb; color: #211922; text-align: center; z-index:8675321;	}", "	#_bd a#_x:active {	 background-color: #211922; background-image: url(http://pin.revu.co.kr/sites/all/themes/pinboard/img/fullGradient07Inverted.png); border-color: #211922; text-shadow: 0 -1px #211922;	}", "	#_bd a#_x:hover {	 color: #fff; text-decoration: none; background-color: #900; border-color: #900; text-shadow: 1px 1px #600;	}", "	#_bd a img {	 max-height:200px; max-width:200px; top: 50%; left: 50%; position: absolute; z-index:8675312;	}", "	#_bd a b { z-index: 8675315; position: absolute; top: 50%; left: 50%; height: 50px; width: 50px; background: transparent url(http://pin.revu.co.kr/sites/all/themes/pinboard/img/VideoIndicator.png) 0 0 no-repeat; margin-top: -25px; margin-left: -25px;	}", "	#_bd a cite {	 z-index: 8675316; position: absolute; font-size: 10px; font-style: normal; bottom: 5px; width: 100px; left: 50%; margin-left: -50px; text-align: center; color: #000; background: #fff; padding: 3px;	}", "	#_bd span._pinContainer {	 z-index: 8675320; height: 200px; width: 200px; background: #fff; }", "	#_bd span._pinButton {	 z-index: 8675320; height: 200px; width: 200px; background: transparent;	}", "	#_bd span._pinButton:hover {	 height: 200px; width: 200px; background: transparent url(http://pin.revu.co.kr/sites/all/themes/pinboard/img/PinThis.png) 50% 50% no-repeat;	}"]
});
