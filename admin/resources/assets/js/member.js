$(document).ready(function () {
	$('#add-users').click(function (event) {
		$('#users > option:selected').each(function () {
			var option = $(this),
				memberName = 'members[' + option.text() + ']';
			
			$('#users-penalty > tbody:last-child').append(
				'<tr>' +
					'<td>' + option.text() + '</td>' +
					'<td><input type="number" name="' + memberName + '" class="form-control input-sm" value="0"></td>' +
				'</tr>'
			);
			
			option.remove();
		});
		
		$('#users').select2().val(null).trigger('change');
	});
});