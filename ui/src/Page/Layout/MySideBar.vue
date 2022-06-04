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
                            Received Notes
                            <a href="" class="badge badge-dark  text-white float-right">All</a>
                        </li>
                        <ul class="list-group label">
                            <li 
                                class="list-group-item bg-dark text-white" 
                                v-for="n in ColorLabel.receive_note"
                                :key="n.id"
                            >
                                <i class="far fa-newspaper"></i>
                                &nbsp; &nbsp;
                                {{ n.note.name }}
                                <small> from </small>
                                <b class="text-primary">{{ n.share.name }}</b>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <li class="list-group-item bg-bg text-white">
                            Shared Notes
                            <a href="" class="badge badge-dark  text-white float-right">All</a>
                        </li>
                        <ul class="list-group label">
                            <li 
                                class="list-group-item bg-dark text-white" 
                                v-for="n in ColorLabel.share_note"
                                :key="n.id"
                            >
                                <i class="far fa-newspaper"></i>
                                &nbsp; &nbsp;
                                {{ n.note.name }}
                                <small> to </small>
                                <b class="text-primary">{{ n.receiver.name }}</b>
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
                share_note:[],
                receive_note:[],
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