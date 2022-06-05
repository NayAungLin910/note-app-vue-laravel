<template>
   <MyMaster>
       <div class="row">
           <MySideBar />
           <div class="col-md-2"></div>
           <div class="col-md-4">
                <div class="card text-white text-center">
                    <div class="card-header bg-primary">
                        <h6>{{ $root.user.name }}</h6>
                    </div>
                    <div class="card-body">
                        <img
                            :src="`${image_url}/${$root.user.image}`"
                            class="image-fluid rounded"
                            alt="your profile"
                            height="100"
                        />   
                    </div>
                    <div class="card-footer">
                        <p>
                            <span class="badge badge-success">Total Notes</span> <span class="badge badge-info">{{ note_count }}</span>
                            <br/>
                            <span class="badge badge-primary">Shared Notes</span> <span class="badge badge-info">{{ share_note_count }}</span>
                            <br/>
                            <span class="badge badge-secondary">Received Notes</span> <span class="badge badge-info">{{ receive_note_count }}</span>
                        </p>
                        
                    </div>
                </div>
           </div>
           <div class="col-md-2"></div>
       </div>
   </MyMaster> 
</template>
<script>
import MyMaster from './Layout/MyMaster.vue';
import MySideBar from './Layout/MySideBar.vue';
import { image_url, cusaxios } from '@/config';
export default {
    name: 'MyProfle',
    components: { MyMaster, MySideBar },
    data(){
        return{
            image_url,
            note_count: "",
            share_note_count: "",
            receive_note_count: "",
        }
    },
    created(){
        this.$root.current_page = "profile"
        cusaxios.get('/profile')
        .then(res=>{
            this.note_count = res.data.data.note_count;
            this.share_note_count = res.data.data.share_note_count;
            this.receive_note_count = res.data.data.receive_note_count;
        })
    },
    
}
</script>