jQuery().ready(function () {
    jQuery("#bookForm").validate({
        rules: {
            book_name: "required",
            author: "required",
        },
        messages: {
            book_name: "Не указано название книги"
        },
        highlight: function (element) {
            jQuery(element).addClass("bookFormError");
        }
    })
})