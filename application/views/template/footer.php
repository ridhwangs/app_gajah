    <script type="text/javascript">
        $(document).ready(function() {
             $('#cover-spin').hide(0);
        });
      
        function reloadList () {
            $('#cover-spin').show(0);
            location.reload();
        }
        
        function goTo(url) {
            $('#cover-spin').show(0);
            window.location.assign(url);
        }
    </script>
</body>
</html>
