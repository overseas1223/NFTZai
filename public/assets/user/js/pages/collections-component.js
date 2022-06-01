(function ($) {
    "use strict";

    let paginate = 1;
    loadOnSales(paginate);
    loadMoreData(paginate);
    loadMoreDataCreated(paginate);
    loadMoreDataLike(paginate);
    loadFollowing(paginate);
    loadFollower(paginate);

    $('#load-more-sale').on('click', function() {
        let page = $(this).data('paginate');
        loadOnSales(page);
        $(this).data('paginate', page+1);
    });
    function loadOnSales(paginate) {
        $.ajax({
            url: $('#on-sale-data').val() + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more-sale').text('Loading...');
            }
        })
        .done(function(data) {
            if(data.length == 0 && paginate == 1) {
                $('#load-more-sale').text('No Data Found!');
                return;
            }
            else if(data.length == 0) {
                $('.invisible').removeClass('invisible');
                $('#load-more-sale').hide();
                return;
            } else {
                $('#load-more-sale').text('Load more...');
                $('#post-sale').append(data);
            }
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('Something went wrong.');
        });
    }
    $('#load-more').on('click', function() {
        let page = $(this).data('paginate');
        loadMoreData(page);
        $(this).data('paginate', page+1);
    });
    function loadMoreData(paginate) {
        $.ajax({
            url: $('#my-collection-data').val() + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more').text('Loading...');
            }
        })
            .done(function(data) {
                if(data.length == 0 && paginate == 1) {
                    $('#load-more').text('No Data Found!');
                    return;
                }
                else if(data.length == 0) {
                    $('.invisible').removeClass('invisible');
                    $('#load-more').hide();
                    return;
                } else {
                    $('#load-more').text('Load more...');
                    $('#post').append(data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }

    $('#load-more-created').on('click', function() {
        let page = $(this).data('paginate');
        loadMoreDataCreated(page);
        $(this).data('paginate', page+1);
    });
    function loadMoreDataCreated(paginate) {
        $.ajax({
            url: $('#my-created-data').val() + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more-created').text('Loading...');
            }
        })
            .done(function(data) {
                if(data.length == 0 && paginate == 1) {
                    $('#load-more-created').text('No Data Found!');
                    return;
                }
                else if(data.length == 0) {
                    $('.invisible').removeClass('invisible');
                    $('#load-more-created').hide();
                    return;
                } else {
                    $('#load-more-created').text('Load more...');
                    $('#post-created').append(data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }
    $('#load-more-like').on('click', function() {
        let page = $(this).data('paginate');
        loadMoreDataLike(page);
        $(this).data('paginate', page+1);
    });
    function loadMoreDataLike(paginate) {
        $.ajax({
            url: $('#my-like-data').val() + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more').text('Loading...');
            }
        })
            .done(function(data) {
                if(data.length == 0 && paginate == 1) {
                    $('#load-more-like').text('No Data Found!');
                    return;
                }
                else if(data.length == 0) {
                    $('.invisible').removeClass('invisible');
                    $('#load-more-like').hide();
                    return;
                } else {
                    $('#load-more-like').text('Load more...');
                    $('#post-like').append(data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }
    $('.cover-photo').on('change', function(e) {
        $('#imgsubmit').click();

    });
    $('#imageUpload').on('submit', (function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let formData = new FormData(this);
        $.ajax({
            url: $('#update-cover-photo').val(),
            type: 'post',
            datatype: 'html',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        })
            .done(function(data) {
                window.location.reload();
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }));
    $('#goToServiceCreate').on('click', function() {
        window.location.href = $(this).attr("data-id");
    });
    function loadFollowing(paginate) {
        $.ajax({
            url: $('#following-data').val() + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more-following').text('Loading...');
            }
        })
            .done(function(data) {
                if(data.length == 0 && paginate == 1) {
                    $('#load-more-following').text('No Data Found!');
                    return;
                }
                else if(data.length == 0) {
                    $('.invisible').removeClass('invisible');
                    $('#load-more-following').hide();
                    return;
                } else {
                    $('#load-more-following').text('Load more...');
                    $('#following').append(data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }
    $('#load-more-following').on('click', function() {
        let page = $(this).data('paginate');
        loadFollowing(page);
        $(this).data('paginate', page+1);
    });

    function loadFollower(paginate) {
        $.ajax({
            url: $('#follower-data').val() + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more-follower').text('Loading...');
            }
        })
            .done(function(data) {
                if(data.length == 0 && paginate == 1) {
                    $('#load-more-follower').text('No Data Found!');
                    return;
                }
                else if(data.length == 0) {
                    $('.invisible').removeClass('invisible');
                    $('#load-more-follower').hide();
                    return;
                } else {
                    $('#load-more-follower').text('Load more...');
                    $('#follower').append(data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }
    $('#load-more-follower').on('click', function() {
        let page = $(this).data('paginate');
        loadFollower(page);
        $(this).data('paginate', page+1);
    });
})(jQuery)
