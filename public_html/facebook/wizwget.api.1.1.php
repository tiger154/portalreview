<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:widget="http://wzdapi.com/widget/">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Won,Jeon-hwan" />
          <meta name="website" content="http://blog.naver.com/junhwen" />
        <meta name="email" content="junhwen@naver.com" />
        <meta name="apiVersion" content="1.5" />
        <meta name="keyword" content="" />
        <meta name="description" content="위젯에 대한 설명글을 입력해주세요." />
        <meta name="autoRefresh" content="0" />
        <meta name="width" content="170" />
        <meta name="height" content="250" />
        <meta name="fixedsize" content="false" />
        <meta name="ratio" content="false" />
        <title></title>
        <link rel="icon" type="image/gif" href="" />
        <link rel="richicon" type="image/gif" href="위자드팩토리에 보여질 아이콘 주소를 입력해주세요. (100x100)"
        />
        <link rel="thumbnail" type="image/gif" href="" />
        <link rel="screenshot" type="image/gif" href="" />
        <widget:preferences></widget:preferences>
        <style type="text/css">
            /*<![CDATA[*/
            .event_contents {
                text-align: center;
            }
            /*]]>*/
        </style>
        <script type="text/javascript" src="http://wzdapi.com/scripts/emulator_v1_5.js"></script>
        <script type="text/javascript">
            /*<![CDATA[*/
            var mywidget = function () {
                    return {
                        load: function () {
                            __RevuWidget2.makeFrame();
                        }
                    }
                }();
            widget.onLoad = function () {
                mywidget.load();
            };
            var __RevuWidget2 = {
                _html: '',
                _url: '',
                makeFrame: function () {
                    __RevuWidget2._url = window.location.href;
                    __RevuWidget2._html = '<if' + 'rame src="http://www.revu.co.kr/facebook/wizwget.api.php/?URL=' + __RevuWidget2._url + '" width="170" height="300" frameborder="0" marginheight="0" marginheight="0" scrolling="no">';
                    widget.body.getElementsByClassName('event_contents')[0].innerHTML = (__RevuWidget2._html);
                }
            }; /*]]>*/
        </script>
    </head>
    
    <body>
        <p class="event_contents"></p>
    </body>

</html>