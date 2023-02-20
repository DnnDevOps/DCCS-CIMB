$(document).ready(function () {
	$('#add-users').click(function (event) {
		$('#users > option:selected').each(function () {
			var option = $(this),
				quotaName = 'quotas[' + option.text() + ']';
			
			$('#users-quota > tbody:last-child').append(
				'<tr>' +
					'<td>' + option.text() + '</td>' +
					'<td><input type="number" name="' + quotaName + '" class="form-control input-sm"></td>' +
				'</tr>'
			);
			
			option.remove();
		});
		
		$('#users').select2().val(null).trigger('change');
	});
});