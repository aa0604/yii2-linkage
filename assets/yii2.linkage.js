
$('body').on('change', '.' + selectClassName, function () {
    var obj = $(this);
    var index = obj.index();
    var className = obj.attr('data-class-name');
    // 最大级别判断
    if (linkageMaxLevel[className] > 0 && index + 1 >= linkageMaxLevel[className]) return;
    $('#input-' + selectClassName).val(obj.val());
    getLinkage(obj, name(className, index + 1, selectClassName));
});

function getLinkage(obj,  name) {

    $.ajax({
        url: linkageUrl + obj.val(),
        dataType: 'JSON',
        cache: true,
        success: function (result) {
            if (result.length === 0) return;

            var html = '<select class="form-control form-control-inline ' + selectClassName + ' " name="'+name+'"  data-class-name="' + selectClassName + '">';
            for (var k in result) html += '<option value="' + k + '">' + result[k] + '</option>';
            html += '</select>';
            obj.nextAll().remove();
            obj.after(html);
        }
    })
}

function name(className, index) {
    return fieldLevelName[className][index] || 'linkageId-' + index;
}