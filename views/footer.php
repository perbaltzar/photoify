    </body>
</html>
<?php
// Reseting Session Error so message don't stick
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}
