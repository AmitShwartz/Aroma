// const URL = "/aroma/api/";
// $(function () {
//     var nav = $("#nav");
//
//     $.ajax({
//         type: 'GET',
//         url: URL + 'contents/read',
//         success: function (contents) {
//             console.log(contents);
//             $.each(contents, function (i, content) {
//                 nav.append(
//                     '<li id= ' + content.id + '>' +
//                     '<a href=#>' + content.title + '' + '</a>' +
//                     '</li>'
//                 );
//             });
//         },
//         error: function () {
//             alert("Error loading content.");
//         }
//     });
//
//     $("#nav").on('click', 'li', function () {
//         var id = $(this).attr('id');
//         $.ajax({
//             type: 'GET',
//             url: URL + "contents/read_single?id=" + id,
//             success: function (data) {
//                 console.log(data);
//                 switch (data.title) {
//                     case 'Menu':
//                         $("#content").html(
//                             '<h1>' + data.title + '</h1>' +
//                             ' <p class=lead>' + data.info + '</p>' +
//                             '<div id=categories class=card-group></div>'
//                         );
//                         getCategories();
//                         break;
//                     default:
//                         $("#content").html('<h1>' + data.title + '</h1> <p class=lead>' + data.info + '</p>');
//                 }
//             },
//             error: function () {
//                 alert('Error loading page details');
//             }
//         });
//     });
// });
//
//
// function getCategories() {
//     $.ajax({
//         type: 'GET',
//         url: URL + "categories/read",
//         success: function (categories) {
//             console.log(categories);
//             $.each(categories, function (i, category) {
//                 $("#categories ").append(
//                     '<div class=card id=' + category.id + '>' +
//                     '<img src=' + category.image + ' class=card-img-top/>' +
//                     '<div class=card-body>' +
//                     '<h4 class=card-title>' + category.title + '</h4>' +
//                     '</div>' +
//                     '</div>' +
//                     '</div>'
//                 );
//             });
//             $("#content div img").css("width", "17rem");
//             $(".card-title").css("text-align", "center");
//             $("#content div .card").css("display", "inline-block");
//         },
//         error: function () {
//             alert('Error loading categories');
//         }
//     });
//     $("#categories").on('click', 'div', function () {
//         var category_id = $(this).attr('id');
//         $.ajax({
//             type: 'GET',
//             url: URL + "items/read_by_category?category_id=" + category_id,
//             success: function (items) {
//                 console.log(items);
//                 $("#content").html(
//                     '<h1>' + items[0].category_title + '</h1>' +
//                     '<div id=items class=card-group></div>'
//                 );
//                 $.each(items, function (i, item) {
//                     $("#items ").append(
//                         '<div class=card id=' + item.id + ' data-toggle=modal data-target=#item' + item.id + '>' +
//                         '<img src=' + item.image + ' class=card-img-top/>' +
//                         '<div class=card-body>' +
//                         '<h4 class=card-title>' + item.title + '</h4>' +
//                         '</div>' +
//                         '</div>' +
//                         '</div>' +
//                         '<div class="modal fade" id=item' + item.id + ' tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">' +
//                         '<div class="modal-dialog modal-dialog-scrollable" role="document">' +
//                         '<div class="modal-content">' +
//                         '<div class="modal-header">' +
//                         '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
//                         '<span aria-hidden="true">&times;</span>' +
//                         '</button>' +
//                         '<h4 class="modal-title">'+item.title+'</h4>' +
//                         '</div>' +
//                         '<div style="text-align: center" class="modal-body">' +
//                         '<img src="'+item.image+'"/><hr>'+
//                         item.description+
//                         ' </div>' +
//                         '<div class="modal-footer">' +
//                         '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' +
//                         '</div>' +
//                         ' </div>' +
//                         '</div>' +
//                         '</div>'
//                     );
//
//                 });
//                 $("#content div img").css("width", "17rem");
//                 $(".card-title").css("text-align", "center");
//                 $("#content div .card").css("display", "inline-block");
//             },
//             error: function () {
//                 alert('Error loading page details');
//             }
//         });
//     });
// }
