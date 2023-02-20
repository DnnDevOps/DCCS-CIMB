/* global $ */
$(document).ready(function () {
    $('input:checkbox').change(function() {
        if (this.checked) {
            $.post('permission', {
                role_id: this.dataset.roleId,
                permission_id: this.dataset.permissionId
            }).fail(function () {
                this.disabled = true;
            }.bind(this));
        } else {
            $.ajax({
                url: 'permission/' + this.dataset.roleId + '/' + this.dataset.permissionId,
                method: 'DELETE'
            }).error(function () {
                this.disabled = true;
            }.bind(this));
        }
    });
}); 
//# sourceMappingURL=permission.js.map
