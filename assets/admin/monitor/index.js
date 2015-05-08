/**
 * Description:
 *
 * @module
 */
$(function () {
    var $JWatchImg = $('.J_watch_img');

    function getSrc($img) {
        var src = $img.data('effective_src');
        return src.replace(/(img_)(\d+)/, function replacer(match, p1, p2, offset, string) {
            var imgIndex = Number(p2);
            var toIndex = (imgIndex + 1);

            function expandDate(num) {
                return num >= 10 ? num : '0' + num;
            }

            if (/21$/.test(toIndex)) {
                var arr = /(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})/.exec(toIndex)
                var newDate = new Date(arr[1], arr[2] - 1, arr[3], arr[4], Number(arr[5]) + 1)
                var month = newDate.getMonth();
                toIndex = newDate.getFullYear() + expandDate(month + 1) + expandDate(newDate.getDate()) + expandDate(newDate.getHours()) + expandDate(newDate.getMinutes()) + '01'
            }
            return p1 + (toIndex);
        });
    }

    setInterval(function () {
        $('.J_watch_img').attr('src', function (index, attr) {
            var $img = $('.J_watch_img').eq(index);
            var src = getSrc($img);
            $img.data('effective_src', src)
            return src
        })
    }, 3000)
    var selected = 'hover_effect';
    $('body').on('click', '.J_watch_img', function () {
        $('.J_watch_img').removeClass(selected)
        $(this).addClass(selected)
    })
    function bindImgError($JWatchImg) {
        $JWatchImg.error({times: 0}, function (event) {
            event.data.times++
            if (event.data.times >= 3) {
                var that = this
                $.ajax({
                    url: $('#url').val(),
                    type: 'post',
                    dataType: "json",
                    data: {
                        roomid: $(this).data('room_id')
                    }
                }).success(function (data) {
                    var isBroad = JSON.parse(data)
                    if (!isBroad) {
                        $(that).closest('li').remove()
                    }
                })
                event.data.times = 0
            }
            $(this)
                .attr('src', '/umei/img/1.jpg');
        });
    }

    bindImgError($JWatchImg);
    $('.J_stick').click(function () {
        $('.' + selected).closest('li').prependTo('.J_wrap_ul')
        //    todo no interface
        var config = {
            url: '',
            timestamp: new Date().getTime()
        }
        requestAjax(config, setStickyResult)
        function setStickyResult(data) {
        }
    })
    $('.J_top').click(function () {
        window.scrollTo(0, 0);
    })
    function requestAjax(settings, callback) {
        extendSettings(settings);
        $.ajax(settings).success(function (data) {
            if (typeof data === 'undefined') {
                data = JSON.parse(data)
            }
            if (!data) {
                alert('操作失败')
            } else if (callback instanceof Function) {
                callback(data)
            }
        })
        function extendSettings(settings) {
            $.extend(settings, {
                type: 'post',
                dataType: "json"
            })
        }
    }

    $('body').on('click', '.J_operate', function () {
        var $img = $(this).closest('li').find('.J_watch_img');
        var data = $img.data()
        var settings = {
            url: $('#viol').val(),
            data: {
                uid: data.uid,
                roomid: data.room_id,
                type: $(this).is('.J_warn') ? 0 : 1,
                images: $img.attr('src').split('/').reverse()[0]
            }
        };
        requestAjax(settings);
    })
    function requestNewAnchors() {
        var url = gurl;
        //todo to del param
        if($('.J_warn').length>3){
            return
        }
        var date = new Date((1430813727 - 1) * 1000);
        var config = {
            url: url,
            data: {time: date.getTime() / 1000}
        }
        requestAjax(config, insertNewAnchor)
        function insertNewAnchor(arr) {
            $.each(arr, function (index, data) {
                var $li = $('<li>', {"class": "J_template-container"})
                    .prependTo('.J_wrap_ul')
                    .loadTemplate($("#J_template"),
                    data);
                bindImgError($li.find('img'));
            })
        }
    }

    setInterval(requestNewAnchors, 1000)
});