$(document).ready(function(){
    // Подгрузка фотографий
    let loadMoreBtn = $('.loadMore');
    loadMoreBtn.click( function (e) {
        e.preventDefault();
        var ID = $(this).attr('id');
        $(this).hide();

        let resultBlock = $('#result_block');
        $.ajax({
            type:'POST',
            url:'ajax/ajax_more.php',
            data:'id='+ID,
            success:function(result){
                if (result.success && result.data.items) {
                    let html = '';
                    $.each(result.data.items, function (k, val) {
                        html += '<div class="albums">';
                        $.each(val.images, function (imageKey, images) {
                            html += '<div class="column">' +
                                '        <img src="' + images.image + '" alt="' + val.name + '" width="200px" height="150px">' +
                                '    </div>';
                        });
                        html += '<div class="phone">' +
                            '        <p>Phone: ' + val.phone.substr(-4) + '</p>' +
                            '    </div>' +
                        '</div>';
                    });
                    resultBlock.append(html);
                    if (result.data.showPager) {
                        loadMoreBtn.attr('id', result.data.lastKey);
                        loadMoreBtn.show();
                    }
                } else {
                    alert('Возникла ошибка при запросе к серверу: ' . data.errors);
                }
            }
        })
    });

    // Форма добавления картинок
    $("#submit").click(function(e) {
        e.preventDefault();
        var fields = new FormData($("form").get(0));
        $.ajax({
            type: "POST",
            url: "ajax/create.php",
            data: fields,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.errors) {
                    if (data.errors.name) {
                        $('#name-field').find('.error').html(data.errors.name).show();
                    } else {
                        $('#name-field').find('.error').html("").hide();
                    }
                    if (data.errors.email) {
                        $('#email-field').find('.error').html(data.errors.email).show();
                    } else {
                        $('#email-field').find('.error').html("").hide();
                    }
                    if (data.errors.phone) {
                        $('#phone-field').find('.error').html(data.errors.phone).show();
                    } else {
                        $('#name-field').find('.error').html("").hide();
                    }
                    if (data.errors.date) {
                        $('#date-field').find('.error').html(data.errors.date).show();
                    } else {
                        $('#name-field').find('.error').html("").hide();
                    }
                    if (data.errors.image) {
                        $('#image-field').find('.error').html(data.errors.image).show();
                    } else {
                        $('#name-field').find('.error').html("").hide();
                    }
                } else {
                    if (data.success == true) {
                        window.location.replace("/");
                    }
                }
            }
        });
    });
});