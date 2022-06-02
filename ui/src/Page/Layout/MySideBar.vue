<template>
    <div class="col-md-4">
                <div class="card bg-gray-100">
                    <div class="card-body">
                        <li class="list-group-item bg-bg text-white">
                            Label
                        </li>
                        <ul class="list-group label">
                            <router-link
                             v-for="l in ColorLabel.label" 
                             :key="l.id" 
                             :to="`/note/label/${l.slug}`">
                                <li 
                                class="list-group-item bg-dark" 
                                :class="{
                                    'text-success':l.slug == $route.params.slug,
                                    'text-white':l.slug !== $route.params.slug,
                                }"
                                >
                                    <span class="fas fa-tags text-white text-small"></span>
                                    &nbsp; &nbsp;
                                    {{ l.name }}
                                    <span class="badge badge-primary float-right">{{ l.note_count }}</span>
                                    </li>
                            </router-link>
                        </ul>
                    </div>
                </div>

                <div class="card bg-gray-100">
                    <div class="card-body">
                        <li class="list-group-item bg-bg text-white">
                            Contribute Notes
                            <a href="" class="badge badge-dark  text-white float-right">All</a>
                        </li>
                        <ul class="list-group label">
                            <li class="list-group-item bg-dark text-white">
                                <i class="far fa-newspaper"></i>
                                &nbsp; &nbsp;
                                Laravel Note
                                <small> from</small>
                                <b class="text-primary">Myo Thant Kyaw</b>
                            </li>
                            <li class="list-group-item bg-dark text-white">
                                <i class="far fa-newspaper"></i>
                                &nbsp; &nbsp;
                                Vue Note
                                <small> from</small>
                                <b class="text-primary">Myo Thant Kyaw</b>
                            </li>
                            <li class="list-group-item bg-dark text-white">
                                <i class="far fa-newspaper"></i>
                                &nbsp; &nbsp;
                                Income Note
                                <small> from</small>
                                <b class="text-primary">Myo Thant Kyaw</b>
                            </li>
                        </ul>
                    </div>
                </div>

    </div>
</template>
<script>
import { cusaxios } from '@/config';
export default {
    data(){
        return{
            ColorLabel:{
                color:[],
                label:[],
            }
        }
    },
    name:"MySideBar",
    created(){
        cusaxios.get(`/colorlabel`)
            .then(res=>{
                this.ColorLabel = res.data.data;    
            });
    }
}
</script>