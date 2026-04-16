    </div>
    <footer class="footer-bar mt-auto py-3">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">
                
                    <strong>Transaksi Laundry</strong>
                    <span class="d-block small">Cepat • Bersih • Terpercaya</span>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.3/jspdf.plugin.autotable.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
        // Ambil nama file PHP yang sedang dibuka (misal: "user")
        $page = basename($_SERVER['PHP_SELF'], '.php');

        // Buat path file JS-nya
        $jsFile = "js/{$page}.js";

        // Jika file JS-nya ada, load otomatis
        if (file_exists($jsFile)) {
            echo "<script src='$jsFile'></script>";
        }
    ?>
</body>
</html>