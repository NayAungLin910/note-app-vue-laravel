<template>
    <MyMaster>
        <div class="row">
            <!-- For Category and Information -->
            <MySideBar />
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="text-white">Create Note</h3>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="create">
                            <div class="form-group">
                                <input v-model="name" type="text" name="title" class="form-control border-0 bg-dark"
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
                                    v-for="l in $root.ColorLabel.label"
                                    >
                                        {{ l.name }}
                                    </option>
                                </select>
                                <small class="text text-danger" v-if="error.label_id">{{ error.label_id[0] }}</small>
                            </div>
                            <div class="form-group">
                                <editor
                                id = "demo" 
                                v-model="description" 
                                api-key="x4gq5qn987chdhj1z8n99c6c3l63nj4bobfc940pyxb5w5tq"
                                :init="{
                                    height: 300,
                                    menubar: false,
                                    plugins: [
                                        'advlist autolink lists link image charmap print preview anchor',
                                        'searchreplace visualblocks code fullscreen',
                                        'insertdatetime media table paste code help wordcount'
                                    ],
                                    toolbar:
                                        'undo redo | formatselect | bold italic backcolor | \
                                        alignleft aligncenter alignright alignjustify | \
                                        bullist numlist outdent indent | removeformat | help',
                                }"
                                />
                                <small class="text text-danger" v-if="error.description">{{ error.description[0] }}</small>
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
import color from "vue3-swatches";
import Editor from '@tinymce/tinymce-vue';
import MyMaster from './Layout/MyMaster.vue';
import { cusaxios } from "@/config";
import { useToast } from "vue-toastification";
import MySideBar from "./Layout/MySideBar.vue";

export default {
    name:"MyCreateNote",
    components:{ MyMaster, color, MySideBar, Editor },
    data(){
        return{
            color:"#3398DB",
            colorlist:[],
            label_id:"",
            name:"",
            description:"",
            loading:false,
            error:{},
        };
    },
    created(){
        this.$root.current_page = "create_note";    
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
        async create(){
            this.loading = true;
            const c = this.$root.ColorLabel.color.filter(c=>{
                return c.name == this.color;
            });
            const color_id = c[0].id;
            const res = await cusaxios.post('/note/create', {
                name:this.name,
                label_id:this.label_id,
                color_id,
                description:this.description,
            });
            this.loading = false;
            const toast = useToast();
            if(res.data.success){
                toast.success("Note created successfully !", {
                    timeout: 2000,
                })
            }else{
                this.error = res.data.data;
            }
        },
    },
}
</script>