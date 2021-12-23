//profile show
$(".ajax-loading-2").hide();
$("#noData").hide();

$(document).on("click", "#showTopics", function (e) {
    $("#noData").hide();
    $("#showQuestionsHtml").hide();
    $("#showAnswersHtml").hide();
    $("#showTopicsHtml").show();
    e.preventDefault();
    let site_url = $(this).attr("data-href");
    let html = "";
    $.ajax({
        url: site_url,
        type: "get",
        dataType: "json",
        beforeSend: function () {
            $(".ajax-loading-2").show();
        },
    }).done(function (data) {
        $(".ajax-loading-2").hide();
        $.each(data, function (index, value) {
            if (value.length === 0) {
                $("#noData").show();
            } else {
                for (let i = 0; i < value.length; i++) {
                    html +=
                        '<div class="col-12">' +
                        "<b>" +
                        '<a href="/topic/'+ value[i].name_slug +'" class="text-dark">' +
                        value[i].name +
                        '<span class="btn btn-secondary float-right btn-sm rounded-pill">' +
                        value[i].follower +
                        ' Followers</span>' +
                        "</a>" +
                        "</b>" + 
                        "<hr>" +
                        "</div>";
                }
                $("#showTopicsHtml").html(html);
            }
        });
    });
});

$(document).on("click", "#showQuestions", function (e) {
    $("#noData").hide();
    $("#showAnswersHtml").hide();
    $("#showTopicsHtml").hide();
    $("#showQuestionsHtml").show();
    e.preventDefault();
    let site_url = $(this).attr("data-href");
    let html2 = "";
    $.ajax({
        url: site_url,
        type: "get",
        dataType: "json",
        beforeSend: function () {
            $(".ajax-loading-2").show();
        },
    }).done(function (data) {
        $(".ajax-loading-2").hide();
        $.each(data, function (index, value) {
            if (value.length === 0) {
                $("#noData").show();
            } else {
                for (let i = 0; i < value.length; i++) {
                    let title_slug = value[i].title_slug;
                    html2 +=
                        '<div class="col-12">' +
                        "<b>" +
                        '<a href="/' +
                        title_slug +
                        '" class="text-dark">' +
                        value[i].title +
                        "</a>" +
                        "</b>" +
                        "<hr>" +
                        "</div>";
                }
                $("#showQuestionsHtml").html(html2);
            }
        });
    });
});

$(document).on("click", "#showAnswers", function (e) {
    $("#noData").hide();
    $("#showQuestionsHtml").hide();
    $("#showTopicsHtml").hide();
    $("#showAnswersHtml").show();
    e.preventDefault();
    let site_url = $(this).attr("data-href");
    let html3 = "";
    $.ajax({
        url: site_url,
        type: "get",
        dataType: "json",
        beforeSend: function () {
            $(".ajax-loading-2").show();
        },
    }).done(function (data) {
        let name_slug = $("#name").attr("data-attr");
        $(".ajax-loading-2").hide();
        $.each(data, function (index, value) {
            if (value.length === 0) {
                $("#noData").show();
            } else {
                for (let i = 0; i < value.length; i++) {
                    let title_slug = value[i].question.title_slug;
                    let title = value[i].question.title;

                    html3 +=
                        '<div class="col-12">' +
                        "<b>" +
                        '<a href="/' +
                        title_slug +
                        "#" +
                        name_slug +
                        '" class="text-dark">' +
                        title +
                        "</a>" +
                        "</b>" +
                        "<br>" +
                        value[i].text +
                        "<hr>" +
                        "</div>";
                }
                $("#showAnswersHtml").html(html3);
            }
        });
    });
});
