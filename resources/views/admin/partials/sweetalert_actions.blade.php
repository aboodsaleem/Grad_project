<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // زر الحذف (سواء soft أو force)
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            Swal.fire({
                title: this.dataset.title || 'هل أنت متأكد؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.dataset.confirm || 'نعم',
                cancelButtonText: this.dataset.cancel || 'إلغاء',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = this.dataset.url;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = this.dataset.method || 'DELETE';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // زر الاسترجاع
    document.querySelectorAll('.restore-btn').forEach(button => {
        button.addEventListener('click', function () {
            Swal.fire({
                title: this.dataset.title || 'هل تريد استرجاع هذا العنصر؟',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: this.dataset.confirm || 'نعم',
                cancelButtonText: this.dataset.cancel || 'إلغاء',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = this.dataset.url;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'PUT';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
</script>
