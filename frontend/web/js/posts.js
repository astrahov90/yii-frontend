function getMorePosts(scrollDown = true) {
    getPostsCommon();
    if (scrollDown) {
        scrollIntoViewIfNeeded($(".row.post:last"));
    }
}

function getUserPosts(id) {
    getPostsCommon(id);
}

function getPostElement(elem, curIndex, avatarField = "") {
    let newElement = "<div class='row post'>\n" +
        "                <input type='hidden' class='postId' value='" + elem.id + "'>\n" +
        "                <div class='col-2 d-flex flex-column align-items-stretch'>\n" +
        "                    <div class='flex-grow-0 align-self-start'>Автор: <a href='/authors/" + elem.author_id + "/posts'>" + elem.authorName + "</a>" + "</div>\n" +
        "                    <div class='flex-grow-1 align-self-start'>" + avatarField + "</div>\n" +
        "                    <div class=''>Дата публикации: " + elem.created_at + "</div>\n" +
        "                </div>\n" +
        "                <div class='col-9'>\n" +
        "                    <div class='container'>\n" +
        "                        <div class='row'>\n" +
        "                            <div class='card'>\n" +
        "                                <div class='card-title'>\n" +
        "                                    <div class='container-fluid'>\n" +
        "                                        <div class='row'>\n" +
        "                                            <div class='col-9 fw-bold'>" + elem.title + "</div>\n" +
        "                                            <div class='col-3'> Рейтинг: <img class='rating-arrow rating-down' src='/img/down-arrow-red.svg'><span class='rating-count'>" + elem.likes_count + "</span><img class='rating-arrow rating-up' src='/img/up-arrow-green.svg'></div>\n" +
        "                                        </div>\n" +
        "                                    </div>\n" +
        "                                </div>\n" +
        "                                <input type='checkbox' data-more-checker='card-read-more-checker' id='card-read-more-checker-" + curIndex + "'/>\n" +
        "                                <div class='card-body'>\n" +
        "                                    <p>" + bbCodeDecode(elem.body) + "</p>\n" +
        "                                    <div class='card-bottom'>\n" +
        "                                    </div>\n" +
        "                                </div>\n" +
        "                                    <a href='/posts/" + elem.id + "/comments/'>" + elem.comments_count_text + "</a>\n" +
        "                                <label for='card-read-more-checker-" + curIndex + "' class='card-read-more-button'></label>\n" +
        "                            </div>\n" +
        "                            <div class='clearfix'></div>\n" +
        "                        </div>\n" +
        "                    </div>\n" +
        "                </div>\n" +
        "            </div>";
    return newElement;
}

function getPostsCommon(authorId = false) {
    let curCount = $(".row.post").length;
    let querystring = "/api/posts" + (location.search ? location.search + "&" : "?") + "offset=" + (curCount + 1);

    if (authorId) {
        querystring = "/api/posts" + (location.search ? location.search + "&" : "?") + "author_id=" + authorId + "&offset=" + (curCount + 1);
    }

    $.get(querystring).done(function (data) {

        data.posts.forEach(function (elem, key) {
            let avatarField = "<img class='avatar' src='" + elem.iconPath + "' alt='Аватар автора'>";
            if (authorId) {
                avatarField = "";
            }
            let curIndex = curCount + key;
            let newElement = getPostElement(elem, curIndex, avatarField);

            $(newElement).insertBefore($(".morePosts"));
        });

        if (data.currentPage >= data.pageCount) {
            $(".morePosts").hide();
        }
        else {
            $(".morePosts").show();
        }

        $(".loaderBody").remove();

        hidePostsMoreButton();
    });
}

function scrollIntoViewIfNeeded($target) {
    if ($target.offset()) {
        let targetOffset = $target.offset();
        let targetPosition = $target.position();

        let targetFullPosition = targetOffset.top + targetPosition.top;

        if (targetFullPosition + $target.height() >
            $(window).scrollTop() + (
                window.innerHeight || document.documentElement.clientHeight
            )) {
            //scroll down
            $("html,body").animate({
                    scrollTop: targetFullPosition -
                    (window.innerHeight || document.documentElement.clientHeight)
                    + $target.height() + 15
                }
            );
        }
    }
}

function hidePostsMoreButton() {
    $.each($(".row.post"), function (index, elem) {
        if ($(elem).find('.card-body').height() < parseInt($(elem).find('.card-body').css('max-height'))) {
            $(elem).find('.card-read-more-button').remove();
        }
    });
}

function getPostComments(postId) {
    let curCount = $(".row.comment").length;
    querystring = "/api/posts/" + postId + "/comments" + (location.search ? location.search + "&" : "?") + "offset=" + curCount;

    $.get(querystring).done(function (data) {

        data.comments.forEach(function (elem, key) {
            let curIndex = (++curCount);
            let newElement = "<div class='row comment'>\n" +
                "                <div class='col-2 d-flex flex-column align-items-stretch'>\n" +
                "                    <div class='flex-grow-0 align-self-start'>№" + curIndex + "    Автор: <a href='/authors/" + elem.authorId + "/posts'>" + elem.authorName + "</a></div>" +
                "                    <div class='flex-grow-1 align-self-start'><img class='avatar' src='" + elem.iconPath + "' alt='Аватар автора'></div>" +
                "                    <div class=''>Дата комментария: " + elem.created_at + "</div>\n" +
                "                </div>\n" +
                "                <div class='col-9'>\n" +
                "                    <div class='container'>\n" +
                "                        <div class='row'>\n" +
                "                            <div class='card'>\n" +
                "                                <input type='checkbox' checked data-more-checker='card-read-more-checker' id='card-read-more-checker-" + curIndex + "'/>\n" +
                "                                <div class='card-body'>\n" +
                "                                    <p>" + bbCodeDecode(elem.body) + "</p>\n" +
                "                                    <div class='card-bottom'>\n" +
                "                                    </div>\n" +
                "                                </div>\n" +
                "                            </div>\n" +
                "                            <div class='clearfix'></div>\n" +
                "                        </div>\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "            </div>";

            $(newElement).insertBefore($(".moreComments"));
        });

        if (curCount > 0) {
            hasComments.show();
        }

        /*scrollIntoViewIfNeeded($(".row.post:last"));*/

        if (data.currentPage >= data.pageCount) {
            $(".moreComments").hide();
        }
        else {
            $(".moreComments").show();
        }

        $(".loaderBody").remove();

        hidePostsMoreButton();
    });
}

function getPostInfo(postId) {
    querystring = "/api/posts/" + postId;

    $.get(querystring).done(function (elem) {
        let avatarField = "<img class='avatar' src='" + elem.iconPath + "' alt='Аватар автора'>";
        let newElement = getPostElement(elem, 0, avatarField);
        $(".row.post").replaceWith($(newElement));

        hidePostsMoreButton();
    });
}

$(document).ready(function () {
    $('body').on('click', '.rating-arrow', function () {
        let method;
        if ($(this).hasClass('rating-up')) {
            method = "like";
        }
        if ($(this).hasClass('rating-down')) {
            method = "dislike";
        }

        if (!method)
            return false;

        let curPostId;

        if (typeof postId !== 'undefined') {
            curPostId = postId;
        }
        else {
            curPostId = $(this).closest(".row.post").find('.postId').val();
        }

        let ratingField = $(this).closest('.row').find('.rating-count');

        $.post("/api/posts/" + curPostId + "/" + method).done(function (data) {
            $.get("/api/posts/" + curPostId + "/getRating").done(function (data) {
                ratingField.html(data);
            });
        });

        return false;
    });

});
