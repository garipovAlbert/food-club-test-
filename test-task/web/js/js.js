
/**
 * documents management js
 * @returns {jsDocuments}
 */
Documents = new function ()
{
    /**
     * delete file
     * @param {type} $el
     * @returns {undefined}
     */
    this.deleteFile = function ($el)
    {
        var $f = $el.data('f');
        var $mes = $el.data('confirm-message');
        if (!confirm($mes) || !$f) {
            return;
        }
        $.ajax({
            type: 'POST',
            async: true,
            dataType: 'json',
            data: {deleteFile: $f},
            error: function (xhr)
            {
                console.log(xhr.responseText, 'error');
            }
        }).done(function ($data)
        {
            if ($data.result === 'success') {
                $el.parent().remove();
                if ($('.file-item').length === 0) {
                    $('.no-results-container').removeClass('hidden');
                }
            }
        });
    };
};