<template>
    <MyMaster>
        <div class="row">
            <!-- For Category and Information -->
            <MySideBar :key="componentKey"/>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" :style="{backgroundColor:color}" :class="{'bg-dark': !isUpdate}">
                        <h3 class="text-white">{{ isUpdateTitle }}</h3>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="create">
                            <div class="form-group">
                                <input v-model="name" type="text" name="title" class="form-control border-0 bg-dark text-white"
                                    placeholder="enter title" id="">
                                <small class="text text-danger" v-if="error.name">{{ error.name[0] }}</small>
                            </div>
                            <div class="form-group">
                                <color :swatches="colorlist" v-model="color" inline background-color="32325D"/>
                                <small class="text text-danger" v-if="error.color_id">{{ error.color_id[0] }}</small>
                            </div>
                            <div class="form-group">
                                <select v-model="label_id" class="form-control bg-dark text-white">
                                    <option value="">Choose Label</option>
                                    <option 
                                    :value="l.id"
                                    :key="l.id" 
                                    v-for="l in ColorLabel.label"
                                    >
                                        {{ l.name }}
                                    </option>
                                </select>
                                <small class="text text-danger" v-if="error.label_id">{{ error.label_id[0] }}</small>
                            </div>
                            <div class="form-group" :style="{backgroundColor:color}">
                                <vue-editor v-model="description"></vue-editor>
                                <small class="text text-danger" v-if="error.description">{{ error.description[0] }}</small>
                            </div>
                            <button type="submit" class="btn btn-dark" :disabled="loading">
                                {{ btnName }}
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
import color from "vue3-swatches";
import { VueEditor } from "vue3-editor";
import MyMaster from './Layout/MyMaster.vue';
import { cusaxios } from "@/config";
import { useToast } from "vue-toastification";
import MySideBar from "./Layout/MySideBar.vue";

export default {
    name:"MyCreateNote",
    components:{ MyMaster, color, MySideBar, VueEditor },
    data(){
        return{
            color:"#85DED7",
            colorlist:[],
            label_id:"",
            name:"",
            description:"",
            loading:false,
            error:{},
            btnName:"Create",
            componentKey: 0,
            ColorLabel:{
                color:[],
                label:[],
                share_note:[],
                receive_note:[],
            }// need this so that when logged out and log in to another account the label data will not be the previous one
        };
    },
    created(){
        this.$root.current_page = "create-note";
        cusaxios.get(`/colorlabel`)
            .then(res=>{
                this.ColorLabel = res.data.data;    
            });
        const {params} = this.$route;
        if(params.slug){
            this.btnName = "Edit";
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

            cusaxios.get(`/note/${params.slug}`)
            .then(res=>{
                loader.hide();
                const {data, success} = res.data;
                if(success){
                    this.name = data.name;
                    this.label_id = data.label_id;
                    this.description = data.description;
                    this.color = data.color.name;
                }
            })
        }    
        this.$root.ColorLabel.color.map(c=>{
                this.colorlist.push(c.name);
        })
    },
    watch:{
        '$root.ColorLabel.color'(){
            this.$root.ColorLabel.color.map(c=>{
                this.colorlist.push(c.name);
            })
        }
    },
    methods:{
        forceRerender() {
            this.componentKey += 1;
        },
        async create(){
            // check update or create
            var url = "/note/create";
            if(this.isUpdate){
                url = "/note/edit/"+this.$route.params.slug;
            }

            this.loading = true;
            const c = this.$root.ColorLabel.color.filter(c=>{
                return c.name == this.color;
            });
            const color_id = c[0].id;
            const res = await cusaxios.post(url, {
                name:this.name,
                label_id:this.label_id,
                color_id,
                description:this.description,
            });
            this.loading = false;
            const toast = useToast();
            if(res.data.success){
                if(this.isUpdate){
                    this.forceRerender();
                    toast.success("Updated successfully !", {
                        timeout: 2000,
                    })
                    this.$router.push("/note/" + res.data.data.slug);
                }else{
                    // this.$root.ColorLabel.label.find(l => {
                    //     if(l.id == this.label_id){
                    //         l.note_count++;
                    //     }
                    // }) // you fixed this by using the forecerenderer method you found on stackoverflow and also by using local var at side bay component
                    this.forceRerender();
                    toast.success("Created successfully !", {
                        timeout: 2000,
                    });
                }
            }else{
                this.error = res.data.data;
            }
        },
    },
    computed:{
        isUpdate(){
            const {params} = this.$route;
            if(params.slug){
                return true;
            }else{
                return false;
            }
        },
        isUpdateTitle(){
            const {params} = this.$route;
            if(params.slug){
                return "Edit Note";
            }else{
                return "Create Note";
            }  
        }
    }
}
</script>