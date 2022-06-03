<template>
    <MyMaster>
            <div class="row">
            <!-- For Category and Information -->
            <MySideBar />
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Loop Product -->
                            <div class="col-md-4" v-for="n in notes" :key="n.id">
                                <router-link :to="`/note/${n.slug}`">
                                    <div class="card">
                                        <div class="card-header" :style="{ backgroundColor:n.color.name }">
                                            <h5 class="text-white">{{ n.name }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 text-center">
                                                    <a href="" class="badge badge-primary">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <router-link :to="`/note/contribute/${n.slug}`" class="badge badge-warning">
                                                        <i class="fa-solid fa-share"></i>
                                                    </router-link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>

                            </div>
                        </div>
                        <!-- For Load -->
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button
                                 @click="loadMore" 
                                 class="btn btn-primary btn-fab btn-icon btn-round"
                                 v-show="page !== null"
                                 >
                                    <i class="fa-solid fa-arrow-down"></i>
                                </button>
                            </div>
                        </div>
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
    name: 'MyIndex',
    components: { MyMaster, MySideBar },
    data(){
        return{
            notes:[],
            page:1,
            route:'/note',
        }
    },
    created(){
        this.$root.current_page = "index";
        if(this.$route.params.slug){
            this.route = "/note/label/"+this.$route.params.slug;
        }
        const loader = this.$loading.show({
            loader: "bars",
            opacity: 0.3,
            backgroundColor: "black",
            color: "white",
        });

        const auth = localStorage.getItem('auth');
        if(auth && auth !== 'null'){
            const token = JSON.parse(auth).token;
            cusaxios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        
        cusaxios.get(this.route)
        .then(res => {
            loader.hide();
            const {data} = res.data;
            if(data.next_page_url == null){
                    this.page = null;
            }
            this.notes = data.data; 
        })
    },
    methods: {
        loadMore(){
            this.page++;
            const loader = this.$loading.show({
                loader: "bars",
                opacity: 0.3,
                backgroundColor: "black",
                color: "white",
            });    
            cusaxios.get(this.route+'?page='+this.page)
            .then(res => {
                loader.hide();
                const {data} = res.data;
                if(data.next_page_url == null){
                    this.page = null;
                }
                this.notes = [...this.notes, ...data.data]  ;
                console.log(this.notes);
            });
        },
    }
}
</script>