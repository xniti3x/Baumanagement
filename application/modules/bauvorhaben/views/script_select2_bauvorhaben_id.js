$(".bauvorhaben-id-select").select2({
    placeholder: "<?php _trans('bauvorhaben'); ?>",
    ajax: {
        url: "<?php echo site_url('bauvorhaben/ajax/name_query'); ?>",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                query: params.term,
                page: params.page,
                _ip_csrf: Cookies.get('ip_csrf_cookie')
            };
        },
        processResults: function (data) {
            console.log(data);
            return {
                results: data
            };
        },
        cache: true
    },
    minimumInputLength: 1
});
