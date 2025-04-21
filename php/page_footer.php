<?php if (isset($vendorFiles) && is_array($vendorFiles)): ?>
    <?php foreach ($vendorFiles as $vendorFile): ?>
        <script src="vendor/<?php echo $vendorFile; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (isset($jsFiles) && is_array($jsFiles)): ?>
    <?php foreach ($jsFiles as $jsFile): ?>
        <script src="scripts/<?php echo $jsFile; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
<script src="modules/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>