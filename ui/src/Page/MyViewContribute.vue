<template>
    <MyMaster>
        <div class="row">
            <MySideBar :key="componentKey"/>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="text-white">Contribted</h3>
                    </div>
                    <div class="card-body">
                        <router-link 
                            to="/contribute/receive"  
                            class="btn btn-sm text-white"
                            :class="{'btn-success':$attrs.option=='receive'}"
                        >
                            Contributed By Other
                        </router-link>
                        <router-link 
                            to="/contribute/share" 
                            class="btn btn-sm text-white"
                            :class="{'btn-success':$attrs.option=='share'}"
                        >
                            Notes You Contributed
                        </router-link>
                        <ul class="list-group bg-dark" v-show="$attrs.option=='share'">
                            <li class="list-group-item bg-dark text-white" v-for="n in data.share_note" :key="n.id">
                                <small>
                                    {{ n.note.name }}
                                    <span class="text text-success">
                                        is shared to
                                        <b class="text text-primary">{{ n.receiver.name }}</b>
                                    </span>
                                </small>
                                <router-link :to="`/note/${n.note.slug}`" class="badge badge-primary float-right">
                                    <i class="fas fa-eye"></i>
                                </router-link>
                            </li>
                        </ul>
                        <ul class="list-group bg-dark" v-show="$attrs.option=='receive'">
                            <li class="list-group-item bg-dark text-white" v-for="n in data.receive_note" :key="n.id">
                                <small>
                                    {{ n.note.name }}
                                    <span class="text text-success">
                                        is received from
                                        <b class="text text-primary">{{ n.share.name }}</b>
                                    </span>
                                </small>
                                <router-link :to="`/note/${n.note.slug}`" class="badge badge-primary float-right">
                                    <i class="fas fa-eye"></i>
                                </router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </MyMaster>
</template>
<script>
import MyMaster from './Layout/MyMaster.vue';
import MySideBar from './Layout/MySideBar.vue';
import { cusaxios } from '@/config';
export default {
    name: "MyViewContribute",
    components: { MyMaster, MySideBar },
    props:{message: Object},
    data(){
        return{
            data: '',
        }
    },
    created(){
        cusaxios.get('/contribute')
        .then(res=>{
            this.data = res.data.data;
        })
    }
};
</script>