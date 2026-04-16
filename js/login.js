$(document).ready(function () {
    $('#formLogin').submit(function (e) {
        e.preventDefault();

        const email = $('#email').val().trim();
        const password = $('#password').val().trim();

        if (!email || !password) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Email dan password harus diisi.',
            });
            return;
        }

        const data = { action: 'login', email, password };

        login(data)
            .then(res => {
                // ✅ jaga-jaga jika response belum otomatis jadi object
                if (typeof res === 'string') res = JSON.parse(res);

                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Login berhasil.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    setTimeout(() => window.location.href = 'index.php', 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: res.error || 'Terjadi kesalahan saat login.',
                    });
                }
            })
            .catch(err => {
                console.error('Error:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan pada server.',
                });
            });
    });
});

function login(data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'process/login/process.php',
            method: 'POST',
            data: data,
            dataType: 'json', // ✅ tambahkan agar otomatis parse JSON
            success: function (response) {
                resolve(response);
            },
            error: function (xhr, status, error) {
                reject(error);
            }
        });
    });
}
