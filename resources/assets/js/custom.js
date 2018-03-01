$(document).ready(function () {
    var tbody = $('tbody');
    tbody.on('click', '.fa-edit', function () {
        var editButton = $(this);
        var actionsTd = editButton.parent();
        var dateRow = editButton.closest('tr');
        var dateColumns = dateRow.find('td:not(:last-child)');
        var oldInputsValues = [];
        dateColumns.each(function (i, el) {
            el = $(el);
            oldInputsValues.push(el.text());
            el.html('<input type="number" value="' + parseInt(el.text()) + '" name="date[]">');
        });
        actionsTd.html('<i class="fas fa-times-circle"></i><i class="fas fa-check-circle edit"></i>');
        actionsTd.find('.fa-times-circle').click(function () {
            dateColumns.each(function (i, el) {
                el = $(el);
                el.html(oldInputsValues[i]);
            });
            actionsTd.html('<i class="fas fa-edit mr20"></i>' +
                '<i class="fas fa-trash-alt exist"></i>');
        });
        actionsTd.find('.fa-check-circle').click(function () {
            var inputNames = ['day', 'month', 'year'];
            var dateData = {};
            dateColumns.each(function (i, e) {
                dateData[inputNames[i]] = parseInt($(e).find('input').val());
            });
            $.ajax({
                url: '/dates/' + dateRow.data('id'),
                method: 'PUT',
                data: dateData,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr("content")}
            }).done(function (data) {
                if (data.fail) {
                    alert('Incorrect date!');
                } else if (data === true) {
                    var inputs = dateRow.find('td>input');
                    inputs.each(function (i, e) {
                        $(dateColumns[i]).text($(e).val());
                    });
                    actionsTd.html('<i class="fas fa-edit mr20"></i>' +
                        '<i class="fas fa-trash-alt exist"></i>');
                } else {
                    alert('Interesting...');
                }
            }).fail(function () {
                alert('Sometimes it happens =(');
            });
        });
    });
    tbody.on('click', '.fa-trash-alt.exist', function () {
        var trashButton = $(this);
        var actionsTd = trashButton.parent();
        var dateRow = trashButton.closest('tr');
        var dateId = dateRow.data('id');
        actionsTd.html('<i class="fas fa-check-circle trash"></i><i class="fas fa-times-circle"></i>');
        actionsTd.find('.fa-times-circle').click(function () {
            actionsTd.html('<i class="fas fa-edit mr20"></i>' +
                '<i class="fas fa-trash-alt exist"></i>');
        });
        actionsTd.find('.fa-check-circle').click(function () {
            $.ajax({
                url: '/dates/' + dateId,
                method: 'DELETE',
                data: {dateId: dateId},
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr("content")}
            }).done(function (data) {
                if (data.fail) {
                    alert('You can\'t delete another\'s date!');
                } else if (data === true) {
                    dateRow.remove();
                } else {
                    alert('Interesting...');
                }
            }).fail(function () {
                alert('Sometimes it happens =(');
            });
        });
    });
    $('.btn-secondary').click(createDate);
});

function createDate() {
    var createButton = $(this);
    createButton.unbind();
    var tbody = $('tbody');
    var newDateHtml =
        '<tr data-id="">' +
        '<td><input type="number" value="" name="date[]"></td>' +
        '<td><input type="number" value="" name="date[]"></td>' +
        '<td><input type="number" value="" name="date[]"></td>' +
        '<td>' +
        '<i class="fas fa-check-circle edit"></i>' +
        '<i class="fas fa-times-circle"></i>' +
        '</td>' +
        '</tr>';
    var dateRow = $(newDateHtml).prependTo(tbody);
    $('.fa-times-circle').click(function () {
        dateRow.remove();
        createButton.click(createDate);
    });
    $('.fa-check-circle').click(function () {
        var actionsTd = $(this).parent();
        var dateColumns = dateRow.find('td:not(:last-child)');
        var inputNames = ['day', 'month', 'year'];
        var dateData = {};
        dateColumns.each(function (i, e) {
            dateData[inputNames[i]] = parseInt($(e).find('input').val());
        });
        $.ajax({
            url: '/dates',
            method: 'POST',
            data: dateData,
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr("content")}
        }).done(function (data) {
            if (data.fail) {
                alert('Incorrect date!');
            } else if (typeof(parseInt(data)) === 'number') {
                dateRow.data('id', data);
                var inputs = dateRow.find('td>input');
                inputs.each(function (i, e) {
                    $(dateColumns[i]).text($(e).val());
                });
                actionsTd.html('<i class="fas fa-edit mr20"></i>' +
                    '<i class="fas fa-trash-alt exist"></i>');
            } else {
                alert('Interesting...');
            }
        }).fail(function () {
            alert('Sometimes it happens =(');
        });
        createButton.click(createDate);
    });
}