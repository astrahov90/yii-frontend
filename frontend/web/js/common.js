
function topFunction() {
    window.scrollTo({top: 0, behavior: 'smooth'});
}

function scrollFunction() {
    let headerSection = $("header .container");

    if (document.body.scrollTop > headerSection.height() || document.documentElement.scrollTop > headerSection.height()) {
        $("#toTopBtn").css('display','block');
    } else {
        $("#toTopBtn").css('display','none');
    }
}

$(document).ready(function () {
    window.onscroll = function() {scrollFunction()};

    $('body').on('click','.login-link',function () {
        document.location.href = $(this).attr('href') + "?redirect="+ document.location.pathname;
        return false;
    });

    $(".logout-link").click(function () {
        document.location.href = $(this).attr('href') + "?redirect="+ document.location.pathname;
        return false;
    });
});

function bbCodeDecode(curText){
    curText = curText.replace(/(\[b\])(.+?)(\[\/b\])/i,"<span style='font-weight: bold;'>$2</span>");
    curText = curText.replace(/(\[i\])(.+?)(\[\/i\])/i,"<span style='font-style: italic;'>$2</span>");
    curText = curText.replace(/(\[u\])(.+?)(\[\/u\])/i,"<span style='text-decoration: underline;'>$2</span>");
    curText = curText.replace(/(\[s\])(.+?)(\[\/s\])/i,"<span style='text-decoration: line-through;'>$2</span>");
    curText = curText.replace(/(\[quote\])(.+?)(\[\/quote\])/i,"<blockquote>$2</blockquote>");
    curText = curText.replace(/(\[img\])(.+?)(\[\/img\])/i,"<img src='$2'>");
    curText = curText.replace(/(\[url\])(.+?)(\[\/url\])/i,"<a href='$2'>$2</a>");
    curText = curText.replace(/(\[url=(.+?)\])(.+?)(\[\/url\])/i,"<a href='$2'>$3</a>");
    curText = curText.replace(/(\[color='(.+?)'\])(.+?)(\[\/color\])/i,"<span style='color: $2;'>$3</span>");

    return curText;
}

async function getAccessToken() {
    return $.ajax({
        url: "/site/get-auth-key",
        type: "GET"
    });

}