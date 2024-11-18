<?php
    echo '<div class="custom-loader"></div>';
    echo '<script>
            setTimeout(function() {
                window.location.href = "' . BASE_URL .'dashboard.php";
            }, 1000);
    </script>';
?>