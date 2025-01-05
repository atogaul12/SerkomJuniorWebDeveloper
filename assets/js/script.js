// Validasi nomor HP (hanya angka)
const hpInput = document.querySelector('input[name="hp"]');
if(hpInput) {
    hpInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });
}

// Validasi email
const emailInput = document.querySelector('input[name="email"]');
if(emailInput) {
    emailInput.addEventListener('input', function() {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(this.value)) {
            this.setCustomValidity('Format email tidak valid');
        } else {
            this.setCustomValidity('');
        }
    });
}

const fileInput = document.querySelector('input[name="berkas"]');

if (fileInput) {
    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        const allowedExtension = 'pdf';

        if (file) {
            const fileExtension = file.name.split('.').pop().toLowerCase();

            if (fileExtension !== allowedExtension) {
                this.setCustomValidity('Hanya file dengan format PDF yang diperbolehkan.');
                this.reportValidity(); // Menampilkan notifikasi
            } else {
                this.setCustomValidity(''); // Reset validasi jika valid
            }
        }
    });
}
