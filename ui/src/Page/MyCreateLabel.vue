<template>
    <MyMaster>
        <div class="row">
            <MySideBar />
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 style="color:white">Create Label</h3>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="create" class="text-white">
                            <div class="form-group">
                                <label for="" class="text-white">Enter Title</label>
                                <input
                                :class="{'border-danger':error.name}" 
                                type="text" 
                                v-model="name" 
                                name="name"
                                class="form-control border bg-dark text-white"
                                placeholder="enter title" 
                                >
                                <small class="text text-danger" v-if="error.name">{{ error.name[0] }}</small>
                            </div>
                            <button type="submit" class="btn btn-dark" :disabled="loading">
                                Create
                                <span v-show="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                        </form>
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
import { useToast } from 'vue-toastification';
export default {
    name:"MyCreateLabel",
    components: { MyMaster, MySideBar },
    data(){
        return{
            name:"",
            loading:false,
            error:{},
        }
    },
    created(){
        this.$root.current_page = 'create-label';
    },
    methods:{
        async create(){
            this.loading = true;
            const res = await cusaxios.post("/label/create", {
                name: this.name,
            });
            this.loading = false;
            const {data, success} = res.data;
            if(success == false){
                this.error = data;
            }else{
                const toast = useToast();
                toast.success("Title Created Successfully!", {
                    timeout: 2000,
                })
            }
        },
    }
}
</script>