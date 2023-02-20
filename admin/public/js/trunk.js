$(document).ready(function () {
	$('#add-field').click(function (event) {
        var fieldTable = document.getElementById('custom-fields').getElementsByTagName('tbody')[0],
            fieldRow = fieldTable.insertRow(fieldTable.rows.length),
            fieldCell = fieldRow.insertCell(0),
            valueCell = fieldRow.insertCell(1),
            fieldInput = document.createElement('input'),
            valueInput = document.createElement('input');
        
        fieldInput.type = 'text';
        fieldInput.name = 'field[]';
        fieldInput.className = 'form-control';

        valueInput.type = 'text';
        valueInput.name = 'value[]';
        valueInput.className = 'form-control';

        fieldCell.appendChild(fieldInput);
        valueCell.appendChild(valueInput);
    });
});
//# sourceMappingURL=trunk.js.map
