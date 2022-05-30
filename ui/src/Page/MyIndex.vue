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
                                <a href="detail.html">
                                    <div class="card">
                                        <div class="card-header" :style="{ backgroundColor:n.color.name }">
                                            <h5 class="text-white">{{ n.name }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 text-center">
                                                    <a href="" class="badge badge-primary">
                                                        View
                                                    </a>
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <a href="" class="badge badge-warning">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </div>
                        <!-- For Load -->
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-primary btn-fab btn-icon btn-round">
                                    View More
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
        }
    },
    created(){
        this.$root.current_page = "index";

        const loader = this.$loading.show({
            loader: "bars",
            opacity: 0.3,
            backgroundColor: "black",
            color: "white",
        });
        cusaxios.get('/note/')
        .then(res => {
            const {data} = res.data;
            this.notes = data.data; 
            loader.hide();
        })
        
    }
}
</script>