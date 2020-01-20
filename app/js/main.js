const URL = "/aroma/api/1.0/";
const endpoints = ['contents', 'categories', 'items'];

$(() => {
    const nav = $("#nav");
    endpoints.forEach(endpoint => {
        $.ajax({
            type: 'GET',
            url: URL + endpoint,
            success: (data) => {
                localStorage.setItem(endpoint, JSON.stringify(data));
            },
            error: () => {
                alert("Error loading " + endpoint);
            }
        });
    });
    const contents = JSON.parse(localStorage['contents']);
    $.each(contents, (i, content) => {
        nav.append(
            '<li id= ' + i + '>' +
            '<a href=#>' + content.title + ' </a>' +
            '</li>'
        );
    });
    $("#nav").on('click', 'li', function () {

        let id = $(this).attr('id');
        switch (contents[id].title) {
            case 'Menu':
                $("#content").html(
                    '<h1>' + contents[id].title + '</h1>' +
                    ' <p class=lead>' + contents[id].info + '</p>' +
                    '<div id=categories class=card-group></div>'
                );
                getCategories();
                break;
            default:
                $("#content").html('<h1>' + contents[id].title + '</h1> <p class=lead>' + contents[id].info + '</p>');
        }
    });
});

const getCategories = () => {
    const categories = JSON.parse(localStorage['categories']);
    $.each(categories, (i, category) => {
        $("#categories ").append(
            '<div class=card id=' + i + '>' +
            '<img src=' + category.image + ' class=card-img-top/>' +
            '<div class=card-body>' +
            '<h4 class=card-title>' + category.title + '</h4>' +
            '</div>' +
            '</div>' +
            '</div>'
        );
    });
    $("#content div img").css("width", "17rem");
    $(".card-title").css("text-align", "center");
    $("#content div .card").css("display", "inline-block");

    $("#categories").on('click', 'div', function () {
        const id = $(this).attr('id');
        const category_title = $("this>h4").text();
        $("#content").html(
            '<h1>' + category_title + '</h1>' +
            '<div id=items class=card-group></div>'
        );

        const items = JSON.parse(localStorage['items']);
        let filtered_items = items.filter(item => item.category_id === categories[id].id)
        console.log(filtered_items)
        $.each(filtered_items, function (i, item) {
            $("#items ").append(
                '<div class=card id=' + item.id + ' data-toggle=modal data-target=#item' + item.id + '>' +
                '<img src=' + item.image + ' class=card-img-top/>' +
                '<div class=card-body>' +
                '<h4 class=card-title>' + item.title + '</h4>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="modal fade" id=item' + item.id + ' tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">' +
                '<div class="modal-dialog modal-dialog-scrollable" role="document">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<h4 class="modal-title">' + item.title + '</h4>' +
                '</div>' +
                '<div style="text-align: center" class="modal-body">' +
                '<img src="' + item.image + '"/><hr>' +
                item.description +
                ' </div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' +
                '</div>' +
                ' </div>' +
                '</div>' +
                '</div>'
            );
        });
        $("#content div img").css("width", "17rem");
        $(".card-title").css("text-align", "center");
        $("#content div .card").css("display", "inline-block");
    });
};
