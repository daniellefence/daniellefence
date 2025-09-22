<div {{$attributes}} x-data="{
    showConfirm:false,
    interval:null,
    countdown:5,
    startTimer() {

        this.showConfirm = true;
        this.interval = setInterval(()=>{
            this.countdown --;
            if(this.countdown <= 0) {
                this.resetInterval();
            }
        },1000);

    },
    resetInterval() {
        this.countdown = 5;
        clearInterval(this.interval);
        this.showConfirm = false;
    }
}">
    <form  method="post" action="{{route('delete')}}" x-data="{

}">

        @csrf
        <input type="hidden" name="type" value="{{$type}}"/>
        <input type="hidden" name="guid" value="{{$guid}}"/>
        <x-button.danger
            title="Delete" @click="startTimer()" x-show="!showConfirm" type="button" size="small">
            <x-icon.trash class="w-4 h-4 fill-white"></x-icon.trash>
        </x-button.danger>
        <x-button.danger x-cloak x-show="showConfirm" title="Delete" type="submit" size="small">
            <div class="w-4 h-4" x-text="countdown"></div>
        </x-button.danger>
    </form>
</div>


