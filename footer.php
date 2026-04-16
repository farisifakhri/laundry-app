    </div><!-- /.app -->

    <footer class="footer-bar">
        <div class="d-flex justify-content-between align-items-center w-100">
            <span style="font-size:12.5px;color:var(--text-muted);font-weight:600">
                <i class="bi bi-water me-1" style="color:var(--primary)"></i>
                Nugraha Laundry &mdash; Cepat &bull; Bersih &bull; Terpercaya
            </span>
            <span style="font-size:12px;color:var(--text-muted)">&copy; <?= date('Y') ?></span>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.3/jspdf.plugin.autotable.min.js"></script>

    <?php
        $page = basename($_SERVER['PHP_SELF'], '.php');
        $jsFile = "js/{$page}.js";
        if (file_exists($jsFile)) {
            echo "<script src='$jsFile'></script>";
        }
    ?>

    <script>
        // Script untuk toggle sidebar di tampilan mobile
        $(document).ready(function() {
            $('#btnToggleSidebar').click(function(e) {
                e.stopPropagation();
                $('.sidebar').toggleClass('show');
            });

            // Klik di luar sidebar untuk menutupnya (khusus mobile)
            $(document).click(function(e) {
                if ($(window).width() <= 768) {
                    if (!$(e.target).closest('.sidebar, #btnToggleSidebar').length) {
                        $('.sidebar').removeClass('show');
                    }
                }
            });
        });
    </script>

</body>
</html>
