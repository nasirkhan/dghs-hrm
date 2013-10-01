<footer class="footer">
    <div class="container">                
        <ul class="footer-links">
            <li><a href="#">Home</a></li>
            <li class="muted">&middot;</li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li class="muted">&middot;</li>
            <li><a href="#">Contact Developer</a></li>
        </ul>
        <?php if ($_SESSION['username'] == "nasirkhan"): ?>    
            <code>
                <?php
                $time_end = microtime(true);

                //dividing with 60 will give the execution time in minutes other wise seconds
                $execution_time = ($time_end - $start_time);
                //$execution_time = ($time_end - $start_time);
                //execution time of the script
                echo "<b>Total Execution Time: $execution_time Second(s)</b>";
                ?>
            </code>
        <?php endif; ?>
    </div>
</footer>