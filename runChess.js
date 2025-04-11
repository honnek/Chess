$('form#form').submit(function (e) {
    e.preventDefault()
    $.ajax({
        method: 'post',
        url: '/getChess.php',
        dataType: 'json',
        data: {
            figure: $('#figure').val(),
            start: {
                x: $('#startX').val(),
                y: $('#startY').val()
            },
            finish: {
                x: $('#finishX').val(),
                y: $('#finishY').val()
            }
        },
        success: async function (response) {


            let lastIdx = response.length - 1
            $(`#sqr-${response[0].x}-${response[0].y}`).css({backgroundColor: "green"})
            $(`#sqr-${response[lastIdx].x}-${response[lastIdx].y}`).css({backgroundColor: "red"})
            await sleep(1500)
            for (let i = 0; i < response.length; i++) {
                let point = response[i]
                $(`#sqr-${point.x}-${point.y}`).css({backgroundColor: "blue"})
                await sleep(1500)
            }

            for (let j = 0; j < response.length; j++) {
                for (let i = 0; i < response[j].length; i++) {
                    await sleep(50)
                    let point = response[j][i]
                    $(`#sqr-${point.y}-${point.x}`).css({backgroundColor: "green"})
                    if ((response[response.length - 1]['x'] == point.x) && (response[response.length - 1]['y'] == point.y)) {
                        await sleep(900)
                        $(`body`).append($(`<div><h1>Вы нашли У в  ${point.x} столбце, ${point.y} строке !!!<h1></div>`));
                        break
                    }
                }

            await sleep(800)
            for (let i = 0; i < response[j].length; i++) {
                let whitePoint = response[i]
                $(`#sqr-${whitePoint.y}-${whitePoint.x}`).css({backgroundColor: "white"})
            }
        }

    })
})


function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
