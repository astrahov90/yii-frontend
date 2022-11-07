function getUserElement(elem) {
    let newElement = "<div class='row authors'>\n" +
        "                <div class='col-2'>\n" +
        "                    <div class='container'><img class='avatar' src='"+elem.iconPath+"' alt='Аватар автора'></div>\n" +
        "                </div>\n" +
        "                <div class='col-9'>\n" +
        "                    <div class='container'>\n" +
        "                        <div class='row'>\n" +
        "                            <div class='card'>\n" +
        "                                <div class='card-title'>\n" +
        "                                    <div class='container-fluid'>\n" +
        "                                        <div class='row'>\n" +
        "                                            <div class='col-4 fw-bold'>"+elem.authorName+"</div>\n" +
        "                                            <div class='col-4 offset-4'>Дата регистрации: "+elem.created_at+"</div>\n" +
        "                                        </div>\n" +
        "                                    </div>\n" +
        "                                </div>\n" +
        "                                <div class='card-body'>\n" +
        "                                    <p> Количество постов автора: "+elem.posts_count +
        "                                       <a href='/authors/"+elem.id+"/posts'>Перейти</a></p>\n" +
        "                                </div>\n" +
        "                                <div class='card-bottom'></div>\n" +
        "                            </div>\n" +
        "                            <div class='clearfix'></div>\n" +
        "                        </div>\n" +
        "                    </div>\n" +
        "                </div>\n" +
        "            </div>";
    return newElement;
}

function loadUsers() {
    let curCount = $(".row.authors").length;
    $.get("/api/authors"+(location.search?location.search+"&":"?")+"page="+(curCount+1)).done(function (data) {

        data.authors.forEach(function (elem, key) {
            let newElement = getUserElement(elem);

            $(newElement).insertBefore($(".moreAuthors"));
        });

        if (data.currentPage>=data.pageCount)
        {
            $(".moreAuthors").hide();
        }
        else {
            $(".moreAuthors").show();
        }

        $(".loaderBody").remove();
    });
}

function getUserInfo(authorId) {
    $.get("/api/authors/"+authorId).done(function (data) {
        let newElement = getUserElement(data);
        $(".row.authors").append($(newElement));
    });
}
