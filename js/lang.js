// Submit the language form when the dropdown value changes
document.querySelector('select[name="language"]').addEventListener('change', function() {
    this.form.submit();
 });