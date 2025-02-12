<div class="loader">
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>
</div>
<script>
    window.onload = function() {
        setTimeout(function() {
            var preloader = document.querySelector('.loader');
            preloader.style.display = 'none';
        }, 400);
    };
</script>