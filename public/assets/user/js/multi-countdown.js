// Countdown Item Start
// let comingDate = new Date('Dec 7, 2021 00:00:00')
// 2021-12-15 12:00:00
$('.expired_time').each(function() {
    let target = $(this);
    let expired_time = target.val();
    let comingDate = new Date(expired_time);
    let d = target.closest('.countdown').find('.days')
    let h = target.closest('.countdown').find( '.hours' )
    let m = target.closest('.countdown').find ('.minutes' )
    let s = target.closest('.countdown').find( '.seconds' )
    let x = setInterval(function() {
        let now = new Date()
        let selisih = comingDate.getTime() - now.getTime()

        let days    = Math.floor(selisih / (1000 * 60 * 60 * 24))
        let hours   = Math.floor(selisih % (1000 * 60 * 60 * 24) / (1000 * 60 * 60))
        let minutes = Math.floor(selisih % (1000 * 60 * 60) / (1000 * 60))
        let seconds = Math.floor(selisih % (1000 * 60) / 1000)
        d.text( getTrueNumber(days));
        h.text( getTrueNumber(hours));
        m.text( getTrueNumber(minutes));
        s.text( getTrueNumber(seconds))

        if (selisih < 0) {
            clearInterval(x)
            d.text( '00');
            h.text( '00');
            m.text( '00');
            s.text( '00')
        }
    }, 1000)
});
function getTrueNumber(x) {
    if (x < 10) return '0' + x
    else return x
};
// Countdown Item End
