<div x-data="{
    totopbutton:document.getElementById('toTopButton'),
    topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    },
    scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                this.totopbutton.style.display = 'block';
            } else {
                this.totopbutton.style.display = 'none';
            }
    }
}"
     x-init="
        window.onscroll = function() {
            scrollFunction()
        };
     "
     class="fixed z-50 bottom-4 left-4 animate-bounce">
    <x-button.danger style="display:none;" id="toTopButton" @click="topFunction">
        <x-icon.up class="w-8 h-8 fill-white"></x-icon.up>
    </x-button.danger>
</div>

