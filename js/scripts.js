var KEYCODE_ENTER = 13;
var KEYCODE_ESC = 27;
var XHR_STATUS_OK = 200;
(function () {
    var timer = setInterval(echoTimer, 1000);

    function echoTimer() {
        var timerElement = document.getElementById('timer');
        var now = new Date();
        var timerDate = new Date(now - startTime);
        output = 'Находитесь на сайте: ';
        var minutes = ['минуту', 'минуты', 'минут'];
        if (timerDate.getMinutes() > 0) {
            output += " " + (timerDate.getMinutes());
            output += " " + declOfNum(timerDate.getMinutes(), minutes);
        }
        var seconds = ['секунду', 'секунды', 'секунд'];
        output += " " + (timerDate.getSeconds());
        output += " " + declOfNum(timerDate.getSeconds(), seconds);

        timerElement.innerHTML = output;
    }

    function declOfNum(number, titles) {
        cases = [2, 0, 1, 1, 1, 2];
        return titles[(number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5]];
    }
}());

(function () {
        var editModeOn = false;
        document.addEventListener("DOMContentLoaded", setBooksListEvents);

        function setBooksListEvents() {
            var table = document.querySelector('#books-list');
            var textElements = table.querySelectorAll('.jsEditable');
            for (var i = 0; i < textElements.length; i++) {
                textElements[i].addEventListener('click', function (event) {
                    editText(event.target);
                });
            }
            selectList = table.querySelectorAll('.jsEditableSelect');
            for (var i = 0; i < selectList.length; i++) {
                selectList[i].addEventListener('click', editAuthor);
            }

            /**/

        }

        function editAuthor(event) {
            if (editModeOn) return;
            editModeOn = true;
            var target = event.target;
            var select = document.createElement('select');
            var content = event.target.innerHTML;

            for (var i = 0; i < AUTHORS.length; i++) {
                var option = document.createElement('option');
                option.text = AUTHORS[i];
                if (content == AUTHORS[i]) {
                    option.setAttribute('selected', 'selected');
                }
                select.appendChild(option);
            }

            while (event.target.firstChild) {
                event.target.removeChild(event.target.firstChild);
            }
            event.target.appendChild(select);
            select.focus();
            select.addEventListener("blur", function () {
                resetContents(event.target, content);
            });
            document.body.addEventListener("keyup", function (event) {
                if (event.keyCode === KEYCODE_ESC) {
                    target.innerHTML = '';
                    target.innerHTML = content;
                    editModeOn = false;
                }
            });
            select.addEventListener('change', function () {
                sendReceiveBook(event.target);
            }, true)
        }

        function editText(target) {

            if (editModeOn) {
                return;
            }

            editModeOn = true;
            var content = target.innerHTML;
            var editorNode = document.createElement('input');
            editorNode.value = content;
            while (target.firstChild) {
                target.removeChild(target.firstChild);
            }
            target.appendChild(editorNode);
            editorNode.focus();
            editorNode.addEventListener("blur", function () {
                resetContents(target, content);
            }, { once: true });
            editorNode.addEventListener("keyup", function (event) {
                if (event.keyCode === KEYCODE_ESC) {
                    target.innerHTML = '';
                    target.innerHTML = content;
                    editModeOn = false;
                }
            });
            target.addEventListener("keyup", function (event) {
                if (event.keyCode === KEYCODE_ENTER) {
                    sendReceiveBook(target);
                }
            });
        }

        function sendReceiveBook(target) {
            var data = {};
            var input = target.querySelector('input') || target.querySelector('select');
            var bookNode = target.parentNode;

            if (target.classList.contains('jsName')) {
                data.name = input.value;
                data.year = bookNode.querySelector('.jsYear').innerHTML;
                data.author = bookNode.querySelector('.jsAuthor').innerHTML;
            } else if (target.classList.contains('jsYear')) {
                data.year = input.value;
                data.name = bookNode.querySelector('.jsName').innerHTML;
                data.author = bookNode.querySelector('.jsAuthor').innerHTML;
            } else if (target.classList.contains('jsAuthor')) {
                data.name = bookNode.querySelector('.jsName').innerHTML;
                data.year = bookNode.querySelector('.jsYear').innerHTML;
                data.author = input.value;
            }

            var json = JSON.stringify(data);
            var xhr = new XMLHttpRequest();

            xhr.open("POST", "/ajax/book-edit/" + bookNode.querySelector('.jsId').innerHTML, true);
            xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
            xhr.onreadystatechange = function () {
                if (xhr.readyState != 4) return;
                var book = JSON.parse(xhr.response);
                if (xhr.status == XHR_STATUS_OK) {

                    bookNode.querySelector('.jsName').innerHTML = '';
                    bookNode.querySelector('.jsName').innerHTML = book.name;
                    bookNode.querySelector('.jsAuthor').innerHTML = '';
                    bookNode.querySelector('.jsAuthor').innerHTML = book.author;
                    bookNode.querySelector('.jsYear').innerHTML = '';
                    bookNode.querySelector('.jsYear').innerHTML = book.year;

                }
                editModeOn = false;
            }
            xhr.send(json);
        }

        function resetContents(target, baseContent) {
            target.innerHTML = baseContent;
            setTimeout(function () {
                editModeOn = false;
            }, 200);
        }

    }
    ()
)
;